@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Data Surat Undangan dari Pusat yang Diterima') }}</h1>

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

<table id="table" class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>Lokasi</th>
            <th>Nomor Surat</th>
            <th>Judul Surat</th>
            <th>Tanggal Pergi</th>
            <th>Tanggal Pulang</th>
            <th>Lampiran Surat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pusat as $ps)
        @if($ps->status_disposisi =='Terima')
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $ps->nama_kota}}</td>
            <td>{{ $ps->no_surat}}</td>
            <td>{{ $ps->judul_surat}}</td>
            <td>{{ $ps->tanggal_pergi}}</td>
            <td>{{ $ps->tanggal_pulang}}</td>
            <td>
                <a href="{{ asset('lampiran_undangan/'. $ps->lampiran_undangan )}}" target="_blank" rel="noopener noreferrer"> {{$ps->lampiran_undangan}} </a>
            </td>
            <td>
                <div class="d-flex">

                    <a href="/pusat/detail/{{ $ps->id }}" class="btn  btn-primary mr-2">Detail</a>
                </div>
            </td>
        </tr>
        @elseif ($ps->status_disposisi =='Pending')
        <tr>
        </tr>
        @endif
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