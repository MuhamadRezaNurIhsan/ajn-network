<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Paket;
use App\Services\MikroTikService;

class DashboardController extends Controller
{
    protected $mikrotik;

    public function __construct(MikroTikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $pelangganAktif = Pelanggan::where('status', 'aktif')->count();
        $pendapatanBulanIni = Pembayaran::whereMonth('tanggal_bayar', date('m'))->sum('jumlah_bayar');
        $menunggak = Pelanggan::where('status', 'aktif')
            ->whereDate('masa_aktif_berakhir', '<', now())
            ->count();

        $paketData = Paket::withCount('pelanggans')->get();
        $paketLabels = $paketData->pluck('nama_paket');
        $paketCounts = $paketData->pluck('pelanggans_count');

        // Data untuk grafik 24 jam (12 titik waktu)
        $timeLabels = ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'];
        
        // Data Download (Mbps) - 24 jam
        $downloadHistory = [8, 6, 5, 7, 15, 25, 35, 55, 48, 40, 35, 20];
        
        // Data Upload (Mbps) - 24 jam
        $uploadHistory = [4, 3, 2, 4, 8, 15, 20, 30, 28, 25, 20, 12];

        // ✅ TOP 5 PELANGGAN: Berdasarkan total pembayaran tertinggi
        $topPelanggan = Pelanggan::with('paket')
            ->where('status', 'aktif')
            ->withSum('pembayarans', 'jumlah_bayar')
            ->orderBy('pembayarans_sum_jumlah_bayar', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPelanggan', 'pelangganAktif', 'pendapatanBulanIni', 'menunggak',
            'paketLabels', 'paketCounts', 'topPelanggan',
            'downloadHistory', 'uploadHistory', 'timeLabels'
        ));
    }
}