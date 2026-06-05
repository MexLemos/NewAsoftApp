<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $courses = \App\Models\Course::where('is_published', true)->take(3)->get();
        $products = \App\Models\Product::where('is_featured', true)->latest()->take(3)->get();
        $services = \App\Models\Service::where('is_featured', true)->latest()->take(3)->get();
        $partners = \App\Models\Partner::orderBy('id', 'asc')->get();
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        return view('pages.home', compact('courses', 'products', 'services', 'partners', 'settings'));
    }

    public function cursos()
    {
        $courses = \App\Models\Course::where('is_published', true)->with('category')->get();
        return view('pages.cursos', compact('courses'));
    }

    public function produtos()
    {
        $products = \App\Models\Product::latest()->get();
        return view('pages.produtos', compact('products'));
    }
}
