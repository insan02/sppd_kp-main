 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
         <div class="">
             <img class="img-fluid px-2 px-sm-11 mt-7 mb-11" style="width: 70rem;" src="{{ asset('img/etek-removebg-preview.png') }}" alt="">
         </div>
         <div class=" sidebar-brand-text mx-3 ">LLDIKTI WILAYAH X</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="/home">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     @if (auth()->user()->role_user=='Admin')
     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Data Master</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/karyawan">Karyawan</a>
                 <a class="collapse-item" href="/user">User</a>
                 <a class="collapse-item" href="/penandatangan">Penandatangan</a>
                 <a class="collapse-item" href="/jabatan">Jabatan</a>
                 <a class="collapse-item" href="/fullboard">Fullboard</a>
                 <a class="collapse-item" href="/lokasi">Lokasi</a>
                 <a class="collapse-item" href="/transportasi">Transportasi</a>
                 <a class="collapse-item" href="penginapan">Penginapan</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
             <i class="fas fa-fw fa-folder"></i>
             <span>Dinas Luar Pusat</span>
         </a>
         <div id="collapseOne" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/pusat">Tambah surat</a>
                 <a class="collapse-item" href="/pusat/terima">Riwayat proses</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
             <i class="fas fa-fw fa-folder"></i>
             <span>Dinas Luar Kantor</span>
         </a>
         <div id="collapseOne1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/kantor">Tambah surat</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-fw fa-envelope"></i>
             <span>Surat Tugas</span>
         </a>
         <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/surat_tugaspp">Pusat</a>
                 <a class="collapse-item" href="/surat_tugaskk">Kantor</a>
             </div>
         </div>
     </li>

     @elseif (auth()->user()->role_user=='Pimpinan')
     <!-- Nav Item - Charts -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>Disposisi</span>
         </a>
         <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/disposisi">Belum diproses</a>
                 <a class="collapse-item" href="/disposisi/terima">Riwayat proses</a>
             </div>
         </div>
     </li>

     @elseif (auth()->user()->role_user=='Admin HKT')
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-fw fa-envelope"></i>
             <span>Surat Tugas</span>
         </a>
         <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                 <a class="collapse-item" href="/surat_tugasp">Pusat</a>
                 <a class="collapse-item" href="/surat_tugask">Kantor</a>
             </div>
         </div>
     </li>

     @elseif (auth()->user()->role_user=='Admin Keuangan')
     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link" href="/uangup">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>UP</span></a>
    </li>

     <li class="nav-item">
         <a class="nav-link collapsed0" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-dollar-sign"></i>
             <span>Keuangan Pusat</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                 <a class="collapse-item" href="/keuangan">Belum Diproses</a>
                 <a class="collapse-item" href="/keuangan/riwayat">Laporan Pusat</a>
                 <!-- <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a> -->
             </div>
         </div>
     </li>

     <li class="nav-item">
         <a class="nav-link collapsed1" href="#" data-toggle="collapse" data-target="#collapseUtilities0" aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-dollar-sign"></i>
             <span>Keuangan Kantor</span>
         </a>
         <div id="collapseUtilities0" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                 <a class="collapse-item" href="/keuangank">Belum Diproses</a>
                 <a class="collapse-item" href="/keuangank/riwayat">Laporan Kantor</a>
             </div>
         </div>
     </li>
     @endif

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!--End of Sidebar -->