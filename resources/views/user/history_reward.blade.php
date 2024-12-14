@extends('layouts.user')
@section('title', 'Exchange History')
@section('content')
<div class="shadow-xl rounded-box mx-auto bg-white">
    <div class="navbar rounded-t-box border-base-400 border-2">
        <div class="flex-1 uppercase">
            <a class="btn btn-ghost text-xl">
                <i class="fa-solid fa-gift"></i>
                Exchange History
            </a>
        </div>
    </div>

    <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">

        <div class="hidden md:block overflow-x-auto mb-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center rounded-l-md">Image</th>
                        <th scope="col" class="px-6 py-3 text-center">Product</th>
                        <th scope="col" class="px-6 py-3 text-center">Point</th>
                        <th scope="col" class="px-6 py-3 text-center">Address</th>
                        <th scope="col" class="px-6 py-3 text-center">Date/Time</th>
                        <th scope="col" class="px-6 py-3 text-center rounded-r-md">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($exchang as $items)
                    <tr class="bg-white border-b text-gray-700">
                        <td class="px-6 py-4 flex justify-center">
                            <img src="data:image/*;base64,{{ $items->image64 }}" alt="image"
                                class="w-20 h-20 object-cover rounded-md">
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $items->reward->product_reward  ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $items->point }}
                        </td>
                        <td class="text-center">
                            {{ $items->addr->address ?? 'ไม่พบที่อยู่' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ \Carbon\Carbon::parse($items->created_at)->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="text-center {{ $items->status == 2 ? 'text-green-500' : 'text-yellow-500'}}">
                            {{ $items->status == 2 ? 'Delivered' : 'Pending Confirmation' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="block md:hidden space-y-6">
            @foreach ($exchang as $items)
            <div class="border-b border-gray-300 pb-4 pl-3 pt-2">
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Image:</span>
                <div class="flex justify-center">
                    <img src="data:image/*;base64,{{ $items->image64 }}" alt="image"
                        class="w-40 h-40 object-cover rounded-md mt-2 my-5">
                </div>
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Product:</span>
                    {{ $items->product_reward ?? 'N/A' }}
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Point:</span>
                    {{ $items->point }}
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Address:</span>
                    {{ $items->addr->address ?? 'ไม่พบที่อยู่' }}
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Date/Time:</span>
                    {{ \Carbon\Carbon::parse($items->created_at)->format('d/m/Y H:i:s') }}
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Status:</span>
                    <span class="{{ $items->status == 2 ? 'text-green-500' : 'text-yellow-500' }}">
                        {{ $items->status == 2 ? 'Delivered' : 'Pending Confirmation' }}
                    </span>
                </p>
            </div>
            @endforeach
        </div>

        <div class="mb-4 mt-6 px-3">
            {{ $exchang->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
