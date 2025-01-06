<!DOCTYPE html>

<head>
    <title> Surat Tugas </title>
    <meta charset="utf-8">
    <style>
        @page {
            size: 8.3in 11.7in;
        }

        #judul {
            text-align: justify;
        }

        #halaman {
            width: auto;
            height: auto;
            position: absolute;
            padding-top: 10px;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 80px;
        }

        #jarak {
            line-height: 15%;
        }
    </style>
</head>

<body>
    <div id=halaman>
        <table>
            <table width="100%">
                <td width=16%><img src="{{('img/tut.jpg') }}" height="8%"></td>
                <td>
                    <justify id="jarak">
                        <h4 style="color:#1C1C1C;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h4>
                        <h4 style="color:#1C1C1C;">LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH X </h4>
                        <h4 style="color:#1C1C1C;">(SUMBAR, RIAU, JAMBI DAN KEP. RIAU)</h4>
                    </justify>
                </td>
            </table>
            <table>
            </table>
            <tr>
                <td colspan="7">
                    <hr>
                </td>
            </tr>
        </table>
        <table width="500">
            <tr class="text2">
                <td>Nomor : </td>
                <td></td>
            </tr>
            <br>
            <center>
                <font size="4"> SURAT PERINTAH TUGAS</font>
            </center><br>
        </table>
        <table id=marginkiri>
            <tr>
                <td>Yang bertanda tangan di bawah ini:</td>
            </tr>
            <table width="350">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>@foreach($pimpinan as $ppm){{ $ppm->nama }}<br>
                        @endforeach</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>@foreach($pimpinan as $ppm){{$ppm->nip }}<br>
                        @endforeach</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Kepala LLDIKTI Wilayah X</td>
                </tr>
            </table>
            <br>
            <tr>
                <td>Dengan ini menugaskan nama-nama yang tersebut di bawah ini :</td>
            </tr>
        </table>
        <table width="410">
            @foreach($itemss as $item)
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $item->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $item->jabatan }}</td>
            </tr>
            @endforeach
        </table> <br>
        <table>
            <tr>
                <td>Untuk melaksanakan tugas pada :</td>
            </tr>
        </table>
        <table width="170">
            @foreach($kantor as $item)
            <tr>
                <td>Tanggal Pergi</td>
                <td>:</td>
                <td>{{ $item->tanggal_pergi }}</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>{{ $item->nama_kota }}</td>
            </tr>
            @endforeach
        </table> <br>
        <table>
            <tr>
                <td>Demikian Surat Perintah Tugas ini dibuat untuk dapat dilaksanakan dengan sebaik-baiknya.</td>
            </tr>
        </table>
        <br>
        <div style="width:30%; text-align: left; float: right;">
            Padang, {{$today}}
            <br>Kepala LLDIKTI Wilayah X
        </div>
        <br><br><br><br><br><br>
        @foreach($pimpinan as $ppm)
        <div style="width:30%; text-align: left; float: right;"><b><u>{{ $ppm->nama }}</u></b><br>
            NIP {{$ppm->nip }}
            @endforeach</div>
    </div>
</body>