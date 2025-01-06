@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Tambah Karyawan') }}</h1>

<!-- Main Content goes here -->
<form action="/tanggapan/store" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <input type="hidden" value="{{$it->id}}" name="pusat_id">
                <label>Karyawan</label>
                <div class="input-group mb-3">
                    <select name="karyawan_id[]" class="form-control">
                        <option value="">- Pilih Karyawan-</option>
                        @foreach ($karyawan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary add_karyawan" type="button" id="button-addon2">Add</button>
                </div>
                <div id="extra-karyawan"></div>
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