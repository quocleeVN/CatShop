<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    public function index(CartService $cartService): View
    {
        $cartItems = $cartService->getCartItems();
        $subtotal  = $cartService->calculateTotal();
        $shippingFee = 50000; // hoặc tính theo quy tắc
        $discount   = session('coupon_discount', 0);
        $total      = $subtotal + $shippingFee - $discount;
        $couponCode = session('coupon_code');
        $addresses  = auth()->user()->addresses;

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shippingFee',
            'discount',
            'total',
            'couponCode',
            'addresses'
        ));
    }

    public function applyCoupon(Request $request, CartService $cartService): RedirectResponse
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)->active()->first();

        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn.');
        }

        $subtotal = $cartService->calculateTotal();
        if ($subtotal < $coupon->min_order_value) {
            return back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu.');
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session([
            'coupon_code'     => $coupon->code,
            'coupon_discount' => $discount,
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    public function placeOrder(CheckoutRequest $request, OrderService $orderService): RedirectResponse
    {
        $order = $orderService->createOrder($request->validated());

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại CatShop.');
    }
}
