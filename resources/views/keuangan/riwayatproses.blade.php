@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<div>
    <h1 class="h3 mb-5 text-gray-800 text-center"><strong>{{ $title ?? __('Laporan Pengeluaran SPPD Pusat') }}</strong></h1>

    <div class="d-flex float-right">
        <a href="{{ route('keuangan.pdf', ['search' => $search]) }}" target="_blank" class="btn btn-primary">Cetak <i class="fas fa-fw fa-print"></i></a>
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


<!-- Tambahkan jarak atas untuk judul "Rincian UP" -->
<h5 class="h5 mb-4 mt-4 text-gray-800 text-left"><strong>{{ $title ?? __('Rincian UP') }}</strong></h5>

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
            <th>Total Pengeluaran Pusat</th>
            {{-- <th>Total Pengeluaran Gabungan(Pusat dan Kantor)</th>
            <th>Total Sisa</th> --}}
        </tr>
    </thead>
    <tbody>
        @php
            $cumulativeSum = 0;
        @endphp
        @foreach ($uangup as $up)
        @if ($search == "" || empty($search) || strtolower($up->kategori_up) == strtolower($search)) <!-- Ubah perbandingan agar hanya hasil yang sesuai yang ditampilkan -->
        <tr align="center">
            <td>{{ $up->tanggal }}</td>
            <td>{{ $up->kategori_up }}</td>
            {{-- <td>Rp. {{ number_format($up->jumlahup, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($up->totalMasuk, 0, ',', '.') }}</td> --}}
            <td>Rp. {{ isset($totalPengeluaranPusat[$up->kategori_up]) ? number_format($totalPengeluaranPusat[$up->kategori_up], 0, ',', '.') : 0 }}</td>
            {{-- <td>Rp. {{ number_format($up->pengeluaran, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($up->sisa, 0, ',', '.') }}</td>
        </tr> --}}
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
        <tr align="center">
            <th>No</th>
            <th>Kategori UP</th>
            <th>No Surat</th>
            <th>Judul Surat</th>
            <th>Lokasi</th>
            <th>Karyawan</th>
            <th>Tanggal Pergi</th>
            <th>Tanggal Pulang</th>
            <th>Pengeluaran</th>
            <th>Lampiran Surat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        @if($item->status_keuangan =='Terima')
        @if ($search == "" || empty($search) || strtolower($item->kategori_up) == strtolower($search)) <!-- Ubah perbandingan agar hanya hasil yang sesuai yang ditampilkan -->
        <tr align="center">
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->kategori_up}}</td>
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
            <td>Rp. {{ number_format($item->subjumlah, 0, ',', '.') }}</td>
            <td>
                <a href="{{ asset('lampiran_undangan/'. $item->lampiran_undangan )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_undangan}} </a>
            </td>
            <td>
                <div class="d-flex">
                    <a href="/keuangan/show2/{{ $item->id }}" class="btn  btn-info mr-2">Detail</a>
                </div>
            </td>
        </tr>
        @endif
        @endif <!-- Penutup dari kondisi jika status keuangan 'Terima' -->
        @endforeach
    </tbody>
</table>


@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('keuangan').DataTable({
            // ... (Konfigurasi DataTables yang mungkin sudah ada)

            // Menambahkan fitur pencarian berdasarkan kategori UP
            initComplete: function () {
                this.api().columns(1).every(function () {
                    var column = this;
                    var input = $('<input type="text" placeholder="Cari Kategori UP" />')
                        .appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                });
            }
        });
    });
</script>
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
