<?php

namespace App\Http\Controllers;

use App\Models\JadwalDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalDosenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'dosen') {
            // Dosen melihat jadwal miliknya sendiri
            $jadwals = JadwalDosen::where('dosen_id', $user->id)
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam_mulai', 'asc')
                ->get();
        } else {
            // Mahasiswa melihat semua jadwal yang masih tersedia
            $jadwals = JadwalDosen::where('status_slot', 'tersedia')
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam_mulai', 'asc')
                ->get();
        }

        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'metode' => 'required|in:online,offline',
            'lokasi_atau_link' => 'required|string',
        ]);

        JadwalDosen::create([
            'dosen_id' => Auth::id(), 
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'metode' => $request->metode,
            'lokasi_atau_link' => $request->lokasi_atau_link,
            'status_slot' => 'tersedia',
        ]);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // untuk menampilkan form edit jadwal
    public function edit($id_jadwal)
    {
        $jadwal = JadwalDosen::findOrFail($id_jadwal);
        // make sure hanya dosen pemilik jadwal yang bisa edit
        if ($jadwal->dosen_id !== Auth::id()) {
            return "Akses ditolak.";
        }
        return view('jadwal.edit', compact('jadwal'));
    }
    // untuk menyimpan perubahan jadwal
    public function update(Request $request, $id_jadwal)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'metode' => 'required|in:online,offline',
            'lokasi_atau_link' => 'required|string',
            'status_slot' => 'required|in:tersedia,penuh,selesai'
        ]);
        $jadwal = JadwalDosen::findOrFail($id_jadwal);
        if ($jadwal->dosen_id !== Auth::id()) {
            return "Akses ditolak.";
        }
        $jadwal->update($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
    // untuk menghapus jadwal
    public function destroy($id_jadwal)
    {
        $jadwal = JadwalDosen::findOrFail($id_jadwal);
        if ($jadwal->dosen_id !== Auth::id()) {
            return "Akses ditolak.";
        }
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}