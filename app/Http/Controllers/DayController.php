<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DayController extends Controller
{
    public function __invoke(): View
    {
        return view('days.index');
    }
}
