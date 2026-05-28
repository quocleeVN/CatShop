<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    public function index(): View
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount'     => 'nullable|numeric|min:0',
            'min_order_value'  => 'nullable|numeric|min:0',
            'expiry_date'      => 'required|date|after:today',
            'is_active'        => 'boolean',
        ]);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Đã tạo mã giảm giá.');
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        $validated = $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code,' . $coupon->coupon_id . ',coupon_id',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount'     => 'nullable|numeric|min:0',
            'min_order_value'  => 'nullable|numeric|min:0',
            'expiry_date'      => 'required|date',
            'is_active'        => 'boolean',
        ]);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cập nhật mã giảm giá.');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();
        return back()->with('success', 'Đã xóa mã giảm giá.');
    }
}
