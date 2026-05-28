@extends('layouts.admin')
@section('title', 'Quản lý đánh giá')

@section('content')
<div>
    <h1 class="text-2xl font-bold mb-6">Đánh giá sản phẩm</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Người dùng</th>
                    <th class="px-6 py-3 text-left">Mèo</th>
                    <th class="px-6 py-3 text-left">Đánh giá</th>
                    <th class="px-6 py-3 text-left">Nhận xét</th>
                    <th class="px-6 py-3 text-left">Ngày</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $review->user->full_name }}</td>
                    <td class="px-6 py-4">{{ $review->cat->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex text-yellow-400">
                            @for($i=0;$i<$review->rating;$i++)★@endfor
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($review->comment, 60) }}</td>
                    <td class="px-6 py-4">{{ $review->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Xóa đánh giá này?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $reviews->links() }}</div>
    </div>
</div>
@endsection