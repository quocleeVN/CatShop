<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatBreed;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BreedController extends Controller
{
    public function index(): View
    {
        $breeds = CatBreed::withCount('cats')->paginate(15);
        return view('admin.breeds.index', compact('breeds'));
    }

    public function create(): View
    {
        return view('admin.breeds.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'breed_name'  => 'required|string|max:100|unique:cat_breeds,breed_name',
            'origin'      => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        CatBreed::create($validated);

        return redirect()->route('admin.breeds.index')
            ->with('success', 'Thêm giống mèo thành công.');
    }

    public function edit(CatBreed $breed): View
    {
        return view('admin.breeds.edit', compact('breed'));
    }

    public function update(Request $request, CatBreed $breed): RedirectResponse
    {
        $validated = $request->validate([
            'breed_name'  => 'required|string|max:100|unique:cat_breeds,breed_name,' . $breed->breed_id . ',breed_id',
            'origin'      => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $breed->update($validated);

        return redirect()->route('admin.breeds.index')
            ->with('success', 'Cập nhật giống mèo thành công.');
    }

    public function destroy(CatBreed $breed): RedirectResponse
    {
        // Không xóa nếu còn mèo thuộc giống này (ràng buộc ON DELETE RESTRICT)
        if ($breed->cats()->exists()) {
            return back()->with('error', 'Không thể xóa giống đang có mèo.');
        }

        $breed->delete();

        return redirect()->route('admin.breeds.index')
            ->with('success', 'Đã xóa giống mèo.');
    }
}
