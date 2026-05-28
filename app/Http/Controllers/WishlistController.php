<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function toggle(Request $request, int $catId): RedirectResponse|JsonResponse
    {
        $user = auth()->user();
        $existing = $user->wishlistItems()->where('cat_id', $catId)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Đã xóa khỏi danh sách yêu thích.';
            $added = false;
        } else {
            $user->wishlistItems()->create(['cat_id' => $catId]);
            $message = 'Đã thêm vào danh sách yêu thích.';
            $added = true;
        }

        $count = $user->wishlistItems()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'added' => $added,
                'removed' => !$added,
                'count' => $count,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
