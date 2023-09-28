<div class="flashcards_container">
  @if (!$isEmpty)
  <div wire:click="flip" class="{{ $style }}">
    {{ $isFront ? $set->flashcards->all()[$currentCard]->question : $set->flashcards->all()[$currentCard]->answer }}
  </div>
  <div class="arrows">
    <button wire:click="previousCard"><-</button>
    <button wire:click="nextCard">-></button>
  </div>
  @endif
</div>
