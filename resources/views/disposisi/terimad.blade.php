@extends('layout.v_template')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Data Surat Undangan dari Pusat') }}</h1>

@if (session('message'))
<div class="alert alert-success">
  {{ session('message') }}
</div>
@endif

<table id="table" class="table table-bordered table-stripped">
  <thead>
    <tr>
      <th>No</th>
      <th>No Surat</th>
      <th>Judul Surat</th>
      <th>Lampiran Surat</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($items as $item)
    <tr>
      <td scope="row">{{ $loop->iteration }}</td>
      <td>{{ $item->no_surat}}</td>
      <td>{{ $item->judul_surat}}</td>
      <td>
        <a href="{{ asset('lampiran_undangan/'. $item->lampiran_undangan )}}" target="_blank" rel="noopener noreferrer"> {{$item->lampiran_undangan}} </a>
      </td>
      <td>
        <div class="d-flex">
          <a href="/disposisi/show/{{ $item->id }} " class="btn btn-primary mr-2">Terima</a>
          <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#exampleModalCenter">
            Tolak
          </button>
          <!-- Modal -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Tolak Surat</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Anda yakin ingin menolak surat ini?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                  <button type="button" class="btn btn-primary">Ya</button>
                </div>
              </div>
            </div>
          </div>
        </div>
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