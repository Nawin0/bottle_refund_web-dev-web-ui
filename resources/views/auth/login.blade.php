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
                <form method="POST" action="{{ route('login') }}">
                    @csrf

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

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-[20px] text-center">
                        <button type="submit" class="btn btn-primary w-[300px] text-lg">
                            {{ __('Login') }}
                        </button>
                    </div>

                </form>

                <div class="mt-4 text-center">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-red-500">Register here</a></p>
                </div>
                <div class="mt-4 text-center">
                    <p>Forgot your password? <a href="{{ route('password.request') }}" class="text-red-500">ResetPassword here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
