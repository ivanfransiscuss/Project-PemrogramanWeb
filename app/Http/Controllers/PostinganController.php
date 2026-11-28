<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MemilikiKelompok;
use App\Models\BalasanPostingan;
use App\Models\Postingan;
use App\Support\PkmData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostinganController extends Controller
{
    use MemilikiKelompok;
}
