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
    <div class="navbar bg-blue-500">
        @auth
            <div class="flex-none lg:hidden">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost text-base-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                        <li>
                            <details class="dropdown">
                                <summary class="relative"><i class="fa-solid fa-database"></i>Master</summary>
                                <ul>
                                    <li><a href="/users"><i class="fas fa-address-book fa-lg"></i>Users</a></li>
                                    <li><a href="/branches"><i class="fa-solid fa-code-branch fa-lg"></i>Branches</a>
                                    </li>
                                    <li><a href="/locations"><i
                                                class="fa-solid fa-location-crosshairs fa-lg"></i>Locations</a></li>
                                    <li><a href="/product_types"><i class="fa-brands fa-intercom"></i>Product Types</a>
                                    </li>
                                    <li><a href="/products"><i class="fa-solid fa-briefcase"></i>Product</a></li>
                                    <li><a href="/racks"><i class="fa-solid fa-align-justify fa-lg"></i>Racks</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a href="/packings"><i class="fa-solid fa-boxes-packing"></i>Packing</a></li>
                        <li><a href="/stores"><i class="fa-solid fa-store"></i>Store</a></li>
                        <li><a href="/check_outs"><i class="fa-solid fa-truck-arrow-right"></i>Check out</a></li>
                        <li>
                            <details class="dropdown">
                                <summary class="relative"><i class="fa-solid fa-chart-line"></i>Report</summary>
                                <ul>
                                    <li><a href="/reports"><i class="fa-solid fa-print"></i>Report 1</a></li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth
        <div class="flex-1">
            <a class="btn btn-ghost text-xl text-base-100 uppercase">Bottle Refund</a>
        </div>
        <div class="flex-none">
            @auth

                <div class="bg-base-100 flex items-center rounded-box p-2 lg:hidden">
                    <a class="btn btn-xs btn-success text-base-100 mr-2 capitalize">{{ Auth::user()->role }}</a>
                    <h1 class="text-xl">{{ Auth::user()->name }}</h1>
                </div>

            @endauth
        </div>
    </div>
    <!-- Navigation button END -->

    <div class="h-full w-full">
        <div class="flex" id="displayPlatforms" style="height: inherit;">
            <div class="lg:p-[10px]" id="collapseOne">
                <div class="hidden lg:block">

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <div class="bg-neutral p-2 rounded-t-box">
                            <div class="bg-base-100 flex items-center rounded-box p-2">
                                <a class="btn btn-xs btn-success text-base-100 mr-2 capitalize">{{ Auth::user()->role }}</a>
                                <h1 class="text-xl">{{ Auth::user()->name }}</h1>
                            </div>
                        </div>
                        <ul class="menu bg-neutral text-neutral-content rounded-b-box w-72 text-xl" role="group"
                            aria-label="Vertical button group">
                            <li>
                                <details class="dropdown">
                                    <summary class="hover:bg-base-100 hover:text-neutral"><i
                                            class="fa-solid fa-database"></i>Master</summary>
                                    <ul
                                        class="menu dropdown-content bg-neutral text-neutral-content w-full rounded-box z-[1] p-2 shadow">
                                        <li><a href="/users" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fas fa-address-book fa-lg"></i>Users</a></li>
                                        <li><a href="/branches" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-solid fa-code-branch fa-lg"></i>Branches</a>
                                        </li>
                                        <li><a href="/locations" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-solid fa-location-crosshairs fa-lg"></i>Locations</a></li>
                                        <li><a href="/product_types" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-brands fa-intercom"></i>Product Types</a>
                                        </li>
                                        <li><a href="/products" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-solid fa-briefcase"></i>Product</a></li>
                                        <li><a href="/racks" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-solid fa-align-justify fa-lg"></i>Racks</a></li>
                                    </ul>
                                </details>
                            </li>
                            <li><a href="/packings" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fa-solid fa-boxes-packing"></i>Packing</a></li>
                            <li><a href="/stores" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fa-solid fa-store"></i>Store</a></li>
                            <li><a href="/check_outs" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fa-solid fa-truck-arrow-right"></i>Check out</a></li>
                            <li>
                                <details class="dropdown">
                                    <summary class="hover:bg-base-100 hover:text-neutral"><i
                                            class="fa-solid fa-chart-line"></i>Report</summary>
                                    <ul
                                        class="menu dropdown-content bg-neutral text-neutral-content w-full rounded-box z-[1] p-2 shadow">
                                        <li><a href="" class="hover:bg-base-100 hover:text-neutral"><i
                                                    class="fa-solid fa-print"></i>Report 1</a></li>
                                    </ul>
                                </details>
                            </li>


                            <button type="button" class="btn mt-2">
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
            <div class="p-[10px] w-full" style="overflow: hidden;">
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
