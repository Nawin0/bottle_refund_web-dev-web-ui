@extends('layouts.user')
@section('title', 'profile')
@section('content')
<div class="shadow-xl mx-auto rounded-b-xl">
    <div class="navbar bg-white rounded-t-box  border-base-400 border-2">
        <div class="flex-1 uppercase">
            <a class="btn btn-ghost text-xl">
                <i class="fa-solid fa-address-card"></i>
                Profile
            </a>
        </div>
        <div class="dropdown dropdown-end">
            <a class="btn bg-gradient-to-r from-yellow-400 to-yellow-500 text-base-100 edit_profile" data-bs-toggle="modal" data-bs-target="#EditProductModal"
                data-item="{{ auth()->user()->id }}" data-name="{{ auth()->user()->name }}"
                data-email="{{ auth()->user()->email }}" data-phone_no="{{ auth()->user()->phone_no }}"
                href="#"><i class="fa-solid fa-edit"></i>
            </a>
        </div>
    </div>

    @if ($errors->has('email'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ $errors->first('email') }}",
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

    <!-- Edit Profile Modal -->
    <div id="EditProfileModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <h2 class="text-lg font-bold text-center mb-4">Edit Profile</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditProfileModal">×</button>
            <form id="editForm" method="POST" action="/edit_profile">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input id="name" name="name" type="text" class="input input-bordered w-full"
                            required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input id="email" name="email" type="email" class="input input-bordered w-full"
                            @if (auth()->user()->email_verified_at) readonly @endif value="{{ auth()->user()->email }}"
                        required>
                    </div>
                    <div>
                        <label for="phone_no" class="block text-sm font-medium">Phone Number</label>
                        <input id="phone_no" name="phone_no" type="text" class="input input-bordered w-full"
                            autofocus maxlength="10" required readonly>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" class="btn bg-gradient-to-r from-slate-500 to-slate-600 text-base-100" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="w-100 p-6 bg-white shadow-md rounded-b-xl border-2 border-t-0">
        <!-- Display Data -->
        <div>
            <!-- Name -->
            <div class="mb-4">
                <h2 class="font-medium text-gray-700">Name:</h2>
                <p id="name" class="text-gray-800">{{ $member->name }}</p>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <h2 class="font-medium text-gray-700">Email:</h2>
                <div class="flex items-center gap-4">
                    <p id="email" class="text-gray-800">{{ $member->email }}</p>
                    @if ($member->email_verified_at)
                    <span class="text-green-500 font-bold">✔ Verified</span>
                    @else
                    <button id="verifyEmailBtn" class="px-4 py-2 bg-gradient-to-r from-sky-300 to-sky-400 text-white rounded hover:bg-blue-700">
                        Verify Email
                    </button>
                    @endif
                </div>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <h2 class="font-medium text-gray-700">Phone Number:</h2>
                <p id="phone" class="text-gray-800">{{ $member->phone_no }}</p>
            </div>
        </div>
    </div>

    <!-- emailVerificationModal-->
    <div id="emailVerificationModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h3 class="text-lg font-semibold text-gray-700">การยืนยันอีเมล์</h3>
            <p class="mt-2 text-gray-600">คุณแน่ใจหรือไม่ว่าต้องการยืนยันที่อยู่อีเมล์นี้?</p>
            <div class="flex justify-between mt-4">
                <button id="cancelBtn" class="px-4 py-2 bg-gradient-to-r from-slate-500 to-slate-600 text-base-100 rounded">
                    Cancel
                </button>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-sky-300 to-sky-400 text-white rounded">
                        Yes, Verify
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Confirming Set as Default -->
    <div id="setDefaultModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-96">
            <h3 class="text-lg font-semibold text-gray-700">ยืนยันการตั้งค่าเป็นค่าเริ่มต้น</h3>
            <p class="mt-2 text-gray-600">คุณแน่ใจหรือไม่ว่าต้องการตั้งค่าที่อยู่นี้เป็นค่าเริ่มต้น:
                <span id="addressToSet" class="font-bold"></span>?
            </p>
            <div class="flex justify-between mt-4">
                <button id="cancelSetDefaultBtn" class="px-4 py-2 bg-gradient-to-r from-slate-500 to-slate-600 text-base-100 rounded hover:bg-gray-400"
                    onclick="closeSetDefaultModal()">
                    ยกเลิก
                </button>
                <form id="setDefaultForm" method="POST" action="" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-lime-500 to-lime-600 text-white rounded">
                        ใช่, ตั้งเป็นค่าเริ่มต้น
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Deleting Address -->
    <div id="deleteConfirmationModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-96">
            <h3 class="text-lg font-semibold text-gray-700">ยืนยันการลบ</h3>
            <p class="mt-2 text-gray-600">คุณแน่ใจว่าต้องการลบที่อยู่นี้หรือไม่: <span id="addressToDelete"
                    class="font-bold"></span>?</p>
            <div class="flex justify-between mt-4">
                <button id="cancelDeleteBtn"
                    class="px-4 py-2 bg-gradient-to-r from-slate-500 to-slate-600 text-base-100 rounded hover:bg-gray-400 transition transform duration-300 ease-in-out hover:scale-105">
                    ยกเลิก
                </button>
                <form id="deleteForm" method="POST" action="" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-base-100 rounded hover:bg-red-600 transition transform duration-300 ease-in-out hover:scale-105">
                        ใช่, ลบ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Address -->
    <div id="editAddressModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Edit Address</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeEditAddressModal">×</button>

            <form id="editAddressForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="editAddress" class="input input-bordered w-full"
                        required>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelEditAddressModal" class="btn bg-gradient-to-r from-slate-500 to-slate-600 text-base-100">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100">
                        บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div id="addAddressModal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-2xl font-semibold mb-4 text-center">Add Address</h2>
            <button type="button" class="btn-close absolute top-2 right-2" id="closeaddAddressModal">×</button>
            <form action="{{ route('profile.add_address') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="input input-bordered w-full"
                        required>
                </div>
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelAddAddressModal" class="btn bg-gradient-to-r from-slate-500 to-slate-600 text-base-100">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100">
                        เพิ่มที่อยู่
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Edit
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('EditProfileModal');
            const editForm = document.getElementById('editForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const editButtons = document.querySelectorAll('.edit_profile');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const itemId = button.getAttribute('data-item');
                    const name = button.getAttribute('data-name');
                    const email = button.getAttribute('data-email');
                    const phone_no = button.getAttribute('data-phone_no');

                    document.getElementById('name').value = name;
                    document.getElementById('email').value = email;
                    document.getElementById('phone_no').value = phone_no;

                    editForm.setAttribute('action', `/edit_profile/${itemId}`);
                    modal.classList.remove('hidden');
                });
            });
            cancelEdit.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeEditProfileModal, #closeEditProfileModalBtn').on('click', function() {
            $('#EditProfileModal').addClass('hidden');
        });

        // Button Verify Email
        document.addEventListener('DOMContentLoaded', function() {
            const verifyEmailBtn = document.getElementById('verifyEmailBtn');
            const emailVerificationModal = document.getElementById('emailVerificationModal');
            const cancelBtn = document.getElementById('cancelBtn');

            if (verifyEmailBtn) {
                verifyEmailBtn.addEventListener('click', function() {
                    emailVerificationModal.classList.remove('hidden');
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    emailVerificationModal.classList.add('hidden');
                });
            }

            emailVerificationModal.addEventListener('click', function(e) {
                if (e.target === emailVerificationModal) {
                    emailVerificationModal.classList.add('hidden');
                }
            });
        });

        // ADD Address
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addAddressModal');
            const addAddressBtn = document.getElementById('addAddressBtn');
            const cancelAddAddressModal = document.getElementById('cancelAddAddressModal');
            const closeModal = document.getElementById('closeModal');

            addAddressBtn.addEventListener('click', () => {
                addAddressModal.classList.remove('hidden');
            });

            [cancelAddAddressModal, closeModal].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            modal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
        $('#closeaddAddressModal, #closeaddAddressModalBtn').on('click', function() {
            $('#addAddressModal').addClass('hidden');
        });

        // Edit Address
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editAddressModal');
            const cancelEditAddressModal = document.getElementById('cancelEditAddressModal');
            const closeModal = document.getElementById('closeEditAddressModal');

            window.openEditModal = function(id, address) {
                modal.classList.remove('hidden');
                document.getElementById('editAddress').value = address;
                const form = document.getElementById('editAddressForm');
                form.action = '/profile/' + id;
            };

            [cancelEditAddressModal, closeModal].forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        });

        //DELETE Address
        document.addEventListener('DOMContentLoaded', () => {
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            window.openDeleteConfirmationModal = function(addressId, address) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/profile/${addressId}`;

                document.getElementById('addressToDelete').textContent = address;

                deleteConfirmationModal.classList.remove('hidden');
            };

            cancelDeleteBtn.addEventListener('click', () => {
                deleteConfirmationModal.classList.add('hidden');
            });

            deleteConfirmationModal.addEventListener('click', (e) => {

                if (e.target === deleteConfirmationModal) {
                    deleteConfirmationModal.classList.add('hidden');
                }
            });
        });

        // Set Address
        let selectedAddressId = null;
        let selectedAddressText = null;

        function openSetAsDefaultModal(id, address) {
            selectedAddressId = id;
            selectedAddressText = address;
            document.getElementById('addressToSet').innerText = address;
            document.getElementById('setDefaultModal').classList.remove('hidden');
            document.getElementById('setDefaultForm').action = `/profile/${id}`;
        }

        function closeSetDefaultModal() {
            document.getElementById('setDefaultModal').classList.add('hidden');
        }
    </script>
</div>

{{-- Display Address Users --}}
<div class="shadow-xl rounded-box mx-auto mt-2 bg-white">
    <div class="navbar rounded-t-box border-base-400 border-2">
        <div class="flex-1 uppercase">
            <a class="btn btn-ghost text-xl">
                <i class="fa-solid fa-address-card"></i>
                Address
            </a>
        </div>
        <div class="dropdown-end">
            <a class="btn bg-gradient-to-r from-lime-500 to-lime-600 text-base-100" href="#" id="addAddressBtn">
                <i class="fa-solid fa-plus"></i>Add</a>
        </div>
    </div>
    <div class="w-100 p-6 border-base-400 rounded-b-box border-2 border-t-0">
        <!-- Display Data -->
        <div>
            <div class="mb-4">
                <h2 class="font-medium text-gray-700">Address:</h2>
                @foreach ($address as $addr)
                <p id="phone" class="text-gray-800">{{ $addr->address }}</p>

                <div class="flex justify-end space-x-4 mt-2">

                    <!-- Edit Button -->
                    <button type="button" class="text-blue-500"
                        onclick="openEditModal({{ $addr->id }}, '{{ $addr->address }}')">เเก้ไข</button>

                    <!-- Delete Button -->
                    <button type="button" class="text-red-500"
                        onclick="openDeleteConfirmationModal({{ $addr->id }}, '{{ $addr->address }}')">
                        ลบ
                    </button>
                </div>

                <!-- Setting as Default Button or message aligned to the right -->
                <div class="flex justify-end mt-2">
                    @if ($addr->status != 2)
                    <button type="button" class="text-yellow-500 hover:text-yellow-600"
                        onclick="openSetAsDefaultModal({{ $addr->id }}, '{{ $addr->address }}')">
                        ตั้งค่าเป็นค่าเริ่มต้น
                    </button>
                    @else
                    <span class="text-green-500">นี่คือที่อยู่เริ่มต้น</span>
                    @endif
                </div>

                <div class="border-t border-gray-300 my-2"></div>
                @endforeach
            </div>
        </div>
        <div class="mb-4 mt-6 px-3">
            {{ $address->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
