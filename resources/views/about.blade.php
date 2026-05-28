@extends('layouts.app')
@section('title', 'Giới thiệu')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <h1 class="text-4xl font-bold text-center mb-8">Về CatShop</h1>
    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6 text-gray-700 leading-relaxed">
        <p>CatShop là cửa hàng mèo cảnh hàng đầu Việt Nam, chuyên cung cấp các bé mèo thuần chủng, sức khỏe tốt, nguồn gốc rõ ràng.</p>
        <p>Chúng tôi cam kết:</p>
        <ul class="list-disc pl-6 space-y-2">
            <li>Mèo được tiêm phòng đầy đủ, kiểm tra sức khỏe định kỳ.</li>
            <li>Hỗ trợ tư vấn chăm sóc trọn đời.</li>
            <li>Bảo hành sức khỏe 30 ngày.</li>
            <li>Giao hàng an toàn trên toàn quốc.</li>
        </ul>
        <p>Đội ngũ của chúng tôi yêu mèo và luôn mong muốn mang đến những chú mèo khỏe mạnh, đáng yêu nhất cho bạn.</p>
    </div>
</div>
@endsection