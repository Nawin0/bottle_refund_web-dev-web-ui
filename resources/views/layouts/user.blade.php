<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    @vite('resources/css/app.css')

</head>

<body>
    <!-- Navigation button -->
    <div class="navbar bg-gradient-to-r from-lime-500 to-lime-600 drop-shadow-xl">
        @auth
        <div class="flex-none lg:hidden">
            <div class="dropdown">

                <button class="btn btn-ghost text-base-100" id="open-sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

            </div>
        </div>
        @endauth
        <div class="flex-1">
            <a class="btn btn-ghost text-xl text-base-100 uppercase">Bottle Refund USER</a>
        </div>
    </div>


    <!-- Navigation button END -->

    <div class="h-full w-full bg-slate-200">
        <div class="flex" id="displayPlatforms" style="height: inherit;">



            <!-- Sidebar Start -->
            <div class="h-screen flex overflow-hidden">
                <!-- Sidebar -->
                <div class="absolute bg-white w-70 min-h-screen overflow-y-auto transition-transform transform -translate-x-full ease-in-out duration-300 drop-shadow-xl block lg:hidden rounded-b-xl rounded-l-none"
                    id="sidebar">
                    <!-- Your Sidebar Content -->
                    <div class="p-2">
                        @guest
                        @if (Route::has('login'))
                        @endif
                        @else
                        <div class="p-2">
                            <div class="bg-base-100 flex items-center pl-4 pt-3 pb-3 rounded-full drop-shadow-md">
                                <a
                                    class="btn btn-xs bg-gradient-to-r from-lime-500 to-lime-600 text-base-100 mr-2 capitalize">{{ Auth::user()->level == 1 ? 'user' : Auth::user()->level }}</a>
                                <h1 class="text-xl">{{ Auth::user()->name }}</h1>
                            </div>
                        </div>
                        <ul class="menu text-neutral-content w-72 text-xl mt-0 pt-0" role="group"
                            aria-label="Vertical button group">
                            <li class="mb-1 mt-2"><a href="/new"
                                    class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700">
                                    <i class="fa-solid fa-newspaper"></i>News</a></li>
                            <li class="mb-1"><a href="/mypoint/{{ auth()->user()->id }}"
                                    class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                        class="fa-solid fa-coins"></i>My Point</a></li>
                            <li class="mb-1"><a href="/reward"
                                    class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                        class="fa-solid fa-gift"></i>Gifts</a></li>
                            <li class="mb-1"><a href="/exchange_history/{{ auth()->user()->id }}"
                                    class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                        class="fas fa-history"></i>Exchange History</a></li>
                            <li>
                                <details class="dropdown">
                                    <summary
                                        class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700">
                                        <i class="fa-solid fa-gear"></i>Setting
                                    </summary>
                                    <ul style="width:100%; margin-left:0px;">
                                        <li><a class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700 ml-5 pl-6 mt-1"
                                                href="/profile/{{ auth()->user()->id }}"><i
                                                    class="fa-solid fa-address-card"></i>My Profile</a></li>
                                        <li><a class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700 ml-5 pl-6 mt-1"
                                                href="/contract_admin"><i class="fa-solid fa-user"></i>Contract Admin</a>
                                        </li>
                                    </ul>
                                </details>
                            </li>

                            <button type="button"
                                class="btn mt-24 text-base flex justify-start pl-6 bg-white rounded-full hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white drop-shadow-0"
                                style="border: 0;">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                    <i class="fas fa-right-from-bracket fa-lg"></i>
                                    Logout
                                </a>
                            </button>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                        @endguest
                    </div>
                </div>
            </div>

            <script>
                const sidebar = document.getElementById('sidebar');
                const openSidebarButton = document.getElementById('open-sidebar');

                openSidebarButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });

                // Close the sidebar when clicking outside of it
                document.addEventListener('click', (e) => {
                    if (!sidebar.contains(e.target) && !openSidebarButton.contains(e.target)) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            </script>
            <!-- Sidebar End -->




            <div class="" id="collapseOne">
                <div class="hidden lg:block bg-white drop-shadow-xl" style="height: 130vh; margin:0px; padding:0px;">

                    @guest
                    @if (Route::has('login'))
                    @endif
                    @else
                    <div class="p-2">
                        <div class="bg-base-100 flex items-center pl-4 pt-3 pb-3 rounded-full drop-shadow-md">
                            <a
                                class="btn btn-xs bg-gradient-to-r from-lime-500 to-lime-600 text-base-100 mr-2 capitalize">{{ Auth::user()->level == 1 ? 'user' : Auth::user()->level }}</a>
                            <h1 class="text-xl">{{ Auth::user()->name }}</h1>
                        </div>
                    </div>
                    <ul class="menu text-neutral-content w-72 text-xl mt-0 pt-0" role="group"
                        aria-label="Vertical button group">
                        <li class="mb-1 mt-2"><a href="/new"
                                class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700">
                                <i class="fa-solid fa-newspaper"></i>News</a></li>
                        <li class="mb-1"><a href="/mypoint/{{ auth()->user()->id }}"
                                class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                    class="fa-solid fa-coins"></i>My Point</a></li>
                        <li class="mb-1"><a href="/reward"
                                class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                    class="fa-solid fa-gift"></i>Gifts</a></li>
                        <li class="mb-1"><a href="/exchange_history/{{ auth()->user()->id }}"
                                class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700"><i
                                    class="fas fa-history"></i>Exchange History</a></li>
                        <li>
                            <details class="dropdown">
                                <summary
                                    class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700">
                                    <i class="fa-solid fa-gear"></i>Setting
                                </summary>
                                <ul style="width:100%; margin-left:0px;">
                                    <li><a class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700 ml-5 pl-6 mt-1"
                                            href="/profile/{{ auth()->user()->id }}"><i
                                                class="fa-solid fa-address-card"></i>My Profile</a></li>
                                    <li><a class="hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white rounded-full text-slate-700 ml-5 pl-6 mt-1"
                                            href="/contract_admin"><i class="fa-solid fa-user"></i>Contract Admin</a>
                                    </li>
                                </ul>
                            </details>
                        </li>

                        <button type="button"
                            class="btn mt-24 text-base flex justify-start pl-6 bg-white rounded-full hover:bg-gradient-to-r from-lime-500 to-lime-600 hover:drop-shadow-md hover:text-white drop-shadow-0"
                            style="border: 0;">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                <i class="fas fa-right-from-bracket fa-lg"></i>
                                Logout
                            </a>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                    @endguest
                </div>
            </div>
            <div class="p-[10px] w-full bg-slate-200" style="overflow: hidden;">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
