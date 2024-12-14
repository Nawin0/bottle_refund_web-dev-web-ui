<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="h-screen flex items-center justify-center bg-base-100">
        <div class="shadow rounded-box w-[800px]">
            <div class="navbar bg-blue-500 text-base-100 rounded-t-box border-base-400 border-2">
                <div class="flex-1 uppercase">
                    <a class="btn btn-ghost text-xl">
                        <i class="fas fa-address-book fa-lg"></i>
                        Bottle Refund
                    </a>
                </div>

            </div>
            <div class="p-[20px] border-base-400 border-2 border-t-0 rounded-b-box">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                        <div class="mt-2">
                            <input id="name" type="text" class="input input-bordered w-full" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                        <div class="mt-2">
                            <input id="email" type="email" class="input input-bordered w-full" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone_no"
                            class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                        <div class="mt-2">
                            <input id="phone_no" type="text" class="input input-bordered w-full" name="phone_no"
                                value="{{ old('phone_no') }}" required autocomplete="phone_no" autofocus maxlength="10">

                            @error('phone_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pass" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="mt-2">
                            <input id="pass" type="password" class="input input-bordered w-full" name="pass"
                                required autocomplete="current-password">

                            @error('pass')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pass-confirm"
                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="mt-2">
                            <input id="pass-confirm" type="password" class="input input-bordered w-full"
                                name="pass_confirmation" required autocomplete="new-password">

                            @error('pass_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="mt-[20px] text-center">
                        <button type="submit" class="btn btn-primary w-[300px] text-lg">
                            {{ __('Register') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
