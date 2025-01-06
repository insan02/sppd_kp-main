@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Data Transportasi') }}</h1>

<a href="/transportasi/add" class="btn btn-primary mb-3">Tambah Transportasi</a>

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

<table id="table" class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Transportasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transportasi as $trns)
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $trns->jenis_transportasi}}</td>
            <td>
                <div class="d-flex">
                    <a href="/transportasi/edit/{{ $trns->id }}" class="btn btn-info mr-2 btn-sm">Edit</a>
                    <a href="{{Route('transportasi.destroy',[$trns->id])}}" display="inline" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
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