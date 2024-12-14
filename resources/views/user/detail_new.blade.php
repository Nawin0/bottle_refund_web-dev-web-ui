@extends('layouts.user')
@section('title', 'News Detail')

@section('content')
<div class="rounded-box mx-auto bg-white shadow-xl">
    <div class="navbar rounded-t-box border-base-400 border-2">
        <div class="flex-1 uppercase">
            <a class="btn btn-ghost text-xl">
                <i class="fa-solid fa-gift"></i>
                News Detail
            </a>
        </div>
    </div>

    <div class="p-[10px] border-2 border-t-0 rounded-b-box">
        <div class="bg-base-100 rounded-lg p-4 flex flex-col items-center">
            <div><img
                    src="data:image/jpeg;base64,{{ $news->image64 }}"
                    alt="{{ $news->heading }}"
                    class="w-full h-72 object-contain mb-4 rounded-xl">
            </div>
            <div class="text-center">
                <h3 class="font-bold text-2xl mb-4">{{ $news->heading }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $news->content }}</p>
                <span class="block text-xs text-gray-400 mt-2">{{ $news->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection