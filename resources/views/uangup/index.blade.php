@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<div style="position: relative;">
    <h1 class="h3 mb-4 text-gray-800 text-center font-weight-bold">{{ $title ?? __('Data UP') }}</h1>
    {{-- <div style="position: absolute; top: 0; right: 0;">
        <button class="btn btn-success mb-3" onclick="printTable()">Cetak <i class="fas fa-fw fa-print"></i></button>
    </div> --}}
</div>


<div class="row">
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Keseluruhan Uang Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalJumlahUp)</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Keseluruhan Pengeluaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalPengeluaran)</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Keseluruhan Sisa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalSisa)</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <a href="/uangup/add" class="btn btn-primary mb-3 mr-2">Tambah UP</a>
</div>

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if ($errors->has('file'))
<span class="invalid-feedback" role="alert">
    <strong>{{ $errors->first('file') }}</strong>
</span>
@endif

@if ($sukses = Session::get('sukses'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>{{ $sukses }}</strong>
</div>
@endif

<table id="table" class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Masuk</th>
            <th>Kategori UP</th>
            <th>Uang Masuk</th>
            <th>Total Masuk</th>
            <th>Total Pengeluaran</th>
            <th>Total Sisa</th>
        </tr>
    </thead>
    <tbody>
        @php
            $cumulativeSum = 0;
        @endphp
        @foreach ($uangup as $up)
        @php
        // Periksa apakah data saat ini merupakan data terakhir yang total masuknya sama dengan sisa
        $isLastData = ($lastUangup && $up->id === $lastUangup->id);
    @endphp
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $up->tanggal }}</td>
            <td>{{ $up->kategori_up }}</td>
            <td>@currency($up->jumlahup)</td>
            <td>@currency($up->totalMasuk)</td>
            <td>@currency($up->pengeluaran)</td>
            <td>@currency($up->sisa)</td>
            <td>
                @if ($isLastData)
                    <div class="d-flex">
                        <a href="/uangup/edit/{{ $up->id }}" class="btn btn-warning mr-2 btn-sm">Edit  <i class="fas fa-edit"></i></a>
                        <a href="{{ Route('uangup.destroy', [$up->id]) }}" display="inline" class="btn btn-danger btn-sm show_confirm" onclick="return confirm('Yakin ingin menghapus?');">Hapus  <i class="fas fa-trash"></i></a>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach
    
    
    
    </tbody>
</table>

@endsection
<script>
    function resetData() {
        if (confirm("Apakah Anda yakin ingin menghapus semua data UP?")) {
            location.href = "{{ route('uangup.reset') }}";
        }
    }
</script>

{{-- Cetak dokumen --}}
{{-- <script>
    function printTable() {
    // Buat salinan tabel
    var tableClone = document.getElementById('table').cloneNode(true);

    // Tambahkan gaya CSS untuk garis tepi tabel
    var tableStyle = '<style>table { border-collapse: collapse; width: 100%; } table, th, td { border: 1px solid black; } th, td { padding: 8px; text-align: left; }</style>';

    // Buat dokumen baru untuk mencetak
    var newWindow = window.open('', '_blank');
    newWindow.document.write('<html><head><title>Data UP</title>');
    newWindow.document.write(tableStyle); // Tambahkan gaya CSS
    newWindow.document.write('<style>@media print { @page { margin: 0; size: auto; } body { margin: 1.6cm; }}</style>');
    newWindow.document.write('</head><body>');

   // Tambahkan bagian di atas judul
var headerHTML = '<div style="text-align: center;">' +
    '<table width="100%">' +
    '<tr>' +
    '<td style="text-align: center;">' +
    '<div id="jarak">' +
    '<h4 style="color:#1c7bbf;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h4>' +
    '<h4 style="color:#1c7bbf;">LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH X </h4>' +
    '<h4 style="color:#1c7bbf;">(SUMBAR, RIAU, JAMBI DAN KEP. RIAU)</h4>' +
    '</div>' +
    '</td>' +
    '</tr>' +
    '</table>' +
    '</div>';


    newWindow.document.write(headerHTML);

    // Tambahkan judul
    newWindow.document.write('<h3 class="h3 mb-4 text-gray-200 font-weight-bold" style="text-align: center;">Rincian Data UP</h3>');


    // Tambahkan blok HTML
    var additionalHTML = '<div class="row">' +
        '<div class="col-xl-4 col-md-4 mb-4">' +
        '<div class="card border-left-success shadow h-100 py-2">' +
        '<div class="card-body">' +
        '<div class="row no-gutters align-items-center">' +
        '<div class="col">' +
        '<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Keseluruhan Uang Masuk</div>' +
        '</div>' +
        '<div class="col-auto">' +
        '<div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalJumlahUp)</div><br>' + // Tambahkan tag <br> di sini
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-xl-4 col-md-4 mb-4">' +
        '<div class="card border-left-success shadow h-100 py-2">' +
        '<div class="card-body">' +
        '<div class="row no-gutters align-items-center">' +
        '<div class="col">' +
        '<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Keseluruhan Pengeluaran</div>' +
        '</div>' +
        '<div class="col-auto">' +
        '<div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalPengeluaran)</div><br>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-xl-4 col-md-4 mb-4">' +
        '<div class="card border-left-info shadow h-100 py-2">' +
        '<div class="card-body">' +
        '<div class="row no-gutters align-items-center">' +
        '<div class="col">' +
        '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Keseluruhan Sisa</div>' +
        '</div>' +
        '<div class="col-auto">' +
        '<div class="h5 mb-0 font-weight-bold text-gray-800">@currency($totalSisa)</div><br>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    newWindow.document.write(additionalHTML);

    // Buat tabel baru dengan hanya kolom No sampai Total Sisa
    var newTable = '<table><thead>';
    var headings = document.querySelectorAll('#table thead th');
    newTable += '<tr>';
    for (var i = 0; i < headings.length; i++) {
        if (i !== headings.length - 1 || headings[i].textContent.trim() === 'Total Sisa') { // Hanya sampai sebelum kolom "Edit" dan "Hapus", atau jika ini adalah kolom "Total Sisa"
            newTable += '<th>' + headings[i].textContent + '</th>';
        }
    }
    newTable += '</tr></thead><tbody>';

    var rows = document.querySelectorAll('#table tbody tr');
    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        newTable += '<tr>';
        for (var j = 0; j < cells.length; j++) {
            if (j !== cells.length - 1) { // Hanya sampai sebelum kolom "Edit" dan "Hapus"
                newTable += '<td>' + cells[j].innerHTML + '</td>';
            }
        }
        newTable += '</tr>';
    });

    newTable += '</tbody></table>';

    // Tambahkan tabel ke dokumen baru
    newWindow.document.write(newTable);

    newWindow.document.write('</body></html>');

    // Cetak dokumen baru
    newWindow.document.close();
    newWindow.print();
}
</script> --}}














