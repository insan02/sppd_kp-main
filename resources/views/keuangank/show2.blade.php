@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<div>
  <h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Detail Data Keuangan') }}
  </h1>
  <div>
    <table class="table table-bordered table-stripped">
      <tr>
        <td style="font-weight: bold">Kategori Up</td>
        <td>{{ $item->kategori_up}}</td>
        <td style="font-weight: bold">Judul Surat</td>
        <td>{{$item->judul_surat}}</td>
        
      </tr>
      <tr>
        <td style="font-weight: bold">Lokasi</td>
        <td>{{$item->nama_kota}}</td>
        <td style="font-weight: bold">Tanggal Pergi</td>
        <td>{{$item->tanggal_pergi}}</td>
        
      </tr>
      <tr>
        <td style="font-weight: bold">Tanggal Pulang</td>
        <td>{{$item->tanggal_pulang}}</td>
        <td style="font-weight: bold">Nama Karyawan</td>
        <td>
          @foreach($item->karyawan as $detailkantor)
          <p>{{$detailkantor->nama}}</p>
          @endforeach
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold">Lampiran Surat</td>
        <td>
          <a href="{{ asset('lampiran_surat/'. $item->lampiran_surat )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_surat}} </a>
        </td>
      </tr>
    </table>
    <table class="table table-bordered table-stripped">
      <thead>
        <tr>
          <th>No</th>
          <th>Transportasi</th>
          <th>Penginapan</th>
          <th>Lama (Hari)</th>
          <th>Jenis Lumpsum</th>
          <th>Lokasi</th>
          <th>Uang Transport</th>
          <th>Uang Penginapan</th>
          <th>Lumpsum</th>
          <th>Jumlah</th>
          <th>Jumlah Akhir</th>
          <th>Keterangan </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($itemss1 as $ite )
        <tr>
          <td scope="row">{{ $loop->iteration }}</td>
          <?php
          $hari1 = $ite->tanggal_pergi;
          $hari2 = $ite->tanggal_pulang;
          $differences = strtotime($hari2) - strtotime($hari1);
          $hari = $differences / (24 * 60 * 60);
          ?>
          <td>
            @foreach ($transportasi as $tp)
            @foreach($ite->utp as $detail_tp)
            @php
            if($detail_tp->transport_id == $tp->id){
            $jenis = $tp->jenis_transportasi;
            echo "\n";
            echo $jenis;
            echo "<br>";
            }
            @endphp
            @endforeach
            @endforeach
            {{-- {{ $jenis_transport}} --}}
          </td>
          <td>
            @foreach ($pn as $pnn)
            @foreach ($ite->upn as $detail_pn)
            @php
            if($detail_pn->pn_id == $pnn->id){
            $namapn = $pnn->nama_penginapan;
            echo $namapn;
            echo "<br>";
            }
            @endphp
            @endforeach
            @endforeach
          </td>
          <?php
          ?>
          <td>
            {{ $hari }}
          </td>
          <td>{{ $ite->tipe_lumpsum}}</td>
          <td>{{ $ite->nama_kota}}</td>
          <td>

            <?php
            $transport = $ite->uang_transport;
            $besarantr = (2 * $transport);

            ?>
            @foreach($ite->utp as $detail_tp)
            @php
            $ite->uang_transport += $detail_tp->uang;

            @endphp
            @endforeach
            @php
            $tr = $ite->uang_transport;
            echo 'Rp. '.number_format($tr, 0, ",", ".");
            @endphp
          </td>
          <td>
            <?php
            ?>
            @foreach($ite->upn as $detail_pn)
            @php
            $ite->uang_penginapan += $detail_pn->uang;

            @endphp
            @endforeach
            @php
            $uangpnn = $ite->uang_penginapan * ($hari);
            echo 'Rp. '.number_format($uangpnn, 0, ",", ".");
            @endphp
          </td>
          <td>
            <?php
            $fullBoard = $ite->jumlah;
            if ($ite->tipe_penginapan_id == 1) {
              $besaranlm = ((($hari - 2) * $fullBoard) + (2 * $ite->besaran_lumpsum));
            } else {
              $besaranlm = $hari  * $ite->besaran_lumpsum;
            }
            echo 'Rp. ' . number_format($besaranlm,  0, ",", ".");
            ?>
          </td>
          <td>
            <?php
            $jumlah = ($tr + $uangpnn + $besaranlm);
            echo 'Rp. ' . number_format($jumlah,  0, ",", ".");
            ?>
          </td>
          <td>
            @foreach ($jmlh_data as $subjumlah)
            @currency ($subjumlah->total * $jumlah)
            @endforeach
          </td>
          <td>
            {{ $ite->keterangan }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
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
@push('js')
<script>
  const add = document.querySelectorAll(".input-group .add_transportasi")
  add.forEach(function(e) {
    e.addEventListener('click', function() {
      let element = this.parentElement
      console.log(element);
      let newElement = document.createElement('div')
      newElement.classList.add('input-group', 'mb-3')
      newElement.innerHTML = `<select name="transport_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($transportasi as $item)<option value="{{ $item->id }}" >{{ $item->jenis_transportasi }}</option>@endforeach</select> <input name="uang[]" class="form-control ml-2" > <button class="btn btn-outline-danger ml-3 remove_transportasi" type="button" id="button-addon2">Remove</button>`
      document.getElementById('extra-transportasi').appendChild(newElement)

      document.querySelectorAll('.remove_transportasi').forEach(function(remove) {
        remove.addEventListener('click', function(elmClick) {
          elmClick.target.parentElement.remove()
        })
      })
    })
  })
</script>
<script>
  const add2 = document.querySelectorAll(".input-group .add_penginapan")
  add2.forEach(function(e) {
    e.addEventListener('click', function() {
      let element = this.parentElement
      console.log(element);
      let newElement = document.createElement('div')
      newElement.classList.add('input-group', 'mb-3')
      newElement.innerHTML = `<select name="penginapan_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($pn as $item)<option value="{{ $item->id }}" >{{ $item->nama_penginapan }}</option>@endforeach</select> <input name="uang1[]" class="form-control ml-2" > <button class="btn btn-outline-danger ml-3 remove_penginapan" type="button" id="button-addon3">Remove</button>`
      document.getElementById('extra-penginapan').appendChild(newElement)

      document.querySelectorAll('.remove_penginapan').forEach(function(remove) {
        remove.addEventListener('click', function(elmClick) {
          elmClick.target.parentElement.remove()
        })
      })
    })
  })
</script>
@endpush