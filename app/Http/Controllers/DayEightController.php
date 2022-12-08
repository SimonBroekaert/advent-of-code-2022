<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DayEightController extends Controller
{
    public function __invoke(): View
    {
        $forest = $this->getForest();

        $question1 = "Amount of trees visible from outside the grid";

        $lastRow = $forest->max('row');
        $lastColumn = $forest->max('column');
        $answer1 = $forest->filter(function ($tree) use ($forest, $lastRow, $lastColumn) {
            if ($tree->row === 0 || $tree->row === $lastRow || $tree->column === 0 || $tree->column === $lastColumn) {
                return true;
            }
            $visibleFromLeft = $forest->where('column', '<', $tree->column)
                ->where('row', $tree->row)
                ->max('height') < $tree->height;
            $visibleFromRight = $forest->where('column', '>', $tree->column)
                ->where('row', $tree->row)
                ->max('height') < $tree->height;
            $visibleFromTop = $forest->where('row', '<', $tree->row)
                ->where('column', $tree->column)
                ->max('height') < $tree->height;
            $visibleFromBottom = $forest->where('row', '>', $tree->row)
                ->where('column', $tree->column)
                ->max('height') < $tree->height;

            return $visibleFromLeft || $visibleFromRight || $visibleFromTop || $visibleFromBottom;
        })->sum();

        $question2 = null;
        $answer2 = null;

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }

    private function getForest(): Collection
    {
        $file = Storage::disk('public')->get('day-8.txt');

        return collect(explode("\n", $file))
            ->filter(fn ($line) => $line !== '')
            ->map(function ($line, $row) {
                return collect(str_split($line))
                    ->map(function ($height, $column) use ($row) {
                        return (object) [
                            'row' => $row,
                            'column' => $column,
                            'height' => (int) $height,
                        ];
                    })
                    ->toArray();
            })
            ->flatten(1);
    }
}
