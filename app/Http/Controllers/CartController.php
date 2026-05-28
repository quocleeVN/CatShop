<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): View
    {
        $cartItems = $this->cartService->getCartItems();
        $total = $this->cartService->calculateTotal();

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'cat_id'   => 'required|exists:cats,cat_id',
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $this->cartService->addToCart(
            $request->cat_id,
            $request->quantity ?? 1
        );

        return back()->with('success', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request, int $catId): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $this->cartService->updateQuantity($catId, $request->quantity);

        return back()->with('success', 'Cập nhật số lượng thành công.');
    }

    public function remove(int $catId): RedirectResponse
    {
        $this->cartService->removeFromCart($catId);

        return back()->with('success', 'Đã xóa khỏi giỏ hàng.');
    }
}
