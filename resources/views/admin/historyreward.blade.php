@extends('layouts.admin')
@section('title', 'History Reward')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-bottle-water"></i>
                    History Reward
                </a>
            </div>
            <div class="mr-2">
                <label for="type" class="block text-sm font-medium mr-2">Type</label>
                <select name="type" id="type" class="input input-bordered w-full">
                    <option value="1" {{ $type == 1 ? 'selected' : '' }}>Pending Confirmation</option>
                    <option value="2" {{ $type == 2 ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
            <div class="flex-none gap-2">
                <form class="flex" role="search">
                    <input type="search" placeholder="Search" aria-label="Search" name="search"
                        value="{{ $search }}" class="input input-bordered w-auto" />
                    <button class="btn ml-2" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Point</th>
                        <th scope="col">Image64</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($exchang as $item)
                        @if (($type == 1 && $item->status == 1) || ($type == 2 && $item->status == 2) || !$type)
                            <tr>
                                <td>{{ $item->phone_no }}</td>
                                <td>{{ $item->rewarditem->product_reward ?? 'ไม่มีข้อมูลในระบบ' }}</td>
                                <td>{{ $item->point }}</td>
                                <td><img src="data:image/*;base64,{{ $item->image64 }}" alt="image"
                                        class="w-20 h-20 object-cover">
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td class="{{ $item->addr && $item->addr->address ? 'text-gray-800' : 'text-red-500' }}">
                                    {{ $item->addr->address ?? 'ไม่มีข้อมูลในระบบ' }}
                                </td>
                                <td data-id="{{ $item->id }}"
                                    class="{{ $item->status == 2 ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $item->status == 2 ? 'Delivered' : 'Pending Confirmation' }}
                                </td>
                                <td>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="status-toggle hidden" data-id="{{ $item->id }}"
                                            {{ $item->status == 1 ? '' : 'checked' }}>
                                        <span
                                            class="toggle-label w-14 h-8 rounded-full flex items-center p-1 transition-colors duration-300
                                        {{ $item->status == 1 ? 'bg-gray-200' : 'bg-green-500' }}">
                                            <span
                                                class="circle bg-white w-6 h-6 rounded-full shadow-md transition-transform duration-300
                                            {{ $item->status == 1 ? '' : 'translate-x-6' }}"></span>
                                        </span>
                                    </label>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {{ $exchang->appends(['type' => $type])->links() }}
        </div>
    </div>

    <script>
        // Toggle
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const status = this.checked ? 2 : 1;
                const id = this.getAttribute('data-id');

                const toggleLabel = this.closest('label').querySelector('.toggle-label');
                const circle = this.closest('label').querySelector('.circle');

                if (status === 2) {
                    toggleLabel.classList.remove('bg-gray-200');
                    toggleLabel.classList.add('bg-green-500');
                    circle.classList.add('translate-x-6');
                } else {
                    toggleLabel.classList.remove('bg-green-500');
                    toggleLabel.classList.add('bg-gray-200');
                    circle.classList.remove('translate-x-6');
                }

                const statusId = document.querySelector(`td[data-id="${id}"]`);
                if (statusId) {
                    statusId.textContent = status === 2 ? 'Delivered' : 'Pending Confirmation';
                    statusId.classList.toggle('text-green-500', status === 2);
                    statusId.classList.toggle('text-yellow-500', status !== 2);
                }

                fetch(`/historyreward_status/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // type select
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set('type', type);

            window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
        });
    </script>
@endsection
