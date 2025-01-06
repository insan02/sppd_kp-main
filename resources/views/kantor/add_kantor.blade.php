@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah Surat') }}</h1>

<!-- Main Content goes here -->
<form action="/kantor/insert" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Lokasi</label>
                    <select name="lokasi_id" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($lokasi as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kota }}</option>
                        @endforeach
                    </select>
                </div>
                <label>Karyawan</label>
                <div class="input-group mb-3">
                    <!-- <label>Karyawan</label> -->
                    <select name="karyawan_id[]" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($karyawan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary add_karyawan" type="button" id="button-addon2">Add</button>
                </div>
                <div id="extra-karyawan"></div>
                <div class="form-group">
                    <label>Judul Surat</label>
                    <input name='judul_surat' class="form-control" value="{{ old('judul_surat') }}">
                    <div class="text-danger">
                        @error('judul_surat')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Pergi</label>
                    <div> </div>
                    <input type='date' name='tanggal_pergi' class="form-control" value="{{ old('tanggal_pergi') }}">
                    <div class="text-danger">
                        @error('tanggal_pergi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Pulang</label>
                    <div> </div>
                    <input type='date' name='tanggal_pulang' class="form-control" value="{{ old('tanggal_pulang') }}">
                    <div class="text-danger">
                        @error('tanggal_pulang')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Lampiran Surat (maksimal 500 kb)</label>
                    <div> </div>
                    <input type='file' name='lampiran_surat' class="form-control" value="{{ old('lampiran_surat') }}">
                    <div class="text-danger">
                        @error('lampiran_surat')
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