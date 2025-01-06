@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Data Lokasi') }}</h1>

<!-- Main Content goes here -->
<form action="/lokasi/update/{{ $lokasi->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama Provinsi</label>
                    <input name="Provinsi" class="form-control" value="{{ $lokasi->Provinsi }}">
                    <div class="text-danger">
                        @error('Provinsi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Kota</label>
                    <input name="nama_kota" class="form-control" value="{{ $lokasi->nama_kota }}">
                    <div class="text-danger">
                        @error('nama_kota')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Besaran Lumpsum</label>
                    <input name="besaran_lumpsum" class="form-control" value="{{ $lokasi->besaran_lumpsum }}">
                    <div class="text-danger">
                        @error('besaran_lumpsum')
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