<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayController extends Controller
{
    public function one(): View
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

        $mostCalories = $elfInventories->first()->total;
        $caloriesOfTop3 = $elfInventories->take(3)->sum('total');

        return view('day-1', compact('mostCalories', 'caloriesOfTop3'));
    }
}
