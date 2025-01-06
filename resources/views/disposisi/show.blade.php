@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 text-center">{{ $title ?? __('Detail Disposisi') }}</h1>

<div>
  @foreach($item->details as $ite)
  <table class="table table-bordered table-stripped mb-4">
    <tr>
      <td style="font-weight: bold">No Surat</td>
      <td>{{ $ite->no_surat }}</td>
      <td style="font-weight: bold">Tanggal Pergi</td>
      <td>{{ $ite->tanggal_pergi }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold">Judul Surat</td>
      <td>{{ $ite->judul_surat }}</td>
      <td style="font-weight: bold">Tanggal Pulang</td>
      <td>{{ $ite->tanggal_pulang }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold">Lampiran Surat</td>
      <td>
        <a href="{{ asset('lampiran_undangan/'. $ite->lampiran_undangan )}}" target="_blank" rel="noopener noreferrer"> {{$ite->lampiran_undangan}} </a>
      </td>
    </tr>
  </table>
  @endforeach

  <div class="flex justify-center my-4">
    <a href="/tanggapan/show/{{ $ite->id }}" class="btn btn-primary btn-center">Tambah Karyawan</a>
  </div>
  <div>
    <table id="table" class="table table-bordered table-stripped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Karyawan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($itemss as $nama)
        <tr>
          <td scope="row">{{ $loop->iteration }}</td>
          <td>{{$nama->nama}}</td>
          <td>
            <div class="d-flex float-center">
              <a href="{{Route('disposisi.show.destroy',[$nama->id, $nama->karyawan_id])}}" display="inline" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div>
    <form action="/disposisi/update/{{ $item->id }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group d-flex float-right">
        <button class="btn  btn-primary ml-45" onclick="return confirm('Yakin ingin mengirim surat?');">Kirim surat</button>
      </div>
    </form>
  </div>
</div>

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