<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('pelanggan')->latest()->paginate(10);
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('pembayaran.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
        ]);

        $pelanggan = Pelanggan::find($request->pelanggan_id);
        $periodeBulan = date('F Y', strtotime($request->tanggal_bayar));

        Pembayaran::create([
            'pelanggan_id' => $request->pelanggan_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'periode_bulan' => $periodeBulan,
        ]);

        // Update masa aktif pelanggan (+30 hari)
        $masaAktifBaru = date('Y-m-d', strtotime($pelanggan->masa_aktif_berakhir . ' +30 days'));
        $pelanggan->update([
            'masa_aktif_berakhir' => $masaAktifBaru,
            'status' => 'aktif'
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dicatat');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus');
    }

    public function cetakKwitansi($id)
    {
        $pembayaran = Pembayaran::with('pelanggan')->findOrFail($id);
        return view('pembayaran.kwitansi', compact('pembayaran'));
    }
}