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
                                <summary class="relative"><i class="fa-solid fa-users-gear"></i>Members</summary>
                                <ul>
                                    <li><a href="/members"><i class="fa-solid fa-users-gear"></i>Members</a></li>
                                    <li><a href="/logcurrentpoints"><i
                                                class="fa-solid fa-users-rectangle"></i>Logcurrentpoints</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a href="/machines"><i class="fas fa-screwdriver-wrench fa-lg"></i>Machines</a></li>
                        <li><a href="/products"><i class="fas fa-bottle-water"></i>Products</a></li>
                        <li><a href="/transactions"><i class="fas fa-money-bill"></i>Transactions</a></li>
                        <li><a href="/historyreward"><i class="fas fa-history"></i>History Reward</a></li>
                        <li><a href="/rewarditems"><i class="fas fa-archive"></i>Rewarditems</a></li>
                        <li><a href="/logpoints"><i class="fas fa-history"></i>LogPoints</a></li>
                        <li><a href="/news"><i class="fa-solid fa-newspaper"></i>News</a></li>
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
                    <a
                        class="btn btn-xs btn-success text-base-100 mr-2 capitalize">{{ Auth::user()->level == 2 ? 'admin' : Auth::user()->level }}</a>
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
                                <a
                                    class="btn btn-xs btn-success text-base-100 mr-2 capitalize">{{ Auth::user()->level == 2 ? 'admin' : Auth::user()->level }}</a>
                                <h1 class="text-xl">{{ Auth::user()->name }}</h1>
                            </div>
                        </div>
                        <ul class="menu bg-neutral text-neutral-content rounded-b-box w-72 text-xl" role="group"
                            aria-label="Vertical button group">
                            <li>
                                <details class="dropdown">
                                    <summary class="hover:bg-base-100 hover:text-neutral"><i
                                            class="fa-solid fa-users-gear"></i>Members</summary>
                                    <ul
                                        class="menu dropdown-content bg-neutral text-neutral-content w-full rounded-box z-[1] p-2 shadow">
                                        <li><a href="/members" class="hover:bg-base-100 hover:text-neutral">
                                                <i class="fa-solid fa-user-gear"></i>Members</a></li>
                                        <li><a href="/logcurrentpoints" class="hover:bg-base-100 hover:text-neutral">
                                                <i class="fa-solid fa-users-rectangle"></i>Logcurrentpoints</a></li>
                                    </ul>
                                </details>
                            </li>
                            <li><a href="/machines" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-screwdriver-wrench fa-lg"></i>Machines</a></li>
                            <li><a href="/products" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-bottle-water"></i>Products</a></li>
                            <li><a href="/transactions" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-money-bill"></i>Transactions</a></li>
                            <li><a href="/historyreward" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-history"></i>HistoryReward</a></li>
                            <li><a href="/rewarditems" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-archive"></i>RewardItems</a></li>
                            <li><a href="/logpoints" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fas fa-history"></i>LogPoints</a></li>
                            <li><a href="/news" class="hover:bg-base-100 hover:text-neutral"><i
                                        class="fa-solid fa-newspaper"></i>News</a></li>
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
