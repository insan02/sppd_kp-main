@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Data Transportasi') }}</h1>

<!-- Main Content goes here -->
<form action="/transportasi/update/{{ $transportasi->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Jenis Transportasi</label>
                    <input name="jenis_transportasi" class="form-control" value="{{ $transportasi->jenis_transportasi }}">
                    <div class="text-danger">
                        @error('jenis_transportasi')
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