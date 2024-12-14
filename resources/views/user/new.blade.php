@extends('layouts.user')
@section('title', 'News')

@section('content')
    <div class=" rounded-box mx-auto bg-white shadow-xl">
        <div class="navbar rounded-t-box border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fa-solid fa-gift"></i>
                    News
                </a>
            </div>
        </div>

        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($news as $item)
                    <a href="{{ route('new.detail', $item->id) }}"
                        class="bg-base-100 shadow-xl rounded-lg p-4 flex flex-col items-center">
                        <div><img src="data:image/jpeg;base64,{{ $item->image64 }}" alt="{{ $item->heading }}"
                                class="w-28 h-28 object-cover mb-4 rounded-md"></div>


                        <div class="text-center">
                            <h3 class="font-bold text-lg mb-2">{{ $item->heading }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($item->content, 100) }}</p>
                            <span
                                class="block text-xs text-gray-400 mt-2">{{ $item->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        ยังไม่มีข่าวในระบบ
                    </div>
                @endforelse
            </div>
            <div class="mb-4 mt-6 px-3">
                {{ $news->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
