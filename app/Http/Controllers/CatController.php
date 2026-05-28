<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\CatBreed;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatController extends Controller
{
    public function index(Request $request): View
    {
        $query = Cat::with('breed')->where('stock_status', 'available');

        // Lọc theo giống
        if ($request->filled('breed')) {
            $query->ofBreed($request->breed);
        }

        // Lọc theo giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Lọc theo giới tính
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'oldest'     => $query->orderBy('created_at'),
            default      => $query->latest(),
        };

        $cats = $query->paginate(12)->withQueryString();
        $breeds = CatBreed::orderBy('breed_name')->get();

        return view('cats.index', compact('cats', 'breeds'));
    }

    public function show(Cat $cat): View
    {
        $cat->load('breed', 'reviews.user');
        $canReview = auth()->check() && auth()->user()->hasPurchasedCat($cat->cat_id);

        $similarCats = Cat::where('breed_id', $cat->breed_id)
            ->where('cat_id', '!=', $cat->cat_id)
            ->where('stock_status', 'available')
            ->limit(4)
            ->get();

        return view('cats.show', compact('cat', 'similarCats', 'canReview'));
    }
}
