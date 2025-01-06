@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Data Uang UP') }}</h1>

<!-- Main Content goes here -->
<form action="/uangup/update/{{ $uangup->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input name="tanggal" class="form-control" value="{{ $uangup->tanggal }}">
                    <div class="text-danger">
                        @error('tanggal')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input name="kategori_up" class="form-control" value="{{ $uangup->kategori_up }}">
                    <div class="text-danger">
                        @error('kategori_up')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input name="jumlahup" class="form-control" value="{{ $uangup->jumlahup }}">
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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<!-- End of Main Content -->

@endsection