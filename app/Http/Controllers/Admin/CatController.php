<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCatRequest;
use App\Http\Requests\Admin\UpdateCatRequest;
use App\Models\Cat;
use App\Models\CatBreed;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CatController extends Controller
{
    public function index(): View
    {
        $cats = Cat::with('breed')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.cats.index', compact('cats'));
    }

    public function create(): View
    {
        $breeds = CatBreed::orderBy('breed_name')->get();
        return view('admin.cats.create', compact('breeds'));
    }

    public function store(StoreCatRequest $request): RedirectResponse
    {
        Cat::create($request->validated());

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Thêm mèo mới thành công.');
    }

    public function show(Cat $cat): View
    {
        $cat->load('breed', 'reviews.user');
        return view('admin.cats.show', compact('cat'));
    }

    public function edit(Cat $cat): View
    {
        $breeds = CatBreed::orderBy('breed_name')->get();
        return view('admin.cats.edit', compact('cat', 'breeds'));
    }

    public function update(UpdateCatRequest $request, Cat $cat): RedirectResponse
    {
        $cat->update($request->validated());

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Cập nhật mèo thành công.');
    }

    public function destroy(Cat $cat): RedirectResponse
    {
        $cat->delete();

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Đã xóa mèo khỏi hệ thống.');
    }
}
