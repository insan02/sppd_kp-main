@extends('layout.v_template')

@section('main-content')
<!-- Page Heading -->
<!-- <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1> -->
<h2 class="h3 mb-4 text-gray-800">{{ __('Selamat Datang di Aplikasi Surat Perintah Perjalanan Dinas Karyawan!') }}</h2>

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

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pegawai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $karyawan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Surat belum disposisi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $undangan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Surat sudah disposisi</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $undangann }}</div>
                            </div>
                            <div class="col">
                                {{-- <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat dari kantor</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kantor }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">LLDIKTI WILAYAH X</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('img/lldikti.jpg') }}" alt="">
                </div>
                <p> Lembaga Layanan Pendidikan Tinggi disingkat LLDIKTI, sebelumnya bernama Koordinasi Perguruan Tinggi Swasta atau Kopertis yang merupakan salah satu unit kerja di lingkungan Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi (Kemendikbudristek).</p>
                <a target="_blank" rel="nofollow" href="https://lldikti10.id/">website resmi lldikti wilayah x →</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">VISI & MISI LLDIKTI WILAYAH X</h6>
            </div>
            <div class="card-body">
                <h5>VISI</h5>
                <p>
                    LLDIKTI Wilayah X mendukung Visi dan Misi Kementerian Pendidikan, Kebudayaan, Riset dan Teknologi sesuai Visi dan Misi Presiden untuk mewujudkan Indonesia Maju yang berdaulat, mandiri, dan berkepribadian melalui terciptanya pelajar pancasila yang bernalar kritis, kreatif, mandiri, beriman, bertaqwa kepada Tuhan YME, dan berakhlak mulia, bergotong royong, dan berkebhinekaan global
                </p>
                <h5>MISI</h5>
                <p class="mb-0">
                    1. Melaksanakan pemetaan mutu penyelenggaraan dan pengelolaan perguruan tinggi <br>

                    2. Menyelenggarakan fasilitasi mutu penyelenggaraan pengelolaan perguruan tinggi <br>

                    3. Melaksanakan pembinaan pendidik dan tenaga kependidikan perguruan tinggi <br>

                    4. Melakukan kerjasama pengembangan mutu perguruan tinggi <br>

                    5. Melaksanakan evaluasi penyelenggaraan tri dharma perguruan tinggi
                </p>
            </div>
        </div>
    </div>
</div>
@endsection