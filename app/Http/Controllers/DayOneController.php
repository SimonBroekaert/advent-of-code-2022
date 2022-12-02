<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayOneController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-1.txt');

        // Split collection per empty line
        $elfInventories = collect(explode("\n\n", $file))
            ->map(function ($elfInventory) {
                $elfInventory = collect(explode("\n", $elfInventory))->map(fn ($line) => (int) $line);
                return (object) [
                    'inventory' => $elfInventory,
                    'total' => collect($elfInventory)->sum(),
                ];
            })
            ->sortByDesc('total');

        $question1 = 'The most calories a single elf is carrying';
        $answer1 = $elfInventories->first()->total;

        $question2 = 'The total of the top 3 carrying elves';
        $answer2 = $elfInventories->take(3)->sum('total');

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
