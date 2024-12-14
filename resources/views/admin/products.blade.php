@extends('layouts.admin')
@section('title', 'Products')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-bottle-water"></i>
                    Products
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
                        <a class="btn btn-success text-base-100" href="#" id="addProductBtn">
                            <i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">Barcode</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Point</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->barcode }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type == 1 ? 'Bottle': ($item->type == 2 ? 'Can' : 'Unknown Type') }}</td>
                            <td>{{ $item->point }}</td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn btn-warning text-base-100 edit_products" data-bs-toggle="modal"
                                        data-bs-target="#EditProductModal" data-item="{{ $item->id }}"
                                        data-barcode="{{ $item->barcode }}" data-name="{{ $item->name }}"
                                        data-type="{{ $item->type }}" data-point="{{ $item->point }}" href="#"><i
                                            class="fa-solid fa-edit"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 delete_products" data-bs-toggle="modal"
                                        data-bs-target="#DeleteProductModal" data-item="{{ $item->id }}"
                                        data-name="{{ $item->name }}" href="#">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div id="DeleteProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDeleteProductModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Confirm Product Deletion</h2>
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

    <!-- Edit Product Modal -->
    <div id="EditProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit Product</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditProductModal">×</button>
            <form id="editForm" method="POST" action="/edit_products">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="barcode" class="block text-sm font-medium">Barcode</label>
                        <input id="barcode" name="barcode" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input id="name" name="name" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium">Type</label>
                        <select name="type" id="type" name="type" class="input input-bordered w-full">
                            <option value="1">Bottle</option>
                            <option value="2">Can</option>
                        </select>
                    </div>
                    <div>
                        <label for="point" class="block text-sm font-medium">Point</label>
                        <input id="point" name="point" type="number" class="input input-bordered w-full" required>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Add Product</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeaddProductModal">×</button>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" name="type" class="input input-bordered w-full">
                        <option value="1">Bottle</option>
                        <option value="2">Can</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="point" class="block text-sm font-medium text-gray-700">Point</label>
                    <input type="number" name="point" id="point" class="input input-bordered w-full" required>
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


    <script>
        // DELETE
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DeleteProductModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete_products');

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
                    deleteForm.setAttribute('action', `/delete_products/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });

            [cancelDelete].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });
        $('#closeDeleteProductModal, #closeDeleteProductModalBtn').on('click', function() {
            $('#DeleteProductModal').addClass('hidden');
        });

        // Edit
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditProductModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_products');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const barcode = button.getAttribute('data-barcode');
                    const name = button.getAttribute('data-name');
                    const type = button.getAttribute('data-type');
                    const point = button.getAttribute('data-point');

                    document.getElementById('barcode').value = barcode;
                    document.getElementById('name').value = name;
                    document.getElementById('type').value = type;
                    document.getElementById('point').value = point;

                    editForm.setAttribute('action', `/edit_products/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditProductModal, #closeEditProductModalBtn').on('click', function() {
            $('#EditProductModal').addClass('hidden');
        });

        // ADD PRODUCT
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addProductModal');
            const addProductBtn = document.getElementById('addProductBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeModal = document.getElementById('closeModal');

            addProductBtn.addEventListener('click', () => {
                addProductModal.classList.remove('hidden');
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
        $('#closeaddProductModal, #closeaddProductModalBtn').on('click', function() {
            $('#addProductModal').addClass('hidden');
        });
    </script>
@endsection
