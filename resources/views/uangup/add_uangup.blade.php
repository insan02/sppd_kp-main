@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah UP') }}</h1>

<!-- Main Content goes here -->
<form action="/uangup/insert" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tanggal</label>
                    <div> </div>
                    <input type='date' name='tanggal' class="form-control" value="{{ old('tanggal') }}">
                    <div class="text-danger">
                        @error('tanggal')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input name="kategori_up" name='kategori_up' class="form-control" value="{{ old('kategori_up') }}">
                    <div class="text-danger">
                        @error('kategori_up')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input name="jumlahup" nama='jumlahup' class="form-control" type="number" value="{{ old('jumlahup') }}">
                    <div class="text-danger">
                        @error('jumlahup')
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