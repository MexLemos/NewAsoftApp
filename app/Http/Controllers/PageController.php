<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function cursos()
    {
        return view('pages.cursos');
    }

    public function produtos()
    {
        return view('pages.produtos');
    }
}
