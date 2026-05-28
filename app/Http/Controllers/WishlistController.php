<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlistItems = auth()->user()
            ->wishlistItems()
            ->with('cat.breed')
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(int $catId): RedirectResponse
    {
        $user = auth()->user();
        $existing = $user->wishlistItems()->where('cat_id', $catId)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            $user->wishlistItems()->create(['cat_id' => $catId]);
            $message = 'Đã thêm vào danh sách yêu thích.';
        }

        return back()->with('success', $message);
    }
}
