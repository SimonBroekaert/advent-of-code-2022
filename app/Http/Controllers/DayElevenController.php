<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DayElevenController extends Controller
{
    public function __invoke(): View
    {
        $question1 = null;
        $answer1 = null;

        $question2 = null;
        $answer2 = null;

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }
}
