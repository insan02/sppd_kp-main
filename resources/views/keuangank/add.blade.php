@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah Data Keuangan') }}</h1>

<!-- Main Content goes here -->
<form action="/keuangank/store" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Surat</label>
                    <select name="kantor_id" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($kantor as $item)
                        <option value="{{ $item->id }}">{{ $item->judul_surat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Transportasi</label>
                    <select name="transportasi_id" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($transportasi as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis_transportasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Penginapan</label>
                    <select name="penginapan_id" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($penginapan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_penginapan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Uang Transportasi</label>
                    <input name="uang_transport" class="form-control" value="{{ old('uang_transport') }}">
                    <div class="text-danger">
                        @error('uang_transport')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Uang Penginapan</label>
                        <input name="uang_penginapan" class="form-control" value="{{ old('uang_penginapan') }}">
                        <div class="text-danger">
                            @error('uang_penginapan')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- End of Main Content -->
@endsection