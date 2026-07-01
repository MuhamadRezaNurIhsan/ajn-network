<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('pelanggan');
        
        // Filter berdasarkan tanggal
        if ($request->filled('dari')) {
            $query->whereDate('waktu_login', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('waktu_login', '<=', $request->sampai);
        }
        
        // Filter berdasarkan pelanggan
        if ($request->filled('pelanggan_id')) {
            $query->where('pelanggan_id', $request->pelanggan_id);
        }
        
        $logs = $query->latest()->paginate(20);
        $pelanggans = Pelanggan::all();
        
        return view('log.index', compact('logs', 'pelanggans'));
    }
    
    /**
     * Tambahkan data log aktivitas (untuk testing atau manual)
     */
   public function addDummyLogs()
    {
    $pelanggans = Pelanggan::all();
    
    if ($pelanggans->isEmpty()) {
        return redirect()->route('log.index')->with('error', 'Tidak ada data pelanggan. Tambahkan pelanggan terlebih dahulu.');
    }
    
    foreach ($pelanggans as $pelanggan) {
        for ($i = 1; $i <= 5; $i++) {
            $tanggal = now()->subDays($i);
            $loginTime = $tanggal->copy()->setTime(rand(7, 10), rand(0, 59), 0);
            $logoutTime = $loginTime->copy()->addHours(rand(2, 8));
            
            LogAktivitas::create([
                'pelanggan_id' => $pelanggan->id_pelanggan,
                'waktu_login' => $loginTime,
                'waktu_logout' => $logoutTime,
                'durasi' => $loginTime->diffInSeconds($logoutTime),
                'total_data' => rand(500, 5000),
            ]);
        }
    }
    
    return redirect()->route('log.index')->with('success', 'Data dummy log aktivitas berhasil ditambahkan.');
    }
    
    /**
     * Hapus semua data log aktivitas
     */
    public function clearLogs()
    {
        LogAktivitas::truncate();
        return redirect()->route('log.index')->with('success', 'Semua data log aktivitas telah dihapus.');
    }
}