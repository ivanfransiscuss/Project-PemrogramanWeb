<?php

namespace App\Http\Controllers;

use App\Models\BookingBimbingan;
use App\Models\JadwalDosen;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingBimbinganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'dosen') {
            // Dosen melihat semua bookingan yang masuk ke jadwalnya
            $bookings = BookingBimbingan::whereHas('jadwal', function ($query) use ($user) {
                $query->where('dosen_id', $user->id);
            })->orderBy('created_at', 'desc')->get();
        } else {
            // Mahasiswa melihat bookingan kelompoknya (asumsi ketua_id = id user)
            $kelompok = Kelompok::where('ketua_id', $user->id)->first();
            if (!$kelompok) {
                return "Kamu belum terdaftar sebagai ketua kelompok.";
            }
            $bookings = BookingBimbingan::where('kelompok_id', $kelompok->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('booking.index', compact('bookings'));
    }

    // Form pengajuan booking
    public function create($jadwal_id)
    {
        $jadwal = JadwalDosen::findOrFail($jadwal_id);
        return view('booking.create', compact('jadwal'));
    }

    // Menyimpan pengajuan booking
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_dosen,id_jadwal',
            'topik_bimbingan' => 'required|string',
        ]);

        $user = Auth::user();
        $kelompok = Kelompok::where('ketua_id', $user->id)->first();

        if (!$kelompok) {
            return back()->with('error', 'Hanya ketua kelompok yang bisa melakukan booking.');
        }

        // Cek apakah sudah pernah booking di jadwal yang sama
        $cek = BookingBimbingan::where('jadwal_id', $request->jadwal_id)
            ->where('kelompok_id', $kelompok->id)
            ->first();

        if ($cek) {
            return back()->with('error', 'Kelompok kamu sudah booking di jadwal ini.');
        }

        BookingBimbingan::create([
            'jadwal_id' => $request->jadwal_id,
            'kelompok_id' => $kelompok->id,
            'topik_bimbingan' => $request->topik_bimbingan,
            'status_booking' => 'menunggu',
        ]);

        return redirect()->route('booking.index')->with('success', 'Booking berhasil diajukan!');
    }

    // Menyetujui atau Menolak Bookingan
    public function updateStatus(Request $request, $id_bimbingan)
    {
        $request->validate([
            'status_booking' => 'required|in:disetujui,ditolak',
        ]);

        $booking = BookingBimbingan::findOrFail($id_bimbingan);
        
        // Pastikan dosen hanya bisa mengubah status bookingan di jadwalnya sendiri
        if ($booking->jadwal->dosen_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $booking->update([
            'status_booking' => $request->status_booking,
        ]);

        if ($request->status_booking === 'disetujui') {
            $booking->jadwal->update(['status_slot' => 'penuh']);
        }

        return back()->with('success', 'Status booking berhasil diubah menjadi ' . $request->status_booking);
    }
}