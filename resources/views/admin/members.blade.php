@extends('layouts.admin')
@section('title', 'Members')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fa-solid fa-user-gear"></i>
                    Members
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
                        <th scope="col">Phone Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Current Point</th>
                        <th scope="col">Role</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($members as $item)
                        <tr>
                            <td>{{ $item->phone_no }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->current_point }}</td>
                            <td>{{ $item->level == 1 ? 'user' : ($item->level == 2 ? 'admin' : 'unknown') }}</td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn btn-warning text-base-100 edit_members" data-bs-toggle="modal"
                                        data-bs-target="#EditMemberModal" data-item="{{ $item->id }}"
                                        data-name="{{ $item->name }}" data-email="{{ $item->email }}"
                                        data-pass="{{ $item->pass }}" data-phone_no="{{ $item->phone_no }}"
                                        data-level="{{ $item->level }}" href="#">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                    <a class="btn btn-primary text-base-100 edit_currentpoint" data-bs-toggle="modal"
                                        data-bs-target="#EditCurrentPointModal" data-item="{{ $item->id }}"
                                        data-current_point="{{ $item->current_point }}" href="#">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 delete_members" data-bs-toggle="modal"
                                        data-bs-target="#DeleteMemberModal" data-item="{{ $item->id }}"
                                        data-name="{{ $item->name }}" href="#">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $members->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Member Modal -->
    <div id="DeleteMemberModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDeleteMemberModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Confirm Member Deletion</h2>
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

    <!-- Edit CurrentPoint Modal -->
    <div id="EditMemberModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit Member</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditMemberModal">×</button>
            <form id="editForm" method="POST" action="/edit_members">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input id="name" name="name" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input id="email" name="email" type="email" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="pass" class="block text-sm font-medium">Password</label>
                        <input id="pass" name="pass" type="password" class="input input-bordered w-full" placeholder="Enter new password">
                        <small class="text-gray-500">เว้นว่างไว้หากคุณไม่ต้องการเปลี่ยนรหัสผ่าน</small>
                    </div>
                    <div>
                        <label for="phone_no" class="block text-sm font-medium">Phone Number</label>
                        <input id="phone_no" name="phone_no" type="text" class="input input-bordered w-full"
                            maxlength="10" required>
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-medium">Role</label>
                        <select id="level" name="level" class="input input-bordered w-full" required>
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit CurrentPoint Modal -->
    <div id="EditCurrentPointModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit CurrentPoint</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditCurrentPointModal">×</button>
            <form id="editFormCurrentPoint" method="POST" action="/edit_currentpoint">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="current_point" class="block text-sm font-medium">Current Point</label>
                        <input id="current_point" name="current_point" type="number"
                            class="input input-bordered w-full" required>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEditCurrentPoint">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // DELETE
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DeleteMemberModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete_members');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const itemName = button.getAttribute('data-name');

                    if (!itemId || !itemName) {
                        console.error('ข้อมูลไม่สมบูรณ์');
                        return;
                    }

                    deleteMessage.textContent = `คุณต้องการลบ "${itemName}" นี้หรือไม่?`;
                    deleteForm.setAttribute('action', `/delete_members/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });

            [cancelDelete].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });
        $('#closeDeleteMemberModal, #closeDeleteMemberModalBtn').on('click', function() {
            $('#DeleteMemberModal').addClass('hidden');
        });

        // Edit Current Point
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditCurrentPointModal');
            const editFormCurrentPoint = document.getElementById('editFormCurrentPoint');
            const cancelEditCurrentPoint = document.getElementById('cancelEditCurrentPoint');
            const editButtons = document.querySelectorAll('.edit_currentpoint');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const current_point = button.getAttribute('data-current_point');

                    document.getElementById('current_point').value = current_point;

                    editFormCurrentPoint.setAttribute('action', `/edit_currentpoint/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEditCurrentPoint.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditCurrentPointModal, #closeEditCurrentPointModalBtn').on('click', function() {
            $('#EditCurrentPointModal').addClass('hidden');
        });

        // Edit Members
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditMemberModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_members');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const name = button.getAttribute('data-name');
                    const email = button.getAttribute('data-email');
                    const pass = button.getAttribute('data-pass');
                    const phone_no = button.getAttribute('data-phone_no');
                    const level = button.getAttribute('data-level');

                    document.getElementById('name').value = name;
                    document.getElementById('email').value = email;
                    document.getElementById('pass').value = '';
                    document.getElementById('phone_no').value = phone_no;
                    document.getElementById('level').value = level;

                    editForm.setAttribute('action', `/edit_members/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditMemberModal, #closeEditMemberModalBtn').on('click', function() {
            $('#EditMemberModal').addClass('hidden');
        });
    </script>
@endsection
