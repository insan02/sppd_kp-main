@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Data Surat Undangan dari Pusat') }}</h1>

<table id="table" class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>No Surat</th>
            <th>Judul Surat</th>
            <th>Lokasi</th>
            <th>Karyawan</th>
            <th>Tanggal Pergi</th>
            <th>Tanggal Pulang</th>
            <th>Lampiran Surat</th>
            <th>Surat Tugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->no_surat}}</td>
            <td>{{ $item->judul_surat}}</td>
            <td>{{ $item->nama_kota}}</td>
            <td>
                @foreach($item->karyawan as $detaildisposisi)
                <p>{{$detaildisposisi->nama}}</p>
                @endforeach
            </td>
            <td>{{ $item->tanggal_pergi}}</td>
            <td>{{ $item->tanggal_pulang}}</td>
            <td>
                <a href="{{ asset('lampiran_undangan/'. $item->lampiran_undangan )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_undangan}} </a>
            </td>
            <td>
                <div class="d-flex">
                    <a href="/surat_tugasp/cetak/{{ $item->id }}" class="btn btn-sm btn-primary mr-2">Cetak</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('js')
<script src="httitem://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
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