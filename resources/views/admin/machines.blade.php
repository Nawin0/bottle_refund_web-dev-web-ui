@extends('layouts.admin')
@section('title', 'Machines')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-screwdriver-wrench fa-lg"></i>
                    Machines
                </a>
            </div>
            <div class="flex-none gap-2">
                <form class="flex" role="search">
                    <input type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $search }}"
                        class="input input-bordered w-auto" />
                    <button class="btn ml-2" type="submit">Search</button>
                </form>
                <div class="dropdown dropdown-end">
                    <a class="btn btn-success text-base-100" href="#" id="addMachineBtn">
                        <i class="fa-solid fa-plus"></i>Add</a>
                </div>
            </div>
        </div>
        <div class="p-[10px] border-base-400 border-2 border-t-0 rounded-b-box">
            <table class="table rounded shadow table-zebra">
                <thead class="bg-neutral text-neutral-content text-lg">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Remark</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($machines as $item)
                        <tr>
                            <td>{{ $item->id}}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->location }}</td>
                            <td>{{ $item->remark }}</td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn btn-warning text-base-100 edit_machines" data-bs-toggle="modal"
                                        data-bs-target="#EditMachineModal" data-item="{{ $item->id }}" 
                                        data-name="{{ $item->name }}" data-location="{{ $item->location }}" 
                                         data-remark="{{ $item->remark }}" href="#"><i
                                            class="fa-solid fa-edit"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 delete_machines" data-bs-toggle="modal"
                                        data-bs-target="#DeleteMachineModal" data-item="{{ $item->id }}"
                                        data-name="{{ $item->name }}" href="#">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $machines->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Machine Modal -->
    <div id="DeleteMachineModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDeleteMachineModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Confirm Machine Deletion</h2>
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

    <!-- Edit Machine Modal -->
    <div id="EditMachineModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit Machine</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditMachineModal">×</button>
            <form id="editForm" method="POST" action="/edit_machines">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input id="name" name="name" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium">Location</label>
                        <input id="location" name="location" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label for="remark" class="block text-sm font-medium">Remark</label>
                        <input id="remark" name="remark" type="text" class="input input-bordered w-full" required>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn btn-neutral" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-success text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <!-- Add Machines Modal -->
     <div id="addMachineModal"
     class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
     <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
         <h2 class="text-2xl font-semibold mb-4 text-center">Add Machine</h2>
         <button type="button" class="btn-close absolute top-2 right-2" id="closeaddMachineModal">×</button>
         <form action="{{ route('machines.store') }}" method="POST">
             @csrf
             <div class="mb-4">
                 <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                 <input type="text" name="name" id="name" class="input input-bordered w-full" required>
             </div>
             <div class="mb-4">
                 <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                 <input type="text" name="location" id="location" class="input input-bordered w-full" required>
             </div>
             <div class="mb-4">
                 <label for="remark" class="block text-sm font-medium text-gray-700">Remark</label>
                 <input type="text" name="remark" id="remark" class="input input-bordered w-full" required>
             </div>
             <div class="flex justify-center space-x-4">
                 <button type="button" id="cancelModal" class="btn btn-neutral">
                     Cancel
                 </button>
                 <button type="submit" class="btn btn-success text-base-100">
                     Save Machine
                 </button>
             </div>
         </form>
     </div>
 </div>


    <script>
        // DELETE
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DeleteMachineModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete_machines');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const itemName = button.getAttribute('data-name');

                    if (!itemId || !itemName) {
                        console.error('ข้อมูลไม่สมบูรณ์');
                        return;
                    }

                    deleteMessage.textContent = `คุณต้องการลบชื่อ "${itemName}" นี้หรือไม่?`;
                    deleteForm.setAttribute('action', `/delete_machines/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });

            [cancelDelete].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });
        $('#closeDeleteMachineModal, #closeDeleteMachineModalBtn').on('click', function() {
            $('#DeleteMachineModal').addClass('hidden');
        });

        // Edit
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditMachineModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_machines');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const name = button.getAttribute('data-name');
                    const location = button.getAttribute('data-location');
                    const remark = button.getAttribute('data-remark');

                    document.getElementById('name').value = name;
                    document.getElementById('location').value = location;
                    document.getElementById('remark').value = remark;

                    editForm.setAttribute('action', `/edit_machines/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditMachineModal, #closeEditMachineModalBtn').on('click', function() {
            $('#EditMachineModal').addClass('hidden');
        });

        // ADD Machine
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addMachineModal');
            const addMachineBtn = document.getElementById('addMachineBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeModal = document.getElementById('closeModal');

            addMachineBtn.addEventListener('click', () => {
                addMachineModal.classList.remove('hidden');
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
        $('#closeaddMachineModal, #closeaddMachineModalBtn').on('click', function() {
            $('#addMachineModal').addClass('hidden');
        });
    </script>
@endsection
