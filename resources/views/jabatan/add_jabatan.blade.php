@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Tambah Jabatan') }}</h1>

<!-- Main Content goes here -->
<form action="/jabatan/insert" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input name="nama_jabatan" class="form-control" value="{{ old('nama_jabatan') }}">
                    <div class="text-danger">
                        @error('nama_jabatan')
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