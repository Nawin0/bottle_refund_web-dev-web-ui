@extends('layouts.user')
@section('title', 'My Points')
@section('content')

<div class="rounded-box mx-auto shadow-xl">
    <div class="navbar rounded-t-box border-base-400 border-2 bg-white">
        <div class="flex-1 uppercase">
            <a class="btn btn-ghost text-xl">
                <i class="fa-solid fa-gift"></i>
                My Points
            </a>
        </div>
    </div>


    <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box bg-white">


        <div class="flex justify-center mb-6">
            <div
                class=" bg-gradient-to-r from-lime-500 to-lime-600   shadow-lg rounded-lg p-3 sm:p-6 text-center w-full max-w-sm lg:max-w-md">
                <h2 class="text-4xl font-semibold text-white mb-4">Points</h2>
                <p class="text-5xl font-bold text-white mb-2">
                    {{ $member->current_point }}
                </p>
            </div>
        </div>

        <h3 class="text-lg font-bold mb-3 ml-3">Points History</h3>

        <div class="hidden md:block overflow-x-auto mb-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center rounded-l-md">Name</th>
                        <th scope="col" class="px-6 py-3 text-center">Type</th>
                        <th scope="col" class="px-6 py-3 text-center">Date/Time</th>
                        <th scope="col" class="px-6 py-3 text-center rounded-r-md">Points</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($pointuser as $items)
                    <tr class="bg-white border-b text-gray-700">
                        <td class="px-6 py-4 text-center">
                            @if (!empty($items->product->name))
                            <div>{{ $items->product->name }}</div>
                            @endif
                            @if (!empty($items->exchang->product_reward))
                            <div>{{ $items->exchang->product_reward }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $items->flag == 2 ? 'Points Added' : 'Points Used' }}

                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ \Carbon\Carbon::parse($items->created_date)->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if (!empty($items->exchang->product_reward))
                            <span class="text-red-600 font-semibold">-{{ $items->point }}</span>
                            @elseif (!empty($items->product->name))
                            <span class="text-green-600 font-semibold">+{{ $items->point }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="block md:hidden space-y-6">
            @foreach ($pointuser as $items)
            <div class="border-b border-gray-300 pb-4 pl-3 pt-2">
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Name:</span>
                    @if (!empty($items->product->name))
                    <span>{{ $items->product->name }}</span>
                    @endif
                    @if (!empty($items->exchang->product_reward))
                    <span>{{ $items->exchang->product_reward }}</span>
                    @endif
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Type:</span>
                    {{ $items->flag == 2 ? 'Points Added' : 'Points Used' }}
                </p>
                <p class="text-gray-700 mb-2">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Date/Time:</span>
                    {{ \Carbon\Carbon::parse($items->created_date)->format('d/m/Y') }}
                    {{ \Carbon\Carbon::parse($items->created_time)->format('H:i:s') }}
                </p>
                <p class="text-gray-700">
                    <span class="font-bold" style="display: inline-block; width: 120px;">Points:</span>
                    @if (!empty($items->exchang->product_reward))
                    <span class="text-red-600 font-semibold">-{{ $items->point }}</span>
                    @elseif (!empty($items->product->name))
                    <span class="text-green-600 font-semibold">+{{ $items->point }}</span>
                    @endif
                </p>
            </div>
            @endforeach
        </div>
        <div class="mb-4 mt-6 px-3">
            {{ $pointuser->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
