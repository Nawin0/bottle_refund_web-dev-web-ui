@extends('layouts.user')
@section('title', 'rewards')
@section('content')
    <div class="shadow-xl rounded-box mx-auto bg-white">
        <div class="navbar rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fa-solid fa-gift"></i>
                    Reward Item
                </a>
            </div>
            <div class="flex-none gap-2">
                <form class="flex" role="search">
                    <input type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $search }}"
                        class="input input-bordered w-auto" />
                    <button class="btn ml-2 bg-gradient-to-r from-lime-500 to-lime-600 text-white"
                        type="submit">Search</button>
                </form>
            </div>
        </div>

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                });
            </script>
        @endif

        @if ($errors->has('address'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ $errors->first('address') }}",
                });
            </script>
        @endif

        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box bg-white">

            <!-- table and viewpoint  -->
            <div class="overflow-x-auto mb-2">
                <div class="hidden md:block">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center rounded-l-md">Product Reward</th>
                                <th scope="col" class="px-6 py-3 text-center">Stock</th>
                                <th scope="col" class="px-6 py-3 text-center">Point</th>
                                <th scope="col" class="px-6 py-3 text-center">Image</th>
                                <th scope="col" class="px-6 py-3 text-center rounded-r-md">Exchange</th>
                            </tr>
                        </thead>
                        <tbody class="text-[16px]">
                            @foreach ($rewards as $item)
                                @if ($item->stock > 0 && $item->status == 1)
                                    <tr class="text-gray-700 border-b">
                                        <td class="px-6 py-4 text-center">{{ $item->product_reward }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->stock }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->point }}</td>
                                        <td class="px-6 py-4 flex justify-center">
                                            <img src="data:image/*;base64,{{ $item->image }}" alt="image"
                                                class="w-20 h-20 object-cover rounded-md">
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="dropdown dropdown-end">
                                                <a class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100 addExchangeBtn"
                                                    href="#" data-id="{{ $item->id }}"
                                                    data-name="{{ $item->product_reward }}"
                                                    data-point="{{ $item->point }}" data-quantity="1"
                                                    data-code="{{ $item->product_code }}"
                                                    data-image="{{ $item->image }}">
                                                    <i class="fa-solid fa-plus flex">
                                                        <p class="hidden sm:flex ml-2">แลกของ</p>
                                                    </i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!--  -->
                <div class="block md:hidden space-y-6">
                    @foreach ($rewards as $items)
                        @if ($item->stock > 0 && $item->status == 1)
                            <div class="border-b border-gray-300 pb-4 pl-3 pt-2">

                                <p class="text-gray-700 mb-2">
                                    <span class="font-bold" style="display: inline-block; width: 120px;">Product
                                        Reward:</span>
                                    {{ $items->product_reward ?? 'N/A' }}
                                </p>
                                <p class="text-gray-700 mb-2">
                                    <span class="font-bold" style="display: inline-block; width: 120px;">Stock:</span>
                                    {{ $items->stock }}
                                </p>
                                <p class="text-gray-700 mb-2">
                                    <span class="font-bold" style="display: inline-block; width: 120px;">Point:</span>
                                    {{ $items->point }}
                                </p>
                                <p class="text-gray-700 mb-2">
                                    <span class="font-bold" style="display: inline-block; width: 120px;">Image:</span>
                                <div class="flex justify-center">
                                    <img src="data:image/*;base64,{{ $items->image }}" alt="image"
                                        class="w-40 h-40 object-cover rounded-md mt-2 my-5">
                                </div>
                                </p>
                                <p class="text-gray-700 mb-2 px-6 py-4 text-center">
                                <div class="dropdown dropdown-end">
                                    <a class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100 addExchangeBtn"
                                        href="#" data-id="{{ $item->id }}"
                                        data-name="{{ $item->product_reward }}" data-point="{{ $item->point }}"
                                        data-quantity="1" data-code="{{ $item->product_code }}"
                                        data-image="{{ $item->image }}">
                                        <i class="fa-solid fa-plus flex">
                                            <p class="hidden sm:flex ml-2">แลกของ</p>
                                        </i>
                                    </a>
                                </div>
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!--  -->

                <div class="mb-4 mt-6 px-3">
                    {{ $rewards->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Exchange Modal -->
    <div id="addExchangeModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Add Exchange</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeaddExchangeModal">×</button>
            <form action="{{ route('reward.exchange_add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="product_reward" class="block text-sm font-medium text-gray-700">Product Reward</label>
                    <input type="text" name="product_reward" id="product_reward" value=""
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="mb-4">
                    <label for="point" class="block text-sm font-medium text-gray-700">Point</label>
                    <input type="text" name="point" id="point" value=""
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="text" name="quantity" id="quantity" value="1"
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="hidden">
                    <label for="phone_no" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone_no" id="phone_no" value="{{ auth()->user()->phone_no }}"
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="hidden">
                    <label for="product_code" class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" id="product_code" value=""
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="hidden">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="text" name="image" id="image" value=""
                        class="input input-bordered w-full" required readonly>
                </div>

                <div class="mb-3">
                    <label for="address" class="font-bold">Address</label>
                    <div class="mt-3">
                        {!! Form::select('address', $addresses, null, ['class' => 'select select-bordered w-full']) !!}
                    </div>
                </div>
                @error('address')
                    <div class="my-3">
                        <span class="text-error">{{ $message }}</span>
                    </div>
                @enderror

                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelModal"
                        class="btn bg-gradient-to-r from-slate-500 to-slate-600 text-base-100">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-white">
                        แลกของ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Exchange
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addExchangeModal');
            const addExchangeBtns = document.querySelectorAll('.addExchangeBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeModal = document.getElementById('closeaddExchangeModal');

            addExchangeBtns.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const productName = button.getAttribute('data-name');
                    const productPoint = button.getAttribute('data-point');
                    const productQuantity = button.getAttribute('data-quantity');
                    const productCode = button.getAttribute('data-code');
                    const productImage = button.getAttribute('data-image');

                    document.getElementById('product_reward').value = productName;
                    document.getElementById('point').value = productPoint;
                    document.getElementById('quantity').value = productQuantity;
                    document.getElementById('product_code').value = productCode;
                    document.getElementById('image').value = productImage;

                    modal.classList.remove('hidden');
                });
            });

            [cancelModal, closeModal].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
