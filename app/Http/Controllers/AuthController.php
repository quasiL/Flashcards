<?php

namespace App\Http\Controllers;

use App\Jobs\SendRegisterEmail;
use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Returns the register view for a guest user.
     * Redirects to the home page if the user is logged in.
     *
     * @return Factory|View|Application
     */
    public function register(): Factory|View|Application
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('register');
    }

    /**
     * Validates the register credentials.
     * If valid, creates a new user, sends an activation email and redirects to the login page.
     * If invalid, redirects to the register page.
     *
     * @param Request $request
     * @return Redirector|Application|RedirectResponse
     */
    public function registerPost(Request $request): Redirector|Application|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = Hash::make($request->input('password'));
        $user = User::create($data);
        if (!$user) {
            Log::alert('User is not created');
            return redirect(route('register'))->withErrors('Something went wrong');
        }

        $token = Str::random(45);
        User::where('email', $data["email"])
            ->update(['verification_token' => $token]);

        SendRegisterEmail::dispatch($data["email"], $token);
        return redirect(route('login'))->with('success', 'User created successfully');
    }

    /**
     * If the user used his the email verification token, redirects to the login page.
     * If the token is invalid, redirects to the register page.
     *
     * @param string $token
     * @return Redirector|Application|RedirectResponse
     */
    public function confirmEmail(string $token): Redirector|Application|RedirectResponse
    {
        $user = User::where('verification_token', $token)
            ->update(['email_verified_at' => now(), 'verification_token' => null]);
        if (!$user) {
            return redirect(route('register'))->withErrors('Invalid token!');
        }
        return redirect(route('login'))->with('success', 'Email verified successfully');
    }

    /**
     * Returns the login view for a guest user.
     * Redirects to the home page if the user is logged in.
     *
     * @return Factory|View|Application
     */
    public function login(): Factory|View|Application
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('login');
    }

    /**
     * Validates the login credentials.
     * If valid, logs the user in and redirects to the home page.
     * If invalid, redirects to the login page.
     *
     * @param Request $request
     * @return Redirector|RedirectResponse|Application
     */
    public function loginPost(Request $request): Redirector|RedirectResponse|Application
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->input('email'))->first();
        if ($user->toArray()['email_verified_at'] === null) {
            return redirect(route('login'))->withErrors('Please verify your email first');
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }
        return redirect(route('login'))->withErrors('Invalid credentials');
    }

    /**
     * Returns the forgot password view for a guest user.
     * Redirects to the home page if the user is logged in.
     *
     * @return Factory|View|Application
     */
    public function forgotPassword(): Factory|View|Application
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('forgot-password');
    }

    /**
     * If the user fills the email field, sends an email with a link to reset the password.
     * If the email is invalid, redirects to the forgot password page.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgotPasswordPost(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $token = Str::random(64);
        $email = $request->input('email');
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::to($email)->send(new PasswordReset($token));
        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    /**
     * Returns the reset password view for a guest user.
     *
     * @param string $token
     * @return Factory|View|Application
     */
    public function resetPassword(string $token): Factory|View|Application
    {
        return view('reset-password', compact('token'));
    }

    /**
     * If the token is valid, updates the user's password.
     * If the token is invalid, redirects to the reset password page.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPasswordPost(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:3',
            'confirm_password' => 'required|same:password'
        ]);
        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->input('email'),
            'token' => $request->input('token')
        ])->first();
        if (!$updatePassword) {
            return redirect()->to(route('reset.password'))->withErrors('Invalid token!');
        }
        User::where('email', $request->input('email'))->update([
            'password' => Hash::make($request->input('password'))
        ]);
        DB::table('password_resets')->where(['email' => $request->input('email')])->delete();
        return redirect()->to(route('login'))->with('success', 'Your password has been changed!');
    }

    /**
     * Logout the logged-in user.
     * Redirects to the login page.
     *
     * @return Redirector|Application|RedirectResponse
     */
    public function logout(): Redirector|Application|RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
