@extends('layouts.admin')
@section('title', 'Transactions')
@section('content')
    <div class="shadow rounded-box mx-auto">
        <div class="navbar bg-base-200 rounded-t-box border-base-400 border-2">
            <div class="flex-1 uppercase">
                <a class="btn btn-ghost text-xl">
                    <i class="fas fa-money-bill"></i>
                    Transactions
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
                        <th scope="col">Product</th>
                        <th scope="col">Barcode</th>
                        <th scope="col">Image</th>
                        <th scope="col">Flag</th>
                        <th class="rounded-tr" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-[16px]">
                    @foreach ($transactions as $item)
                        <tr>
                            <td>{{ $item->phone_no }}</td>
                            <td>{{ $item->product->name ?? 'ไม่มี Barcode นี้ในระบบ' }}</td>
                            <td>{{ $item->barcode }}</td>
                            <td>
                                <img src="data:image/*;base64,{{ $item->image64 }}" alt="image"
                                    class="w-20 h-20 object-cover cursor-pointer"
                                    onclick="showImagePopup('{{ 'data:image/*;base64,' . $item->image64 }}')">
                            </td>
                            <td>{{ $item->flag }}</td>
                            <td>
                                @if (Auth::user()->level == '2')
                                    <a class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                        data-bs-toggle="modal" data-bs-target="#DetailsModal"
                                        data-item="{{ $item->id }}" data-name="{{ $item->member->name ?? 'ไม่มีข้อมูลนี้ในระบบ' }}"
                                        data-email="{{ $item->member->email ?? 'ไม่มีข้อมูลนี้ในระบบ' }}" data-phone_no="{{ $item->phone_no }}"
                                        data-product="{{ $item->product->name ?? 'ไม่มี Barcode นี้ในระบบ' }}" data-barcode="{{ $item->barcode }}"
                                        data-flag="{{ $item->flag }}" href="#"><i
                                            class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                    <a class="btn btn-success text-base-100 approve_transaction" data-bs-toggle="modal"
                                        data-bs-target="#ApproveTransactionModal" data-item="{{ $item }}"
                                        href="#"><i class="fa-solid fa-thumbs-up"></i>
                                    </a>
                                    <a class="btn btn-error text-base-100 reject_transaction" data-bs-toggle="modal"
                                        data-bs-target="#RejectTransactionModal" data-item="{{ $item }}"
                                        href="#"><i class="fa-solid fa-thumbs-down"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links('vendor.pagination.tailwind') }}
        </div>
    </div>

     <!-- Detalis Modal -->
     <div id="DetailsModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
            <button type="button" class="btn-close absolute top-2 right-2" id="closeDetailsModal">×</button>
            <h2 class="text-lg font-bold text-center mb-4">Name</h2>
            <p id="NameMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Email</h2>
            <p id="EmailMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Phone Number</h2>
            <p id="PhoneMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Product</h2>
            <p id="ProductMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Barcode</h2>
            <p id="BarcodeMessage" class="text-center text-gray-600 mb-6"></p>
            <h2 class="text-lg font-bold text-center mb-4">Flag</h2>
            <p id="FlagMessage" class="text-center text-gray-600 mb-6"></p>
            <div class="flex justify-center gap-4">
                <button id="cancelDetails" class="btn btn-neutral">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Approve Flag Modal -->
    <div id="ApproveTransactionModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <form id="form-approve-transaction" action="" method="post">
                @csrf
                <div class="flex justify-between items-center p-4 border-b">
                    <h5 class="text-lg font-semibold">Approve Transaction</h5>
                    <button type="button" class="btn-close" id="closeApproveModal">×</button>
                </div>
                <div class="p-4">
                    <p><strong>อนุมัติการให้คะแนนสำหรับหมายเลขโทรศัพท์ <span id="approve-phone"></span></strong></p>
                </div>
                <div class="flex justify-end p-4 border-t gap-2">
                    <button type="submit" class="btn btn-success text-base-100"><i class="fa-solid fa-thumbs-up"></i>
                        Approve</button>
                    <button type="button" class="btn" id="closeApproveModalBtn">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Flag Modal -->
    <div id="RejectTransactionModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <form id="form-reject-transaction" action="" method="post">
                @csrf
                <div class="flex justify-between items-center p-4 border-b">
                    <h5 class="text-lg font-semibold">Reject Transaction</h5>
                    <button type="button" class="btn-close" id="closeRejectModal">×</button>
                </div>
                <div class="p-4">
                    <p><strong>ไม่อนุมัติการให้คะแนนสำหรับหมายเลขโทรศัพท์ <span id="reject-phone"></span></strong></p>
                </div>
                <div class="flex justify-end p-4 border-t gap-2">
                    <button type="submit" class="btn btn-error text-base-100"><i class="fa-solid fa-thumbs-down"></i>
                        Reject</button>
                    <button type="button" class="btn" id="closeRejectModalBtn">Close</button>
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
        // Detalis
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('DetailsModal');
            const NameMessage = document.getElementById('NameMessage');
            const EmailMessage = document.getElementById('EmailMessage');
            const PhoneMessage = document.getElementById('PhoneMessage');
            const ProductMessage = document.getElementById('ProductMessage');
            const BarcodeMessage = document.getElementById('BarcodeMessage');
            const FlagMessage = document.getElementById('FlagMessage');
            const cancelDetails = document.getElementById('cancelDetails');
            const closeDetailsModal = document.getElementById('closeDetailsModal');

            document.querySelectorAll('[data-bs-target="#DetailsModal"]').forEach(button => {
                button.addEventListener('click', () => {

                    const name = button.getAttribute('data-name');
                    NameMessage.textContent = name;

                    const email = button.getAttribute('data-email');
                    EmailMessage.textContent = email;

                    const phone_no = button.getAttribute('data-phone_no');
                    PhoneMessage.textContent = phone_no;

                    const product = button.getAttribute('data-product');
                    ProductMessage.textContent = product;

                    const barcode = button.getAttribute('data-barcode');
                    BarcodeMessage.textContent = barcode;

                    const flag = button.getAttribute('data-flag');
                    FlagMessage.textContent = flag;
                    
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

        //Approve
        $(document).on('click', '.approve_transaction', function(e) {
            let item = $(this).data('item');

            document.getElementById("form-approve-transaction").action = "/approve_transaction/" + item['id'];
            const phone = $(this).closest('tr').find('td:first').text().trim();
            $('#approve-phone').text(phone);

            $('#ApproveTransactionModal').removeClass('hidden');
        });

        // Reject
        $(document).on('click', '.reject_transaction', function(e) {
            let item = $(this).data('item');

            document.getElementById("form-reject-transaction").action = "/reject_transaction/" + item['id'];
            const phone = $(this).closest('tr').find('td:first').text().trim();
            $('#reject-phone').text(phone);

            $('#RejectTransactionModal').removeClass('hidden');
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

        $('#closeApproveModal, #closeApproveModalBtn').on('click', function() {
            $('#ApproveTransactionModal').addClass('hidden');
        });

        $('#closeRejectModal, #closeRejectModalBtn').on('click', function() {
            $('#RejectTransactionModal').addClass('hidden');
        });
    </script>
@endsection
