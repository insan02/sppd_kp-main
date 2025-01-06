@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah User') }}</h1>

<!-- Main Content goes here -->
<form action="/user/insert" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama</label>
                    <select name="karyawan_id" class="form-control">
                        <option value="">- Pilih Karyawan-</option>
                        @foreach ($karyawan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input name='email' class="form-control" value="{{ old('email') }}">
                    <div class="text-danger">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name='password' class="form-control" value="{{ old('password') }}">
                    <div class="text-danger">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Role User</label>
                    <div> </div>
                    <select name='role_user' class="form-control" aria-label="Default select example" value="{{ old('role_user') }}">
                        <option selected>- Pilih Role -</option>
                        <option value="Admin">Admin</option>
                        <option value="Pimpinan">Pimpinan</option>
                        <option value="Admin HKT">Admin HKT</option>
                        <option value="Admin Keuangan">Admin Keuangan</option>
                    </select>
                    <div class="text-danger">
                        @error('role_user')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- End of Main Content -->
@endsection