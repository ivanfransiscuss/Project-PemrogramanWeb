<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MemilikiKelompok;
use App\Models\AnggotaKelompok;
use App\Models\Kelompok;
use App\Models\Postingan;
use App\Models\Todo;
use App\Support\PkmData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelompokController extends Controller
{
    use MemilikiKelompok;

    // Checklist PKM menyebut tim 3-5 mahasiswa, jadi batas maksimal 5
    private const MAKS_ANGGOTA = 5;
}
