<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pelanggan;
use App\Models\Paket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        // Pembayaran yang sudah tercatat
        $pembayarans = Pembayaran::with('pelanggan')
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->get();
        
        $totalPemasukan = $pembayarans->sum('jumlah_bayar');
        
        // Hitung piutang: pelanggan aktif yang masa aktif sudah habis
        $pelangganPiutang = Pelanggan::where('status', 'aktif')
            ->whereDate('masa_aktif_berakhir', '<', now())
            ->get();
        
        $totalPiutang = 0;
        foreach ($pelangganPiutang as $p) {
            $paket = Paket::find($p->paket_id);
            if ($paket) {
                $totalPiutang += $paket->harga;
            }
        }
        
        // Hitung pelanggan aktif dan nonaktif
        $pelangganAktif = Pelanggan::where('status', 'aktif')->count();
        $pelangganNonaktif = Pelanggan::where('status', 'nonaktif')->count();
        
        return view('laporan.index', compact(
            'pembayarans', 
            'totalPemasukan', 
            'totalPiutang',
            'pelangganAktif', 
            'pelangganNonaktif', 
            'bulan', 
            'tahun'
        ));
    }

    public function cetakPDF(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $pembayarans = Pembayaran::with('pelanggan')
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->get();
        
        $totalPemasukan = $pembayarans->sum('jumlah_bayar');
        
        // Hitung piutang untuk PDF
        $pelangganPiutang = Pelanggan::where('status', 'aktif')
            ->whereDate('masa_aktif_berakhir', '<', now())
            ->get();
        
        $totalPiutang = 0;
        foreach ($pelangganPiutang as $p) {
            $paket = Paket::find($p->paket_id);
            if ($paket) {
                $totalPiutang += $paket->harga;
            }
        }
        
        // Hitung pelanggan aktif dan nonaktif untuk PDF
        $pelangganAktif = Pelanggan::where('status', 'aktif')->count();
        $pelangganNonaktif = Pelanggan::where('status', 'nonaktif')->count();
        
        $pdf = Pdf::loadView('laporan.pdf', compact(
            'pembayarans', 
            'totalPemasukan', 
            'totalPiutang',
            'pelangganAktif',
            'pelangganNonaktif',
            'bulan', 
            'tahun'
        ));
        
        return $pdf->download('laporan_keuangan_' . $bulan . '_' . $tahun . '.pdf');
    }
}