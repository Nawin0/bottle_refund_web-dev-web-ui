@extends('layouts.admin')
@section('title', 'News')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fa-solid fa-newspaper"></i>
                    News
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
                        <a class="btn btn-success text-base-100" href="#" id="addNewsBtn">
                            <i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">Heading</th>
                        <th scope="col">Content</th>
                        <th scope="col">Image64</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($news as $item)
                        <tr>
                            <td>{{ $item->heading }}</td>
                            <td>{{ Str::limit($item->content, 30) }}</td>
                            <td><img src="data:image/*;base64,{{ $item->image64 }}" alt="image"
                                    class="w-20 h-20 object-cover"></td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="#"
                                        data-image64="data:image/*;base64,{{ $item->image64 }}" onclick="openModal(this)">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                    <a class="btn btn-warning text-base-100 edit_news" data-bs-toggle="modal"
                                        data-bs-target="#EditNewsModal" data-item="{{ $item->id }}"
                                        data-heading="{{ $item->heading }}" data-content="{{ $item->content }}"
                                        data-image64="{{ $item->image64 }}"
                                        href="#"><i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 delete_news" data-bs-toggle="modal"
                                        data-bs-target="#DeleteNewsModal" data-item="{{ $item->id }}"
                                        data-heading="{{ $item->heading }}" href="#">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $news->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div id="DeleteNewsModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDeleteNewsModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Confirm News Deletion</h2>
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
    <div id="EditNewsModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit News</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditNewsModal">×</button>
            <form id="editForm" method="POST" action="/edit_news" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="heading" class="block text-sm font-medium">Heading</label>
                        <input id="heading" name="heading" type="text" class="input input-bordered w-full"
                            required>
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium">Content</label>
                        <textarea id="content" name="content" class="textarea textarea-bordered w-full" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image64" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image64" id="image64" accept="image/*">
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add News Product Modal -->
    <div id="addNewsModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Add News</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeaddNewsModal">×</button>
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
                    <input type="text" name="heading" id="heading" class="input input-bordered w-full"
                        required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="content" name="content" class="textarea textarea-bordered w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="image64" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image64" id="image64" accept="image/*" required>
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

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold">Image</h2>
                <button class="text-gray-500 hover:text-black" onclick="closeModal()">×</button>
            </div>
            <div class="mt-4">
                <img id="modalImage" src="" alt="Preview" class="w-[960px] h-[auto] rounded-lg object-contain">
            </div>
        </div>
    </div>

    <script>
        // DELETE
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DeleteNewsModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete_news');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const heading = button.getAttribute('data-heading');

                    if (!itemId || !heading) {
                        console.error('ข้อมูลไม่สมบูรณ์');
                        return;
                    }

                    deleteMessage.textContent = `คุณต้องการลบสินค้า "${heading}" นี้หรือไม่?`;
                    deleteForm.setAttribute('action', `/delete_news/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });

            [cancelDelete].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });
        $('#closeDeleteNewsModal, #closeDeleteNewsModalBtn').on('click', function() {
            $('#DeleteNewsModal').addClass('hidden');
        });

        // Edit
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditNewsModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_news');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const heading = button.getAttribute('data-heading');
                    const content = button.getAttribute('data-content');

                    document.getElementById('heading').value = heading;
                    document.getElementById('content').value = content;

                    editForm.setAttribute('action', `/edit_news/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditNewsModal, #closeEditNewsModalBtn').on('click', function() {
            $('#EditNewsModal').addClass('hidden');
        });

        // ADD PRODUCT
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addNewsModal');
            const addNewsBtn = document.getElementById('addNewsBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeModal = document.getElementById('closeModal');

            addNewsBtn.addEventListener('click', () => {
                addNewsModal.classList.remove('hidden');
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
        $('#closeaddNewsModal, #closeaddNewsModalBtn').on('click', function() {
            $('#addNewsModal').addClass('hidden');
        });

        // image
        function openModal(element) {
            const imageSrc = element.getAttribute("data-image64");
            document.getElementById("modalImage").src = imageSrc;
            document.getElementById("imageModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("imageModal").classList.add("hidden");
        }
    </script>
@endsection
