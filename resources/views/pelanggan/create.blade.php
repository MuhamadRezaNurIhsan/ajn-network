@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('content')
<div class="animate-fade">
    
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pelanggan.index') }}" class="text-red-500 hover:text-red-700 transition">
            ← Kembali
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Tambah Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Isi data pelanggan baru</p>
        </div>
    </div>

    <div class="card-glass p-6 max-w-3xl">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" class="input-modern w-full" required placeholder="Contoh: Ahmad Fauzi">
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">No WhatsApp *</label>
                    <input type="text" name="kontak" class="input-modern w-full" required placeholder="08123456789">
                </div>
                <div class="md:col-span-2">
                    <label class="text-slate-400 text-sm block mb-2">Alamat *</label>
                    <textarea name="alamat" class="input-modern w-full" rows="2" required placeholder="Jl. Bougenville 10, Pasar Kemis, Tangerang"></textarea>
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Paket *</label>
                    <select name="paket_id" class="input-modern w-full" required>
                        <option value="">Pilih Paket</option>
                        @foreach($pakets as $paket)
                            <option value="{{ $paket->id_paket }}">{{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Masa Aktif Mulai *</label>
                    <input type="date" name="masa_aktif_mulai" class="input-modern w-full" required>
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Username MikroTik (Opsional)</label>
                    <input type="text" name="username_mikrotik" class="input-modern w-full" placeholder="auto generate">
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Password MikroTik (Opsional)</label>
                    <input type="text" name="password_mikrotik" class="input-modern w-full" placeholder="auto generate">
                </div>
            </div>
            
            <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                <button type="submit" class="btn-primary">Simpan Pelanggan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection