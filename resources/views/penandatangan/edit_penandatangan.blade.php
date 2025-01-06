@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Data Penanda Tangan') }}</h1>

<!-- Main Content goes here -->
<form action="/penandatangan/update/{{ $penandatangan->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama</label>
                    <select name="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                        <option value="">- Pilih Karyawan-</option>
                        @foreach($karyawan as $item)
                        <option value="{{ $item->id }}" {{ old('karyawan_id', $penandatangan->karyawan_id) == $item->id ? 'selected' : null }}>{{ $item->nama}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('karyawan_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
                        <option value="">- Pilih Jabatan -</option>
                        @foreach($jabatan as $item)
                        <option value="{{ $item->id }}" {{ old('jabatan_id', $penandatangan->jabatan_id) == $item->id ? 'selected' : null }}>{{ $item->nama_jabatan}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('jabatan_id')
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