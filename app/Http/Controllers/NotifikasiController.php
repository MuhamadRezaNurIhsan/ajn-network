<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Notifikasi;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    protected $notifService;

    public function __construct(NotifikasiService $notifService)
    {
        $this->notifService = $notifService;
    }

    public function index()
    {
        $pelangganHampirHabis = Pelanggan::hampirHabis(7)->get();
        $notifikasis = Notifikasi::with('pelanggan')->latest()->limit(10)->get();
        
        return view('notifikasi.index', compact('pelangganHampirHabis', 'notifikasis'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'pelanggan_ids' => 'required|array',
            'pesan' => 'required',
        ]);

        $berhasil = 0;
        $gagal = 0;

        foreach ($request->pelanggan_ids as $id) {
            $pelanggan = Pelanggan::find($id);
            
            if ($pelanggan && $pelanggan->kontak) {
                $pesan = str_replace('{nama_pelanggan}', $pelanggan->nama, $request->pesan);
                $pesan = str_replace('{masa_aktif}', $pelanggan->masa_aktif_berakhir->format('d/m/Y'), $pesan);
                
                $result = $this->notifService->kirimWA($pelanggan->kontak, $pesan);
                
                Notifikasi::create([
                    'pelanggan_id' => $pelanggan->id_pelanggan,
                    'jenis' => 'wa',
                    'pesan' => $pesan,
                    'waktu_kirim' => now(),
                    'status' => $result ? 'terkirim' : 'gagal'
                ]);
                
                if ($result) $berhasil++;
                else $gagal++;
            }
        }

        return redirect()->back()->with('success', "Notifikasi terkirim: $berhasil, gagal: $gagal");
    }
}