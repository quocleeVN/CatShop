<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $featuredCats = collect();

        if (Schema::hasTable('cats')) {
            $featuredCats = Cat::with('breed')
                ->where('stock_status', 'available')
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        return view('home', compact('featuredCats'));
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }
}
