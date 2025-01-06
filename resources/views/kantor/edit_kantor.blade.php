@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Data Surat Kantor') }}</h1>

<!-- Main Content goes here -->
<form action="/kantor/update/{{ $kantor->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Lokasi</label>
                    <select name="lokasi_id" class="form-control @error('lokasi_id') is-invalid @enderror">
                        <option value="">- Pilih -</option>
                        @foreach($lokasi as $item)
                        <option value="{{ $item->id }}" {{ old('lokasi_id', $kantor->lokasi_id) == $item->id ? 'selected' : null }}>{{ $item->nama_kota}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('lokasi_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label>Karyawan</label>
                @foreach ($karyawan_kantor as $kar)
                <div class="input-group mb-3">
                    <select name="kantor_id[]" class="form-control" >
                        <option value="">- Pilih -</option>
                        @foreach ($karyawan as $item)
                        <option value="{{ $item->id }}" {{ old('karyawan_id[]', $kar->karyawan_id) == $item->id ? 'selected' : null }}>{{ $item->nama}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('kantor_id[]')
                        {{ $message }}
                        @enderror
                    </div>
                    
                    <button class="btn btn-outline-secondary add_karyawan" type="button" id="button-addon2">Add</button>
                </div>
                @endforeach
                <div id="extra-karyawan"></div>
                <div class="form-group">
                    <label>Judul Surat</label>
                    <input name="judul_surat" class="form-control" value="{{ $kantor->judul_surat }}">
                    <div class="text-danger">
                        @error('judul_surat')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Pergi</label>
                    <input type='date' name="tanggal_pergi" class="form-control" value="{{ $kantor->tanggal_pergi }}">
                    <div class="text-danger">
                        @error('tanggal_pergi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Pulang</label>
                    <input type='date' name="tanggal_pulang" class="form-control" value="{{ $kantor->tanggal_pulang }}">
                    <div class="text-danger">
                        @error('tanggal_pulang')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Lampiran Surat</label>
                    <input type='file' name="lampiran_surat" class="form-control" value="{{ $kantor->lampiran_surat }}">
                    <div>
                        <a href="{{ asset('lampiran_surat/'. $kantor->lampiran_surat )}}" target="_blank" rel="noopener noreferrer"> {{$kantor->lampiran_surat}} </a>
                    </div>
                    <div class="text-danger">
                        @error('lampiran_surat')
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
@push('js')
<script>
    const add = document.querySelectorAll(".input-group .add_karyawan")
    add.forEach(function(e) {
        e.addEventListener('click', function() {
            let element = this.parentElement
            console.log(element);
            let newElement = document.createElement('div')
            newElement.classList.add('input-group', 'mb-3')
            newElement.innerHTML = `<select name="karyawan_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($karyawan as $item)<option value="{{ $item->id }}" >{{ $item->nama }}</option>@endforeach</select> <button class="btn btn-outline-danger remove_karyawan" type="button" id="button-addon2">Remove</button>`
            document.getElementById('extra-karyawan').appendChild(newElement)

            document.querySelectorAll('.remove_karyawan').forEach(function(remove) {
                remove.addEventListener('click', function(elmClick) {
                    elmClick.target.parentElement.remove()
                })
            })
        })
    })
</script>
@endpush