<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DaySixController extends Controller
{
    public function __invoke(): View
    {
        $file = Storage::disk('public')->get('day-6.txt');

        $sequence = str_split(trim($file));

        $question1 = 'Amount of characters processed before the first start-of-packet';

        $startOfPocket = null;
        foreach ($sequence as $key => $character) {
            if ($key < 3 || !is_null($startOfPocket)) {
                continue;
            }

            $subArray = array_slice($sequence, $key - 3, 4);

            if (array_unique($subArray) === $subArray) {
                $startOfPocket = $key + 1;
            }
        }

        $answer1 = $startOfPocket;

        $question2 = 'Amount of characters processed before the first start-of-message';

        $startOfMessage = null;
        foreach ($sequence as $key => $character) {
            if ($key < 13 || !is_null($startOfMessage)) {
                continue;
            }

            $subArray = array_slice($sequence, $key - 13, 14);

            if (array_unique($subArray) === $subArray) {
                $startOfMessage = $key + 1;
            }
        }
        $answer2 = $startOfMessage;

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
