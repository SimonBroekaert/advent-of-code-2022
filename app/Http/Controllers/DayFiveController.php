<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayFiveController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-5.txt');

        $stacks = $this->getStacks($file);
        $instructions = $this->getInstructions($file);

        $question1 = 'Crate ids from crates on top of each stack if crane moves crates one by one';

        $stacksAnswer1 = $stacks->toArray();
        foreach ($instructions as $instruction) {
            $values = array_splice($stacksAnswer1[$instruction->start], 0, $instruction->amount);
            array_unshift($stacksAnswer1[$instruction->end], ...array_reverse($values));
        }

        $answer1 = collect($stacksAnswer1)->map(function ($stack) {
            return array_shift($stack);
        })->implode('');

        $question2 = 'Crate ids from crates on top of each stack if crane moves crates stack by stack';

        $stacksAnswer2 = $stacks->toArray();
        foreach ($instructions as $instruction) {
            $values = array_splice($stacksAnswer2[$instruction->start], 0, $instruction->amount);
            array_unshift($stacksAnswer2[$instruction->end], ...$values);
        }

        $answer2 = collect($stacksAnswer2)->map(function ($stack) {
            return array_shift($stack);
        })->implode('');

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }

    private function getStacks(string $file): Collection
    {
        $lines = collect(explode("\n", $file));

        $levels = $lines->takeUntil('')
            ->slice(0, -1)
            ->map(function ($level) {
                return collect(str_split($level))
                    ->chunk(4)
                    ->map(function ($spot) {
                        $crateId = $spot->values()->get(1);
                        return ctype_alnum($crateId) ? $crateId : null;
                    });
            });

        $longestLevel = $levels->map(function ($level) {
            return $level->count();
        })->sortDesc()->first();

        $levels = $levels->map(function ($level) use ($longestLevel) {
            return $level->pad($longestLevel, null);
        });

        $stacks = [];
        foreach ($levels as $level => $contents) {
            foreach ($contents as $stack => $crateId) {
                $stacks[$stack] = $stacks[$stack] ?? [];
                if ($crateId) {
                    $stacks[$stack][] = $crateId;
                }
            }
        }

        return collect($stacks);
    }

    private function getInstructions(string $file): Collection
    {
        $lines = collect(explode("\n", $file));

        return $lines->skipUntil('')
            ->filter(fn ($line) => $line !== '')
            ->map(function ($instruction) {
                return (object) [
                    'amount' => (int) Str::between($instruction, 'move ', ' from'),
                    'start' => (int) Str::between($instruction, 'from ', ' to') - 1,
                    'end' => (int) Str::after($instruction, 'to ') - 1,
                ];
            });
    }
}
