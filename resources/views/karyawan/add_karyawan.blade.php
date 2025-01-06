@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah Karyawan') }}</h1>

<!-- Main Content goes here -->
<form action="/karyawan/insert" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>NIP</label>
                    <input name="nip" class="form-control" value="{{ old('nip') }}">
                    <div class="text-danger">
                        @error('nip')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input name='nama' class="form-control" value="{{ old('nama') }}">
                    <div class="text-danger">
                        @error('nama')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div> </div>
                    <select name='gender' class="form-control" aria-label="Default select example" value="{{ old('gender') }}">
                        <option selected>- Pilih Jenis Kelamin -</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div class="text-danger">
                        @error('gender')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Divisi</label>
                    <div> </div>
                    <select name='divisi' class="form-control" aria-label="Default select example" value="{{ old('divisi') }}">
                        <option selected>- Pilih Divisi -</option>
                        <option value="Pimpinan">Pimpinan</option>
                        <option value="HKT">HKT</option>
                        <option value="SIK">SIK</option>
                        <option value="ICT">ICT</option>
                        <option value="Akademik & Kemahasiswaan">Akademik & Kemahasiswaan</option>
                        <option value="Perencanaan & Penganggaran">Perencanaan & Penganggaran</option>
                        <option value="SDPT">SDPT</option>
                        <option value="SIK">SIK</option>
                        <option value="Sarana dan Prasarana">Sarana dan Prasarana</option>
                        <option value="TU dan BMN">TU dan BMN</option>
                        <option value="Akademik">Akademik</option>
                    </select>
                    <div class="text-danger">
                        @error('divisi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input name='jabatan' class="form-control" value="{{ old('jabatan') }}">
                    <div class="text-danger">
                        @error('jabatan')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Golongan</label>
                    <div> </div>
                    <select name='golongan' class="form-control" aria-label="Default select example" value="{{ old('golongan') }}">
                        <option selected>- Pilih Golongan -</option>
                        <option value="I a">I a</option>
                        <option value="I b">I b</option>
                        <option value="I c">I c</option>
                        <option value="I d">I d</option>
                        <option value="II a">II a</option>
                        <option value="II b">II b</option>
                        <option value="II c">II c</option>
                        <option value="II d">III d</option>
                        <option value="III a">III a</option>
                        <option value="III b">III b</option>
                        <option value="III c">III c</option>
                        <option value="III d">III d</option>
                        <option value="IV a">IV a</option>
                        <option value="IV b">IV b</option>
                        <option value="IV c">IV c</option>
                        <option value="IV d">IV d</option>
                        <option value="IV e">IV e</option>
                    </select>
                    <div class="text-danger">
                        @error('golongan')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary ">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- End of Main Content -->
@endsection