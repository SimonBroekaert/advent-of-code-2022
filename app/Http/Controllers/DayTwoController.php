<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DayTwoController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-2.txt');

        // Split collection per empty line
        $games = collect(explode("\n", $file))
            ->filter(fn ($line) => $line !== '')
            ->map(function ($game) {
                $content = explode(' ', $game);
                return [
                    'enemy' => match ($content[0]) {
                        'A' => 'rock',
                        'B' => 'paper',
                        'C' => 'scissors',
                    },
                    'unknown' => $content[1],
                ];
            });

        $question1 = 'Total score if second data value is your choice';
        $answer1 = $games->map(function ($game) {
            $game['you'] = match ($game['unknown']) {
                'X' => 'rock',
                'Y' => 'paper',
                'Z' => 'scissors',
            };

            $game['result'] = match ($game['enemy']) {
                'rock' => match ($game['you']) {
                    'rock' => 'draw',
                    'paper' => 'win',
                    'scissors' => 'lose',
                },
                'paper' => match ($game['you']) {
                    'rock' => 'lose',
                    'paper' => 'draw',
                    'scissors' => 'win',
                },
                'scissors' => match ($game['you']) {
                    'rock' => 'win',
                    'paper' => 'lose',
                    'scissors' => 'draw',
                },
            };

            $game['score'] = match ($game['result']) {
                'win' => 6,
                'draw' => 3,
                'lose' => 0,
            }
                + match ($game['you']) {
                    'rock' => 1,
                    'paper' => 2,
                    'scissors' => 3,
                };

            return $game;
        })->sum('score');

        $question2 = 'Total score if second data value is the outcome';
        $answer2 = $games->map(function ($game) {
            $game['result'] = match ($game['unknown']) {
                'X' => 'lose',
                'Y' => 'draw',
                'Z' => 'win',
            };

            $game['you'] = match ($game['enemy']) {
                'rock' => match ($game['result']) {
                    'lose' => 'scissors',
                    'draw' => 'rock',
                    'win' => 'paper',
                },
                'paper' => match ($game['result']) {
                    'lose' => 'rock',
                    'draw' => 'paper',
                    'win' => 'scissors',
                },
                'scissors' => match ($game['result']) {
                    'lose' => 'paper',
                    'draw' => 'scissors',
                    'win' => 'rock',
                },
            };

            $game['score'] = match ($game['result']) {
                'win' => 6,
                'draw' => 3,
                'lose' => 0,
            }
                + match ($game['you']) {
                    'rock' => 1,
                    'paper' => 2,
                    'scissors' => 3,
                };

            return $game;
        })->sum('score');

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
