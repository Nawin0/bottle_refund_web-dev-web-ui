@extends('layouts.admin')
@section('title', 'Reward Item')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-archive"></i>
                    Reward Item
                </a>
            </div>
            <div class="flex-none gap-2">
                <form class="flex" role="search">
                    <input type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $search }}"
                        class="input input-bordered w-auto" />
                    <button class="btn ml-2" type="submit">Search</button>
                </form>
                @if (Auth::user()->level == '2')
                    <div class="dropdown dropdown-end">
                        <a class="btn btn-success text-base-100" href="#" id="addRewarditemBtn">
                            <i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">Product Code</th>
                        <th scope="col">Product Reward</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Point</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($rewarditems as $item)
                        <tr>
                            <td>{{ $item->product_code }}</td>
                            <td>{{ $item->product_reward }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->point }}</td>
                            <td>
                                <img src="data:image/*;base64,{{ $item->image }}" alt="image"
                                    class="w-20 h-20 object-cover cursor-pointer"
                                    onclick="showImagePopup('{{ 'data:image/*;base64,' . $item->image }}')">
                            </td>
                            <td>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="status-toggle hidden" data-id="{{ $item->id }}"
                                        {{ $item->status == 1 ? 'checked' : '' }}>
                                    <span
                                        class="toggle-label w-14 h-8 rounded-full flex items-center p-1 transition-colors duration-300
                                        {{ $item->status == 1 ? 'bg-green-500' : 'bg-gray-200' }}">
                                        <span
                                            class="circle bg-white w-6 h-6 rounded-full shadow-md transition-transform duration-300
                                            {{ $item->status == 1 ? 'translate-x-6' : '' }}"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                        data-bs-toggle="modal" data-bs-target="#DetailsModal"
                                        data-item="{{ $item->id }}" data-product_reward="{{ $item->product_reward }}"
                                        data-details="{{ $item->details }}" data-stock="{{ $item->stock }}"
                                        data-point="{{ $item->point }}" href="#">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                    <a class="btn btn-warning text-base-100 edit_rewarditems" data-bs-toggle="modal"
                                        data-bs-target="#EditRewarditemModal" data-item="{{ $item->id }}"
                                        data-product_reward="{{ $item->product_reward }}" data-stock="{{ $item->stock }}"
                                        data-point="{{ $item->point }}" data-image="{{ $item->image }}"
                                        href="#"><i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 delete_rewarditems" data-bs-toggle="modal"
                                        data-bs-target="#DeleteRewarditemModal" data-item="{{ $item->id }}"
                                        data-name="{{ $item->product_reward }}" href="#">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $rewarditems->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div id="DeleteRewarditemModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDeleteRewarditemModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Confirm ProductReward Deletion</h2>
            <p id="deleteMessage" class="text-center text-gray-600 mb-6"></p>
            <div class="flex justify-center gap-4">
                <button id="cancelDelete" class="btn btn-neutral">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-base-100">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Detalis Product Modal -->
    <div id="DetailsModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDetailsModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Product Reward</h2>
            <p id="productrewardMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Details</h2>
            <p id="detailsMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Stock</h2>
            <p id="stockMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Point</h2>
            <p id="pointMessage" class="text-center text-gray-600 mb-6"></p>
            <div class="flex justify-center gap-4">
                <button id="cancelDetails" class="btn btn-neutral">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="EditRewarditemModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit Product</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditRewarditemModal">×</button>
            <form id="editForm" method="POST" action="/edit_rewarditems" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="product_reward" class="block text-sm font-medium">Product Reward</label>
                        <input id="product_reward" name="product_reward" type="text"
                            class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium">Stock</label>
                        <input id="stock" name="stock" type="number" class="input input-bordered w-full"
                            required>
                    </div>
                    <div>
                        <label for="point" class="block text-sm font-medium">Point</label>
                        <input id="point" name="point" type="number" class="input input-bordered w-full"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Reward Product Modal -->
    <div id="addRewarditemModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Add Product</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeaddRewarditemModal">×</button>
            <form action="{{ route('rewarditems.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="product_reward" class="block text-sm font-medium text-gray-700">Product Reward</label>
                    <input type="text" name="product_reward" id="product_reward" class="input input-bordered w-full"
                        required>
                </div>
                <div class="mb-4">
                    <label for="details" class="block text-sm font-medium text-gray-700">Details</label>
                    <input type="text" name="details" id="details" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="point" class="block text-sm font-medium text-gray-700">Point</label>
                    <input type="number" name="point" id="point" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" required>
                </div>
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelModal" class="btn btn-neutral">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success text-base-100">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="imagePopup"
        class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="relative">
            <img id="popupImage" src="" alt="Popup Image" class="w-[500px] h-auto rounded-lg object-contain">
            <button class="absolute top-2 right-2 bg-white text-black px-3 py-1 rounded"
                onclick="closeImagePopup()">×</button>
        </div>
    </div>


    <script>
        // DELETE
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DeleteRewarditemModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete_rewarditems');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const itemName = button.getAttribute('data-name');

                    if (!itemId || !itemName) {
                        console.error('ข้อมูลไม่สมบูรณ์');
                        return;
                    }

                    deleteMessage.textContent = `คุณต้องการลบสินค้า "${itemName}" นี้หรือไม่?`;
                    deleteForm.setAttribute('action', `/delete_rewarditems/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });

            [cancelDelete].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });
        $('#closeDeleteRewarditemModal, #closeDeleteRewarditemModalBtn').on('click', function() {
            $('#DeleteRewarditemModal').addClass('hidden');
        });


        // Detalis
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DetailsModal');
            const productrewardMessage = document.getElementById('productrewardMessage');
            const detailsMessage = document.getElementById('detailsMessage');
            const stockMessage = document.getElementById('stockMessage');
            const pointMessage = document.getElementById('pointMessage');
            const cancelDetails = document.getElementById('cancelDetails');
            const closeDetailsModal = document.getElementById('closeDetailsModal');

            document.querySelectorAll('[data-bs-target="#DetailsModal"]').forEach(button => {
                button.addEventListener('click', () => {

                    const product_reward = button.getAttribute('data-product_reward');
                    productrewardMessage.textContent = product_reward;

                    const details = button.getAttribute('data-details');
                    detailsMessage.textContent = details;

                    const stock = button.getAttribute('data-stock');
                    stockMessage.textContent = stock;

                    const point = button.getAttribute('data-point');
                    pointMessage.textContent = point;
                    
                    modal.classList.remove('hidden');
                });
            });

            [cancelDetails, closeDetailsModal].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });

        $('#closeDetalisModal, #closeDetalisModalBtn').on('click', function() {
            $('#DetalisModal').addClass('hidden');
        });

        // Edit
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditRewarditemModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_rewarditems');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const product_reward = button.getAttribute('data-product_reward');
                    const stock = button.getAttribute('data-stock');
                    const point = button.getAttribute('data-point');

                    document.getElementById('product_reward').value = product_reward;
                    document.getElementById('stock').value = stock;
                    document.getElementById('point').value = point;

                    editForm.setAttribute('action', `/edit_rewarditems/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditRewarditemModal, #closeEditRewarditemModalBtn').on('click', function() {
            $('#EditRewarditemModal').addClass('hidden');
        });

        // ADD PRODUCT
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addRewarditemModal');
            const addRewardItemBtn = document.getElementById('addRewarditemBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeModal = document.getElementById('closeModal');

            addRewardItemBtn.addEventListener('click', () => {
                addRewarditemModal.classList.remove('hidden');
            });

            [cancelModal, closeModal].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            modal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeaddRewarditemModal, #closeaddRewarditemModalBtn').on('click', function() {
            $('#addRewarditemModal').addClass('hidden');
        });

        // image
        function showImagePopup(imageSrc) {
            const popup = document.getElementById('imagePopup');
            const popupImage = document.getElementById('popupImage');
            popupImage.src = imageSrc;
            popup.classList.remove('hidden');
        }

        function closeImagePopup() {
            const popup = document.getElementById('imagePopup');
            popup.classList.add('hidden');
        }

        // Toggle
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const status = this.checked ? 1 : 0;
                const id = this.getAttribute('data-id');

                const toggleLabel = this.closest('label').querySelector('.toggle-label');
                const circle = this.closest('label').querySelector('.circle');

                if (status === 1) {
                    toggleLabel.classList.remove('bg-gray-200');
                    toggleLabel.classList.add('bg-green-500');
                    circle.classList.add('translate-x-6');
                } else {
                    toggleLabel.classList.remove('bg-green-500');
                    toggleLabel.classList.add('bg-gray-200');
                    circle.classList.remove('translate-x-6');
                }

                fetch(`/update_status/${id}`, {
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
    </script>
@endsection
