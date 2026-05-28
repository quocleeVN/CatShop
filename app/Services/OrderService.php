<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class OrderService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Tạo đơn hàng từ giỏ hàng hiện tại.
     *
     * @param array $data Dữ liệu checkout (payment_method, shipping_address, order_notes)
     * @return Order
     * @throws \Exception
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $cartItems = $this->cartService->getCartItems();

            if (empty($cartItems)) {
                throw new \Exception('Giỏ hàng trống.');
            }

            $subtotal    = $this->cartService->calculateTotal();
            $shippingFee = 50000; // phí cố định, có thể làm bảng giá sau

            // Xử lý mã giảm giá
            $couponCode = Session::get('coupon_code');
            $discount   = 0;
            $couponId   = null;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->active()->first();
                if ($coupon && $subtotal >= $coupon->min_order_value) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $couponId = $coupon->coupon_id;
                } else {
                    // Mã không hợp lệ hoặc không đủ điều kiện
                    Session::forget(['coupon_code', 'coupon_discount']);
                }
            } else {
                $discount = Session::get('coupon_discount', 0);
            }

            $finalAmount = max(0, $subtotal + $shippingFee - $discount);

            $shippingAddress = $data['shipping_address'] ?? null;

            if (! empty($data['use_existing_address'])) {
                $address = UserAddress::query()
                    ->where('address_id', $data['use_existing_address'])
                    ->where('user_id', Auth::id())
                    ->first();

                if (! $address) {
                    throw ValidationException::withMessages([
                        'use_existing_address' => 'Dia chi khong hop le.',
                    ]);
                }

                $shippingAddress = $address->full_address;
            }

            if (blank($shippingAddress)) {
                throw ValidationException::withMessages([
                    'shipping_address' => 'Dia chi giao hang la bat buoc.',
                ]);
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id'         => Auth::id(),
                'total_amount'    => $subtotal,
                'shipping_fee'    => $shippingFee,
                'final_amount'    => $finalAmount,
                'coupon_id'       => $couponId,
                'payment_method'  => $data['payment_method'],
                'payment_status'  => 'pending',
                'order_status'    => 'pending',
                'shipping_address' => $shippingAddress,
                'order_notes'     => $data['order_notes'] ?? null,
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $cat = $item['cat'];

                OrderItem::create([
                    'order_id'         => $order->order_id,
                    'cat_id'           => $cat->cat_id,
                    'price_at_purchase' => $cat->price,
                    'quantity'         => $item['quantity'],
                ]);

                // Cập nhật trạng thái mèo thành "reserved" (hoặc "sold" tùy quy trình)
                $cat->update(['stock_status' => 'reserved']);
            }

            // Xóa giỏ hàng + session coupon
            $this->cartService->clearCart();
            Session::forget(['coupon_code', 'coupon_discount']);

            return $order;
        });
    }
}
