@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<div>
    <h1 class="h3 mb-5 text-gray-800 text-center"><strong>{{ $title ?? __('Laporan Pengeluaran SPPD Kantor') }}</strong></h1>

    <div class="d-flex float-right">
        <a href="{{ route('keuangank.pdf', ['search' => $search]) }}" target="_blank" class="btn btn-primary">Cetak<i class="fas fa-fw fa-print"></i></a>
    </div>
</div>

<div>
    <form action="" method="get" class="d-flex justify-content-start">
        <div class="form-group mb-0 mr-2">
            <input type="text" class="form-control" name="search" id="search_input" placeholder="Masukkan Kategori UP yang dicari" style="width: 600px;">
            
            <div class="text-danger">
                @error('search')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<h5 class="h5 mb-4 mt-4 text-gray-800 text-left"><strong>{{ $title ?? __('Kategori UP') }}</strong></h5>

<div id="popup" style="display: none;">
    <p>Data Tidak Ditemukan</p>
</div>

<script>
    // Ambil nilai dari variabel search dari Blade
    var search = "{{ $search }}";

    // Periksa apakah hasil pencarian kosong, jika iya, tampilkan popup
    if (search !== '' && {{ count($items) }} === 0) {
        document.getElementById('popup').style.display = 'block';
    }
</script>

    <!-- Display cumulative data table -->
    <table id="table" class="table mb-4 px-4 table-bordered table-stripped">
        <thead>
            <tr align="center">
                {{-- <th>Tanggal Masuk</th> --}}
                <th>Kategori UP</th>
                {{-- <th>Uang Masuk</th>
                <th>Total Masuk</th> --}}
                <th>Total Pengeluaran Kantor</th>
                {{-- <th>Total Pengeluaran Gabungan(Pusat dan Kantor)</th>
                <th>Total Sisa</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $cumulativeSum = 0;
            @endphp
            @foreach ($uangup as $up)
            @if ($search == "" || empty($search) || strtolower($up->kategori_up) == strtolower($search))
                <tr align="center">
                    {{-- <td>{{ $up->tanggal }}</td> --}}
                    <td>{{ $up->kategori_up }}</td>
                    {{-- <td>Rp. {{ number_format($up->jumlahup, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($up->totalMasuk, 0, ',', '.') }}</td> --}}
                    <td>Rp. {{ isset($totalPengeluaranKantor[$up->kategori_up]) ? number_format($totalPengeluaranKantor[$up->kategori_up], 0, ',', '.') : 0 }}</td>
                    {{-- <td>Rp. {{ number_format($up->pengeluaran, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($up->sisa, 0, ',', '.') }}</td> --}}
                </tr>
            @endif
        @endforeach
        
        </tbody>
    </table>
    
    <div class="d-flex align-items-center mb-4">
        <h5 class="h5 mr-3 text-gray-800"><strong>{{ $title ?? __('Rincian Pengeluaran Dana') }}</strong></h5> 
    </div>

    <div id="popupp" style="display: none;">
        <p>Data Tidak Ditemukan</p>
    </div>
    
    <script>
        // Ambil nilai dari variabel search dari Blade
        var search = "{{ $search }}";
    
        // Periksa apakah hasil pencarian kosong, jika iya, tampilkan popup
        if (search !== '' && {{ count($items) }} === 0) {
            document.getElementById('popupp').style.display = 'block';
        }
    </script>
    <table id="table" class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori UP</th>
                <th>Judul Surat</th>
                <th>Tanggal Pergi</th>
                <th>Tanggal Pulang</th>
                <th>Lokasi</th>
                <th>Karyawan</th>
                <th>Pengeluaran</th>
                <th>Lampiran Surat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            @if($item->status_keuangan =='Terima')
            @if ($search == "" || empty($search) || strtolower($item->kategori_up) == strtolower($search))
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $item->kategori_up }}</td>
                <td>{{ $item->judul_surat}}</td>
                <td>{{ $item->tanggal_pergi}}</td>
                <td>{{ $item->tanggal_pulang}}</td>
                <td>{{ $item->nama_kota}}</td>
                <td>
                    @foreach($item->karyawan as $detailkantor)
                    <p>{{$detailkantor->nama}}</p>
                    @endforeach
                </td>
                <td>Rp. {{ number_format($item->subjumlah, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ asset('lampiran_surat/'. $item->lampiran_surat )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_surat}} </a>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="/keuangank/show2/{{ $item->id }}" class="btn btn-info mr-2">Detail</a>
                    </div>
                </td>
            </tr>
            @elseif ($item->status_keuangan =='Pending')
            <tr>
            </tr>
            @endif
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