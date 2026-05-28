<?php

namespace App\Services;

use App\Models\Cat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Lấy danh sách sản phẩm trong giỏ hàng.
     * Đã đăng nhập: lấy từ DB. Chưa đăng nhập: lấy từ session.
     *
     * @return array Mảng ['cat' => Model, 'quantity' => int]
     */
    public function getCartItems(): array
    {
        if (Auth::check()) {
            $cartItems = Auth::user()->cartItems()->with('cat.breed')->get();
            $items = [];
            foreach ($cartItems as $cartItem) {
                $items[] = [
                    'cat'      => $cartItem->cat,
                    'quantity' => $cartItem->quantity,
                ];
            }
            return $items;
        }

        // Khách chưa đăng nhập
        $sessionCart = Session::get('cart', []);
        $items = [];
        foreach ($sessionCart as $catId => $qty) {
            $cat = Cat::find($catId);
            if ($cat) {
                $items[] = [
                    'cat'      => $cat,
                    'quantity' => $qty,
                ];
            }
        }
        return $items;
    }

    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function addToCart(int $catId, int $quantity = 1): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cartItem = $user->cartItems()->where('cat_id', $catId)->first();
            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                $user->cartItems()->create([
                    'cat_id'   => $catId,
                    'quantity' => $quantity,
                ]);
            }
            return;
        }

        $cart = Session::get('cart', []);
        $cart[$catId] = ($cart[$catId] ?? 0) + $quantity;
        Session::put('cart', $cart);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng.
     * Nếu số lượng <= 0 thì xóa sản phẩm.
     */
    public function updateQuantity(int $catId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($catId);
            return;
        }

        if (Auth::check()) {
            Auth::user()->cartItems()->where('cat_id', $catId)->update(['quantity' => $quantity]);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$catId])) {
                $cart[$catId] = $quantity;
                Session::put('cart', $cart);
            }
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng.
     */
    public function removeFromCart(int $catId): void
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->where('cat_id', $catId)->delete();
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$catId]);
            Session::put('cart', $cart);
        }
    }

    /**
     * Tính tổng tiền giỏ hàng (chưa phí ship, chưa giảm giá).
     */
    public function calculateTotal(): float
    {
        $total = 0.0;
        foreach ($this->getCartItems() as $item) {
            $total += $item['cat']->price * $item['quantity'];
        }
        return round($total, 2);
    }

    /**
     * Xóa toàn bộ giỏ hàng.
     */
    public function clearCart(): void
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->delete();
        }
        Session::forget('cart');
    }

    /**
     * Tổng số lượng sản phẩm trong giỏ (dùng hiển thị badge).
     */
    public function getCartCount(): int
    {
        if (Auth::check()) {
            return (int) Auth::user()->cartItems()->sum('quantity');
        }
        return (int) array_sum(Session::get('cart', []));
    }

    /**
     * Hợp nhất giỏ hàng session vào DB khi user vừa đăng nhập.
     */
    public function mergeCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $sessionCart = Session::pull('cart', []);
        foreach ($sessionCart as $catId => $qty) {
            $this->addToCart($catId, $qty);
        }
    }
}
