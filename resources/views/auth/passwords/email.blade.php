<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="h-screen flex items-center justify-center bg-base-100">
        <div class="shadow rounded-box w-[800px]">
            <div class="navbar bg-blue-500 text-base-100 rounded-t-box border-base-400 border-2">
                <div class="flex-1 uppercase">
                    <a class="btn btn-ghost text-xl">
                        <i class="fas fa-address-book fa-lg"></i>
                        Request OTP
                    </a>
                </div>
            </div>

            @if ($errors->has('email'))
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: '{{ "this email has not inclued in system" }}',
                        icon: 'error'
                    });
                </script>
            @endif

            @if (session('status'))
                <script>
                    Swal.fire({
                        title: 'Request OTP',
                        text: '{{ session('status') }}',
                        icon: 'success'
                    });
                </script>
            @endif

            <div class="p-[20px] border-base-400 border-2 border-t-0 rounded-b-box">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

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

                    <div class="mt-[20px] text-center">
                        <button type="submit" class="btn btn-primary w-[300px] text-lg">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
