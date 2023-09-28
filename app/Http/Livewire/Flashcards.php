<?php

namespace App\Http\Livewire;

use App\Models\Set;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Flashcards extends Component
{
    public Set $set;
    public bool $isEmpty;
    public bool $isFront = true;
    public int $currentCard = 0;
    public string $style = 'card';
    public function render(): View
    {
        $this->set->flashcards()->count() === 0 ? $this->isEmpty = true : $this->isEmpty = false;
        return view('livewire.flashcards');
    }

    public function nextCard(): void
    {
        $this->currentCard = ($this->currentCard + 1) % $this->set->flashcards()->count();
    }

    public function previousCard(): void
    {
        $this->currentCard = ($this->currentCard - 1 + $this->set->flashcards()->count()) %
            $this->set->flashcards()->count();
    }

    public function flip(): void
    {
        $this->isFront = !$this->isFront;
        $this->style = $this->isFront ? 'card' : 'card flip';
    }
}
