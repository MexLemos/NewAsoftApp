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

    public function produtos(Request $request)
    {
        $query = \App\Models\Product::query();
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }
        
        $order = $request->get('sort', 'recentes');
        if ($order == 'menor_preco') {
            $query->orderBy('price', 'asc');
        } elseif ($order == 'maior_preco') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(9)->withQueryString();
        $categories = \App\Models\ProductCategory::withCount('products')->get();
        $totalProducts = \App\Models\Product::count();
        
        return view('pages.produtos', compact('products', 'categories', 'totalProducts'));
    }
}
