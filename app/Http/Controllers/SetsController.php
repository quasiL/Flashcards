<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetsController extends Controller
{

    /**
     * If user is logged in redirect to user's sets
     *
     * @return View
     */
    public function index(): View
    {
        Auth::check() ? $userId = Auth::id() : $userId = null;
        $sets = DB::table('sets')->where('user_id', $userId)->get();
        return view('sets')->with('sets', $sets);
    }

    /**
     * Returns the create set view
     *
     * @return View
     */
    public function create(): View
    {
        return view('create-set');
    }

    /**
     * Creates a new set and redirects to the list of sets page
     *
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'set-name' => 'required|max:255'
        ]);
        Set::create([
            'name' => $request->input('set-name'),
            'number' => $this->generateNumber(),
            'user_id' => Auth::id()
        ]);
        return redirect()->route('sets.index')->with('success', 'Set created successfully');
    }

    /**
     * If the set with the given number exists redirect to that set
     * If the set does not exist then redirect to 404
     *
     * @param int $number
     * @return View
     */
    public function show(int $number): View
    {
        $set = Set::with('flashcards')->where('number', $number)->first();
        if ($set === null) {
            abort(404);
        }
        return view('set')->with('set', $set);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    /**
     * Generates a unique 6 digit number
     *
     * @throws Exception
     */
    private function generateNumber(): int
    {
        $newNumber = random_int(100000, 999999);
        while (Set::where('number', $newNumber)->exists()) {
            $newNumber = random_int(100000, 999999);
        }
        return $newNumber;
    }
}
