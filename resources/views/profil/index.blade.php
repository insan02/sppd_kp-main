@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Ubah Password') }}</h1>

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-lg-4 order-lg-2">
        <div class="card shadow mb-4">
            <div class="card-profile-image mt-4">
                <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->email[0] }}"></figure>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h5 class="font-weight-bold">{{ Auth::user()->email }}</h5>
                            <p>{{Auth::user()->role_user }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Akun saya</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil.update') }}" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <h6 class="heading-small text-muted mb-4">Informasi pengguna</h6>
                    <div class="pl-lg-4">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="current_password">Password</label>
                                <input type="password" id="current_password" class="form-control" name="current_password" placeholder="password">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Password baru</label>
                                <input type="password" id="new_password" class="form-control" name="new_password" placeholder="password baru">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="confirm_password">Konfirmasi password</label>
                                <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="konfirmasi password">
                            </div>
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="pl-lg-4 float-right">
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection