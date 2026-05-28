<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Cat;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Cat $cat): RedirectResponse
    {
        if (! $request->user()->hasPurchasedCat($cat->cat_id)) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi đã mua và nhận sản phẩm này.');
        }

        $request->user()->reviews()->updateOrCreate(
            ['cat_id' => $cat->cat_id],
            $request->validated()
        );

        return back()->with('success', 'Cảm ơn bạn đã đánh giá.');
    }
}
