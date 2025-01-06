@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Menambahkan Data Keuangan') }}</h1>

<table class="table table-bordered table-stripped">
    <tr>
        <td style="font-weight: bold">Judul Surat</td>
        <td>{{$item->judul_surat}}</td>
        <td style="font-weight: bold">Lokasi</td>
        <td>{{$item->nama_kota}}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Tanggal Pergi</td>
        <td>{{$item->tanggal_pergi}}</td>
        <td style="font-weight: bold">Tanggal Pulang</td>
        <td>{{$item->tanggal_pulang}}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Nama Karyawan</td>
        <td>
            @foreach($item->karyawan as $detailkantor)
            <p>{{$detailkantor->nama}}</p>
            @endforeach
        </td>
        <td style="font-weight: bold">Lampiran Surat</td>
        <td>
            <a href="{{ asset('lampiran_surat/'. $item->lampiran_surat )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_surat}} </a>
        </td>
    </tr>
</table>

<div class="flex justify-center my-4">
    <a href="/keuangank/add/{{ $item->id }}" class="btn btn-primary btn-center">Tambah Data Keuangan</a>
</div>

@endsection