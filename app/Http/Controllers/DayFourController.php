<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayFourController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-4.txt');

        $pairs = collect(explode("\n", $file))
            ->filter(fn ($line) => $line !== '')
            ->map(function ($pair) {
                $pair = explode(',', $pair);
                $left = explode('-', $pair[0]);
                $left = range((int) $left[0], (int) $left[1]);
                $right = explode('-', $pair[1]);
                $right = range((int) $right[0], (int) $right[1]);

                return [
                    'left' => $left,
                    'right' => $right,
                ];
            });

        $question1 = 'Total overlapping assignment pairs';
        $answer1 = $pairs
            ->map(function ($pair) {
                return
                    count(array_diff($pair['left'], $pair['right'])) === 0 ||
                    count(array_diff($pair['right'], $pair['left'])) === 0;
            })
            ->filter()
            ->count();

        $question2 = 'Total assignment pairs with at least 1 overlapping sections';
        $answer2 = $pairs
            ->map(function ($pair) {
                return
                    count(array_diff($pair['left'], $pair['right'])) < count($pair['left']) ||
                    count(array_diff($pair['right'], $pair['left'])) < count($pair['right']);
            })
            ->filter()
            ->count();

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
