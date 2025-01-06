<!DOCTYPE html>
<html>
@foreach ($itemssss as $item1)
@foreach($itemss1 as $item)

<head>
	<title>Surat Perintah Perjalanan Dinas </title>
	<style type="text/css">
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
			font-size: smaller;
		}

		table tr .text {
			text-align: justify;
			font-size: 14px;
		}

		table tr td {
			font-size: 14px;
		}

		#border {
			border: 1px solid;
			margin-left: 5%;


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
	<div>
		<hr>
		<h3>RINCIAN BIAYA PERJALANAN DINAS</h3>
	</div>
	<div>
		<table id=marginkiri>
			<tr class="text2">
				<td>Lampiran SPPD Nomor</td>
				<td>:</td>
				<td></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
			</tr>
		</table>
	</div>
	<div id=border>
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<th>No</th>
				<th>PERINCIAN BIAYA</th>
				<th>JUMLAH</th>
				<th>KETERANGAN</th>
			</tr>
			<tbody>
				<tr>
					<td scope="row">1</td>
					<td><b>{{ $item1->nama }}</b>
						<br><br> - Uang harian Diklat
						@php
						$hari1 = $item->tanggal_pergi;
						$hari2 = $item->tanggal_pulang;

						$differences = strtotime($hari2) - strtotime($hari1);
						$hari = $differences / (24 * 60 * 60);
						@endphp
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{ $hari  }} Hari
						<br>- Uang Transportasi <br>- Uang Penginapan
					<td>
						<br><br> <?php
									$fullBoard = $item->jumlah;
									if ($item->tipe_penginapan_id == 1) {
										$besaranlm = ((($hari - 2) * $fullBoard) + (2 * $item->besaran_lumpsum));
									} else {
										$besaranlm = $hari  * $item->besaran_lumpsum;
									}
									echo 'Rp. ' . number_format($besaranlm,  0, ",", ".");
									?>
						<br> <?php
								$transport = $item->uang_transport;
								$besarantr = (2 * $transport);
								$item->uang_transport = 0;
								?>
						@foreach($item->utp as $detail_tp)
						@php
						$item->uang_transport += $detail_tp->uang;
						@endphp
						@endforeach
						@php
						$tr = $item->uang_transport;
						echo 'Rp. '.number_format($tr, 0, ",", ".");
						@endphp
						<br>
						<?php
						$item->uang_penginapan = 0;
						?>
						@foreach($item->upn as $detail_pn)
						@php
						$item->uang_penginapan += $detail_pn->uang;
						@endphp
						@endforeach
						@php
						$uangpnn = $item->uang_penginapan * ($hari);
						echo 'Rp. '.number_format($uangpnn, 0, ",", ".");
						@endphp
					<td>{{ $item->keterangan }}</td>
				</tr>
				<tr>
					<th colspan="2">Jumlah</th>
					<td>&nbsp; <?php
								$jumlah = ($tr + $uangpnn + $besaranlm);
								echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
								?>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id=borderbaru>
		<table border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td id=kapital2 colspan="2">Terbilang : &nbsp; <?php
																$jumlah = ($tr + $uangpnn + $besaranlm);

																?>{{Riskihajar\Terbilang\Facades\Terbilang::make($jumlah)}} Rupiah

				</td>
			</tr>

		</table>
	</div>
	<div>
		<table width="100%" cellpadding="2" cellspacing="0" id=marginbawah>
			<tr>
				<td width="60%"></td>
				<td>
					Padang, {{$today}}
				</td>
			</tr>
			<tr>
				<td width="60%">
					<font size=14px>Telah dibayar sejumlah </font>
				</td>
				<td>
					<font size=14px>Telah menerima jumlah uang sebesar</font>
				</td>
			</tr>
			<tr>
				<td width="60%"><b> <?php
									$jumlah = ($tr + $uangpnn + $besaranlm);
									echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
									?></b></td>
				<td>
					<b> <?php
						$jumlah = ($tr + $uangpnn + $besaranlm);
						echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
						?></b>
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="0" id=marginbawah2>
			<tr>
				<td width="60%">Bendahara Pengeluaran Pembantu</td>
				<td>Yang Menerima</td>

			</tr>
		</table>
		<table width="100%" cellspacing="0" id=marginkiri>
			<tr id=jarakbaris>
				<td width="60%">@foreach($bpp as $bppdata)
					<b><u>{{$bppdata->nama }}</u></b><br>
					NIP {{$bppdata->nip }}
					@endforeach
				</td>
				<td>
					<b><u>{{$item1->nama }}</u></b><br>
					NIP {{$item1->nip }}
				</td>
			</tr>
		</table>
	</div>
	<div>
		<hr>
		<h3>PERHITUNGAN SPPD RAMPUNG</h3>
	</div>
	<div id=marginbawah3>
		<table width="55%">
			<tr>
				<td width="10%">Ditetapkan Jumlah</td>
				<td width="1%">Rp</td>
				<td width="10%" id=ratakanan>
					<?php
					$jumlah = ($tr + $uangpnn + $besaranlm);
					echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
					?>
				</td>
			</tr>
			<tr>
				<td>Yang telah dibayar semula</td>
				<td>Rp</td>
				<td>
					<u></u>
				</td>
			</tr>
			<tr>
				<td>Sisa kurang / lebih</td>
				<td>Rp</td>
				<td id=garis>
					<b> <?php
						$jumlah = ($tr + $uangpnn + $besaranlm);
						echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
						?></b>
				</td>
			</tr>
		</table>
	</div>
	<div>
		<table width="100%" cellpadding="2" cellspacing="0" id=marginbawah2>
			<tr>
				<td width="60%">Menyetujui</td>
				<td>
					<font size=14px>Mengetahui</font>
				</td>
			</tr>
			<tr>
				<td width="60%">
					<font size=14px>Pejabat Pembuat Komitmen</font>
				</td>
				<td>
					<font size=14px>Bendahara Pengeluaran</font>
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="0" id=marginkiri>
			<tr id=jarakbaris>
				<td width="60%">@foreach($ppk as $ppkdata)
					<b><u>{{ $ppkdata->nama }}</u></b><br>
					NIP {{$ppkdata->nip }}
					@endforeach
				</td>
				<td>@foreach($bp as $bpdata)
					<b><u>{{ $bpdata->nama }}</u></b><br>
					NIP {{$bpdata->nip }}
					@endforeach
				</td>
			</tr>
		</table>
	</div>
</body>
@endforeach
@endforeach

</html>