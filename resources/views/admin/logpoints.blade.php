@extends('layouts.admin')
@section('title', 'Log Point')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-history"></i>
                    LogPoints
                </a>
            </div>
            <div class="flex-none gap-2">
                <form class="flex" role="search">
                    <input type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $search }}"
                        class="input input-bordered w-auto" />
                    <button class="btn ml-2" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Barcode</th>
                        <th scope="col">Product Reward</th>
                        <th scope="col">Point</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($logpoints as $item)
                        <tr>
                            <td>{{ $item->member->name   ?? 'ไม่มีข้อมูลในระบบ' }}</td>
                            <td>{{ $item->member->email  ?? 'ไม่มีข้อมูลในระบบ' }}</td>
                            <td>{{ $item->phone_no }}</td>
                            <td>{{ $item->barcode }}</td>
                            <td>{{ $item->product_reward ?? 'ไม่มีข้อมูลในระบบ' }}</td>
                            <td>{{ $item->point }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_date)->format('d/m/Y') }}</td>
                            <td>{{ $item->updated_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logpoints->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
