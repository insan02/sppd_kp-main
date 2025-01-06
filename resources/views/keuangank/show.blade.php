@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<div>
  <h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Menambahkan Data Keuangan') }}
    <div class="d-flex float-right">
      <a href="/keuangank/cetak/{{ $item->id }}" target="_blank" class="btn  btn-primary ">Cetak Surat <i class="fas fa-fw fa-print"></i></a>
    </div>
  </h1>
</div>
<div>
  <table class="table table-bordered table-stripped">
    <tr>
      <td style="font-weight: bold">Kategori Up</td>
      <td>
        @foreach($itemss1 as $ite)
            {{$ite->kategori_up}}
        @endforeach
      </td>
      
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
      <td style="font-weight: bold">Nama Karyawan</td>
      <td> @foreach($item->karyawan as $detaildisposisi)
        <p>{{$detaildisposisi->nama}}</p>
        @endforeach
      </td>

      <td style="font-weight: bold">Tanggal Pulang</td>
      <td>{{$item->tanggal_pulang}}</td>
    </tr>
  </table>
</div>
<div class="flex justify-center my-4">
  <a class="btn btn-primary btn-center" data-toggle="modal" data-target="#exampleModal">Tambah Data Keuangan</a>
</div>

@if (session('message'))
<div class="alert alert-success mb-2">
  {{ session('message') }}
</div>
@endif
<div>
  <table class="table table-bordered table-stripped">
    <thead>
      <tr>
        <th>No</th>
        <th>Transportasi</th>
        <th>Penginapan</th>
        <th>Lama (Hari)</th>
        <th>Jenis Lumpsum</th>
        <th>Lokasi</th>
        <th>Kategori UP</th>
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
          @foreach($ite->upn as $detail_pn)
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
        <td>{{ $ite->kategori_up}}</td>
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
        <td>
          <div class="d-flex">
              <!-- Add a form to submit the subjumlah to the controller -->
              <form action="{{ route('keuangank.saveSubjumlah', ['itemId' => $ite->id, 'subjumlah' => $subjumlah->total * $jumlah]) }}" method="post" id="cekForm">
                  @csrf
                  <button type="submit" class="btn btn-primary mr-1 btn-sm" id="cekButton" @if(session('cekButtonHidden_' . $ite->id)) style="display:none;" @endif>Cek</button>
              </form>
              <a href="/keuangank/edit/{{ $ite->id }}" id="editButton_{{ $ite->id }}" class="btn btn-info mr-1 btn-sm" @if(session('editHapusButtonHidden_' . $ite->id)) style="display:none;" @endif>Edit</a>
              <a href="{{Route('keuangank.destroy',[$ite->id])}}" id="hapusButton_{{ $ite->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');" @if(session('editHapusButtonHidden_' . $ite->id)) style="display:none;" @endif>Hapus</a>              
          </div>
      </td>
      
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
    <div>
      <form action="/keuangank/updatestatus/{{ $item->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group d-flex float-right">
          <button class="btn  btn-primary ml-45" onclick="return confirm('Yakin ingin mengarsipkan data?');">Arsipkan</button>
        </div>
      </form>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Keuangan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/keuangank/store" method="POST">
              @csrf
              <input type="hidden" value="{{$item->id}}" name="kantor_id">
              <div class="form-group">
                <label>Transport</label>
                <div class="input-group mb-3">
                  <select name="transport_id[]" class="form-control">
                    <option value="">- Pilih -</option>
                    @foreach ($transportasi as $item)
                    <option value="{{ $item->id }}">{{ $item->jenis_transportasi }}</option>
                    @endforeach
                  </select>
                  <input name="uang[]" class="form-control ml-2" type="number">
                  <button class="btn btn-outline-secondary ml-3 add_transportasi" type="button" id="button-addon2">Add</button>
                </div>
                <div id="extra-transportasi"></div>
              </div>
              <div class="form-group">
                <label>Penginapan</label>
                <div class="input-group mb-3">
                  <select name="penginapan_id[]" class="form-control">
                    <option value="">- Pilih -</option>
                    @foreach ($pn as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_penginapan }}</option>
                    @endforeach
                  </select>
                  <input name="uang1[]" class="form-control ml-2" type="number">
                  <button class="btn btn-outline-secondary ml-3 add_penginapan" type="button" id="button-addon3">Add</button>
                </div>
                <div id="extra-penginapan"></div>
              </div>
              <div class="form-group">
                <label for="reff_tipe_lumpsum">Tipe Lumpsum</label>
                <select class="form-control @error('type') is-invalid @enderror" name="tipe_penginapan_id" id="tipe_penginapan_id" autocomplete="off" value="{{ old('tipe_penginapan_id') }}">
                  @foreach ($tipeLump as $lump)
                  <option value="{{$lump->id}}">{{$lump->tipe_lumpsum}}</option>
                  @endforeach
                </select>
                @error('nama_kota')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <select class="form-control @error('type') is-invalid @enderror" name="id_lokasi" id="id_lokasi" autocomplete="off" value="{{ old('id_lokasi') }}">
                  @foreach ($lokasii as $lok)
                  <option value="{{$lok->id}}">{{$lok->nama_kota}}</option>
                  @endforeach
                </select>
                @error('nama_kota')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="kategori_up">Kategori UP</label>
                <select class="form-control" name="kategori_up" id="kategori_up">
                    @if($uangup->isNotEmpty())
                        <option value="{{ $uangup->last()->id }}">{{ $uangup->last()->kategori_up }}</option>
                    @endif
                </select>
                <div class="text-danger">
                    @error('kategori_up')
                        {{ $message }}
                    @enderror
                </div>
            </div>
              <div class="form-group">
                <label>Keterangan</label>
                <input name="keterangan" class="form-control" value="{{ old('keterangan') }}">
                <div class="text-danger">
                  @error('keterangan')
                  {{ $message }}
                  @enderror
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
          </div>
        </div>
      </div>
    </div>
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
      newElement.innerHTML = `<select name="transport_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($transportasi as $item)<option value="{{ $item->id }}" >{{ $item->jenis_transportasi }}</option>@endforeach</select> <input name="uang[]" class="form-control ml-2" type="number"> <button class="btn btn-outline-danger ml-3 remove_transportasi" type="button" id="button-addon2">Remove</button>`
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
      newElement.innerHTML = `<select name="penginapan_id[]" class="form-control" ><option value="" >- Pilih -</option>@foreach ($pn as $item)<option value="{{ $item->id }}" >{{ $item->nama_penginapan }}</option>@endforeach</select> <input name="uang1[]" class="form-control ml-2" type="number"> <button class="btn btn-outline-danger ml-3 remove_penginapan" type="button" id="button-addon3">Remove</button>`
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