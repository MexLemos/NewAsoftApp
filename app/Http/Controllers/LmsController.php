<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function dashboard()
    {
        return view('lms.dashboard');
    }

    public function lesson($course, $lesson)
    {
        // Mocking the lesson logic for now
        return view('lms.lesson');
    }
}
