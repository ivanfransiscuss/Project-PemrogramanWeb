<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MemilikiKelompok;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    use MemilikiKelompok;
}
