@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="karyawan_id" class="col-md-4 col-form-label text-md-end">{{ __('karyawan_id') }}</label>

                            <div class="col-md-6">
                                <input id="karyawan_id" type="text" class="form-control @error('karyawan_id') is-invalid @enderror" name="karyawan_id" value="{{ old('karyawan_id') }}" required autocomplete="name" autofocus>

                                @error('karyawan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role_user" class="col-md-4 col-form-label text-md-end">{{ __('role_user') }}</label>

                            <div class="col-md-6">
                                <input id="role_user" type="text" class="form-control @error('role_user') is-invalid @enderror" name="role_user" value="{{ old('role_user') }}" required autocomplete="name" autofocus>

                                @error('role_user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @if (Route::has('login'))
                                    <div class="text-left">
                                        <a class="small" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </div>
                                @endif 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection