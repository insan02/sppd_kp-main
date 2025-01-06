@extends('layout.v_template')


@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Edit Uang Fullboard') }}</h1>

<!-- Main Content goes here -->
<form action="/fullboard/update/{{ $fullboard->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Jumlah</label>
                    <input name="jumlah" class="form-control" value="{{ $fullboard->jumlah }}">
                    <div class="text-danger">
                        @error('jumlah')
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