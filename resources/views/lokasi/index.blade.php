@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Data Lokasi') }}</h1>
<div>
    <a href="/lokasi/add" class="btn btn-primary mb-3 mr-2">Tambah Lokasi</a>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#importExcel">Import Excel</button>
</div>


@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

{{-- notifikasi form validasi --}}
@if ($errors->has('file'))
<span class="invalid-feedback" role="alert">
    <strong>{{ $errors->first('file') }}</strong>
</span>
@endif

{{-- notifikasi sukses --}}
@if ($sukses = Session::get('sukses'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>{{ $sukses }}</strong>
</div>
@endif

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="/lokasi/import_excel" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<table id="table" class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>Provinsi</th>
            <th>Nama Kota</th>
            <th>Besaran Lumpsum</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lokasi as $lok)
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $lok->Provinsi}}</td>
            <td>{{ $lok->nama_kota}}</td>
            <td>@currency ($lok->besaran_lumpsum)</td>
            <td>
                <div class="d-flex">
                    <a href="/lokasi/edit/{{ $lok->id }}" class="btn btn-info mr-2 btn-sm">Edit</a>
                    <a href="{{Route('lokasi.destroy',[$lok->id])}}" display="inline" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: "Apakah Anda Yakin?",
                text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
@endpush
@push('notif')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif
@endpush