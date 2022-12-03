<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayThreeController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-3.txt');

        $rucksacks = collect(explode("\n", $file))
            ->filter(fn ($line) => $line !== '')
            ->map(function ($rucksack) {
                $contents = str_split($rucksack, strlen($rucksack) / 2);
                return [
                    'all' => str_split($rucksack),
                    'left' => str_split($contents[0]),
                    'right' => str_split($contents[1]),
                ];
            });

        $priorityList = [
            ...range('a', 'z'),
            ...range('A', 'Z')
        ];

        $question1 = 'Sum of the priority values of all items that are in both compartments of a rucksack';
        $answer1 = $rucksacks->map(function ($rucksack) use ($priorityList) {
            $matchingLetters = collect($rucksack['left'])
                ->filter(function ($letter) use ($rucksack) {
                    return in_array($letter, $rucksack['right']);
                })
                ->unique();

            return $matchingLetters->map(function ($letter) use ($priorityList) {
                $priority = array_search($letter, $priorityList);

                if ($priority === false) {
                    return null;
                }

                return $priority + 1;
            })->filter(fn ($priority) => !is_null($priority))
                ->sum();
        })->sum();

        $question2 = "The sum of the identifying priority items of each group of 3 rucksacks";
        $answer2 = $rucksacks->chunk(3)
            ->map(function ($rucksackGroup) use ($priorityList) {
                $firstRucksack = collect($rucksackGroup->first()['all']);
                $otherRucksacks = $rucksackGroup->slice(1);
                foreach ($otherRucksacks as $otherRucksack) {
                    $firstRucksack = $firstRucksack->intersect($otherRucksack['all']);
                }
                $identifier = $firstRucksack->unique()->first();

                $priority = array_search($identifier, $priorityList);

                if ($priority === false) {
                    return null;
                }

                return $priority + 1;
            })->filter()->sum();

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
