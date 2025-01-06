<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran Pusat</title>
    <style>
        @page {
			size: 8.3in 11.7in;
		}

		table {
			border-style: double;
			border-width: 1px;
			border-color: white;
		}

		table tr .text2 {
			text-align: center;
			font-size: 14px;
		}

		th {
			color:#1c7bbf;
			font-size: smaller;
		}

		table tr .text {
			text-align: justify;
			font-size: 14px;
		}

		table tr td {
			font-size: 12px;
		}

        th {
			font-size: 11px;
		}

		#border {
			border: 1px solid;
			margin-left: 1%;


		}

		h3 {
			text-align: center;
		}

		#garis {
			border-top: 1px solid;
			border-bottom: 1px solid;
			text-align: right;
		}

		#marginkiri {
			margin-left: 5%;
		}

		#marginbawah {
			margin-bottom: 3%;
			margin-left: 5%;
		}

		#marginbawah2 {
			margin-bottom: 8%;
			margin-left: 5%;
		}

		#marginbawah3 {
			margin-bottom: 6%;
			margin-left: 5%;
		}

		#borderbaru {
			border-bottom: 1px solid;
			border-right: 1px solid;
			border-left: 1px solid;
			margin-bottom: 3%;
			margin-left: 5%;
		}

		#paddingbawah {
			padding-bottom: 7%;
		}

		#kapital2 {
			text-transform: capitalize;
		}

		#jarak {
			line-height: 25%;
		}

		#jarakbaris {
			line-height: 125%;
		}

		#borderbawah {
			border-bottom: 2px solid;
			margin-bottom: 1%;

		}

		#ratakanan {
			text-align: right;
		}
    </style>
</head>
<body>
    <div>
		<table width="100%">
			<td width=16%><img src="{{('img/tut.jpg') }}" height="8%"></td>
			<td>
				<justify id="jarak">
					<h4 style="color:#1c7bbf;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h4>
					<h4 style="color:#1c7bbf;">LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH X </h4>
					<h4 style="color:#1c7bbf;">(SUMBAR, RIAU, JAMBI DAN KEP. RIAU)</h4>
				</justify>
			</td>
		</table>
	</div>

    
    <div style="text-align: left; font-size: 12px;">
		<h3>Laporan Pengeluaran Dana SPPD Pusat Kategori {{ $search ? $search : 'Semua' }}</h3>
    </div>
    <div id=border>
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Kategori UP</th>
                <th>Judul Surat</th>
                <th>Lokasi</th>
                <th>Karyawan</th>
                <th>Tanggal Pergi</th>
                <th>Tanggal Pulang</th>
                <th>Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kategori_up }}</td>
                <td>{{ $item->judul_surat }}</td>
                <td>{{ $item->nama_kota }}</td>
                <td>
                    @foreach ($item->karyawan as $karyawan)
                        {{ $karyawan->nama }}
                    @endforeach
                </td>
                <td>{{ $item->tanggal_pergi }}</td>
                <td>{{ $item->tanggal_pulang }}</td>
                <td>Rp. {{ number_format($item->subjumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

 <!-- Bagian total pengeluaran kantor -->
 <div style="text-align: left; font-size: 12px; margin-top: 20px;">
	<hr>
	<strong>Total Pengeluaran SPPD Pusat Kategori {{ $search ? $search : 'Semua' }} </strong>
	@php
		$totalPengeluaranPusat = 0;
		foreach ($items as $item) {
			$totalPengeluaranPusat += $item->subjumlah;
		}
	@endphp
	: Rp. {{ number_format($totalPengeluaranPusat, 0, ',', '.') }}
</div>
</body>
</html>
