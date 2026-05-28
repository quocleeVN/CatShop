<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserAddressController extends Controller
{
    public function index(): View
    {
        $addresses = auth()->user()->addresses;
        return view('addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_name'    => 'required|string|max:100',
            'phone_number'      => 'required|string|max:20',
            'specific_address'  => 'required|string|max:255',
            'ward'              => 'nullable|string|max:100',
            'district'          => 'nullable|string|max:100',
            'city'              => 'required|string|max:100',
            'is_default'        => 'boolean',
        ]);

        $user = auth()->user();
        // Nếu đánh dấu mặc định, bỏ mặc định các địa chỉ khác
        if (!empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Đã thêm địa chỉ mới.');
    }

    public function edit(UserAddress $address): View
    {
        $this->authorize('update', $address);
        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, UserAddress $address): RedirectResponse
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'recipient_name'    => 'required|string|max:100',
            'phone_number'      => 'required|string|max:20',
            'specific_address'  => 'required|string|max:255',
            'ward'              => 'nullable|string|max:100',
            'district'          => 'nullable|string|max:100',
            'city'              => 'required|string|max:100',
            'is_default'        => 'boolean',
        ]);

        $user = auth()->user();
        if (!empty($validated['is_default'])) {
            $user->addresses()->where('address_id', '!=', $address->address_id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Cập nhật địa chỉ thành công.');
    }

    public function destroy(UserAddress $address): RedirectResponse
    {
        $this->authorize('delete', $address);
        $address->delete();

        return back()->with('success', 'Đã xóa địa chỉ.');
    }
}
