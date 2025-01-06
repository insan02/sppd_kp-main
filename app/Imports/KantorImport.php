<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Kantor;
use App\Models\Karyawan;
use App\Models\Karyawan_Kantor;
use Maatwebsite\Excel\Concerns\ToModel;



// class KantorImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */


//     public function model(array $row)
//     {

//         // $newYear = new Carbon($row[5]);
//         $tglPgi = Carbon::createFromFormat('Y-m-d H', $row[4])->toDateTimeString();
//         $tglPlg = Carbon::createFromFormat('Y-m-d H', $row[5])->toDateTimeString();
        


//         $kantor = new Kantor([
//             'lokasi_id' => $row[1],
//             'users_id' => $row[2],
//             'judul_surat' => $row[3],
//             'tanggal_pergi' => $tglPgi,
//             'tanggal_pulang' =>$tglPlg,
//             'lampiran_surat' => $row[6],
//         ]);

//         $karyawan = Karyawan_Kantor::create([
//             'karyawan_id' => (int)$row[7],
//         ]);


//         $obj_merged = (object) array_merge((array) $kantor, (array) $karyawan);


//         return $karyawan; 

//     }


// }
