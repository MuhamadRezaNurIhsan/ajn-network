<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Paket;
use App\Models\UserMikrotik;
use App\Models\Queue;
use App\Services\MikroTikService;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    protected $mikrotik;

    public function __construct(MikroTikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    public function index(Request $request)
    {
        $query = Pelanggan::with('paket');

    // Search nama atau kontak
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('kontak', 'like', '%' . $request->search . '%');
        });
    }

    // Filter berdasarkan paket
    if ($request->paket_id) {
        $query->where('paket_id', $request->paket_id);
    }

    // Filter berdasarkan status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Urutan
    switch ($request->sort) {
        case 'nama_asc':
            $query->orderBy('nama', 'asc');
            break;
        case 'nama_desc':
            $query->orderBy('nama', 'desc');
            break;
        case 'masa_aktif':
            $query->orderBy('masa_aktif_berakhir', 'asc');
            break;
        default:
            $query->latest();
            break;
    }

    $pelanggans = $query->paginate(10)->withQueryString();
    $pakets = Paket::all();

    return view('pelanggan.index', compact('pelanggans', 'pakets'));
    }

    public function create()
    {
        $pakets = Paket::all();
        return view('pelanggan.create', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kontak' => 'required',
            'paket_id' => 'required',
            'masa_aktif_mulai' => 'required|date',
        ]);

        $paket = Paket::find($request->paket_id);
        
        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'paket_id' => $request->paket_id,
            'masa_aktif_mulai' => $request->masa_aktif_mulai,
            'masa_aktif_berakhir' => date('Y-m-d', strtotime($request->masa_aktif_mulai . ' +30 days')),
            'status' => 'aktif',
        ]);

        $username = $request->username_mikrotik ?? strtolower(str_replace(' ', '_', $request->nama));
        $password = $request->password_mikrotik ?? 'password123';
        
        UserMikrotik::create([
            'pelanggan_id' => $pelanggan->id_pelanggan,
            'username' => $username,
            'password' => $password,
            'status_aktif' => 1,
        ]);

        Queue::create([
            'pelanggan_id' => $pelanggan->id_pelanggan,
            'target_speed' => $paket->speed_download . 'M',
            'simple_queue_name' => 'queue_' . $username,
        ]);

        $this->mikrotik->createUser($username, $password, $paket->speed_download, $paket->speed_upload);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pakets = Paket::all();
        return view('pelanggan.edit', compact('pelanggan', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        $pelanggan->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'paket_id' => $request->paket_id,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        if ($pelanggan->userMikrotik) {
            $this->mikrotik->disableUser($pelanggan->userMikrotik->username);
            $pelanggan->userMikrotik->delete();
        }
        
        if ($pelanggan->queue) {
            $pelanggan->queue->delete();
        }
        
        $pelanggan->delete();
        
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $userMikrotik = $pelanggan->userMikrotik;
    
            if ($pelanggan->status == 'aktif') {
                if ($userMikrotik) {
                    $this->mikrotik->disableUser($userMikrotik->username);
                    $userMikrotik->update(['status_aktif' => 0]);
                }
                $pelanggan->update(['status' => 'nonaktif']);
                return redirect()->back()->with('warning', 'Pelanggan berhasil dinonaktifkan');
            } else {
                if ($userMikrotik) {
                    $this->mikrotik->enableUser($userMikrotik->username);
                    $userMikrotik->update(['status_aktif' => 1]);
                }
                $pelanggan->update(['status' => 'aktif']);
                return redirect()->back()->with('success', 'Pelanggan berhasil diaktifkan');
            }
    }
}