@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit keuangan') }}</h1>

<!-- Main Content goes here -->
<form action="/keuangan/update/{{ $keuangan->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Transport</label>
                        @foreach ($keuangan_tp as $tpp)
                        <div class="input-group mb-3 mt-3">
                            <select name="transport_id" class="form-control @error('transport_id') is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                @foreach ($transportasi as $item)
                                <option value="{{ $item->id }}" {{ old('transport_id', $tpp->transport_id) == $item->id ? 'selected' : null }}>{{ $item->jenis_transportasi }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @error('transport_id')
                                {{ $message }}
                                @enderror
                            </div>
                            <input name="uang_transport" class="form-control ml-2" value="{{ $tpp->uang }}" type="number">
                            <button class="btn btn-outline-secondary ml-3 add_transportasi" type="button" id="button-addon2">Add</button>
                        </div>
                        @endforeach
                    <div id="extra-transportasi"></div>
                </div>
                <div class="form-group">
                    <label>Penginapan</label>
                        @foreach ($keuangan_pn as $pnn)
                        <div class="input-group mb-3">
                            <select name="penginapan_id" class="form-control">
                                <option value="">- Pilih -</option>
                                @foreach ($pn as $item)
                                <option value="{{ $item->id }}" {{ old('penginapan_id', $pnn->pn_id) == $item->id ? 'selected' : null }}>{{ $item->nama_penginapan }}</option>
                                @endforeach
                            </select>
                            <input name="uang_penginapan" class="form-control ml-2" value="{{ $pnn->uang }}" type="number">
                            <button class="btn btn-outline-secondary ml-3 add_penginapan" type="button" id="button-addon3">Add</button>
                        </div>
                        @endforeach
                    <div id="extra-penginapan"></div>
                </div>
                <div class="form-group">
                    <label>Tipe Lumpsum</label>
                    <select name="tipe_penginapan_id" class="form-control @error('tipe_penginapan_id') is-invalid @enderror">
                        <option value="">- Pilih -</option>
                        @foreach($tipeLump as $item)
                        <option value="{{ $item->id }}" {{ old('tipe_penginapan_id', $keuangan->tipe_penginapan_id) == $item->id ? 'selected' : null }}>{{ $item->tipe_lumpsum}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('tipe_penginapan_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input name="keterangan" class="form-control" value="{{ $keuangan->keterangan }}">
                    <div class="text-danger">
                        @error('keterangan')
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
    const add = document.querySelectorAll(".input-group .add_transportasi")
    add.forEach(function(e) {
        e.addEventListener('click', function() {
            let element = this.parentElement
            console.log(element);
            let newElement = document.createElement('div')
            newElement.classList.add('input-group', 'mb-3')
            newElement.innerHTML = `<select name="transport_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($transportasi as $item)<option value="{{ $item->id }}" >{{ $item->jenis_transportasi }}</option>@endforeach</select> <input name="uang[]" class="form-control ml-2" type="number"> <button class="btn btn-outline-danger ml-3 remove_transportasi" type="button" id="button-addon2">Remove</button>`
            document.getElementById('extra-transportasi').appendChild(newElement)

            document.querySelectorAll('.remove_transportasi').forEach(function(remove) {
                remove.addEventListener('click', function(elmClick) {
                    elmClick.target.parentElement.remove()
                })
            })
        })
    })
</script>
<script>
    const add2 = document.querySelectorAll(".input-group .add_penginapan")
    add2.forEach(function(e) {
        e.addEventListener('click', function() {
            let element = this.parentElement
            console.log(element);
            let newElement = document.createElement('div')
            newElement.classList.add('input-group', 'mb-3')
            newElement.innerHTML = `<select name="penginapan_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($pn as $item)<option value="{{ $item->id }}" >{{ $item->nama_penginapan }}</option>@endforeach</select> <input name="uang1[]" class="form-control ml-2" type="number"> <button class="btn btn-outline-danger ml-3 remove_penginapan" type="button" id="button-addon3">Remove</button>`
            document.getElementById('extra-penginapan').appendChild(newElement)

            document.querySelectorAll('.remove_penginapan').forEach(function(remove) {
                remove.addEventListener('click', function(elmClick) {
                    elmClick.target.parentElement.remove()
                })
            })
        })
    })
</script>
@endpush