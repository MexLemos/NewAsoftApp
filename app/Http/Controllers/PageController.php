<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $courses = \App\Models\Course::latest()->take(3)->get();
        $products = \App\Models\Product::latest()->take(3)->get();
        $services = \App\Models\Service::latest()->take(6)->get();
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        return view('pages.home', compact('courses', 'products', 'services', 'settings'));
    }

    public function cursos()
    {
        $courses = \App\Models\Course::where('is_published', true)->with('category')->get();
        return view('pages.cursos', compact('courses'));
    }

    public function produtos()
    {
        return view('pages.produtos');
    }
}
