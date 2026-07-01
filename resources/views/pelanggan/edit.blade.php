@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('content')
<div class="animate-fade">
    
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pelanggan.index') }}" class="text-slate-400 hover:text-slate-300 transition">
            ← Kembali
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Edit Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Ubah data pelanggan</p>
        </div>
    </div>

    <div class="card-glass p-6 max-w-3xl">
        <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" class="input-modern w-full" value="{{ $pelanggan->nama }}" required>
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">No WhatsApp *</label>
                    <input type="text" name="kontak" class="input-modern w-full" value="{{ $pelanggan->kontak }}" required>
                </div>
                <div class="md:col-span-2">
                    <label class="text-slate-400 text-sm block mb-2">Alamat *</label>
                    <textarea name="alamat" class="input-modern w-full" rows="2" required>{{ $pelanggan->alamat }}</textarea>
                </div>
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Paket *</label>
                    <select name="paket_id" class="input-modern w-full" required>
                        @foreach($pakets as $paket)
                            <option value="{{ $paket->id_paket }}" {{ $pelanggan->paket_id == $paket->id_paket ? 'selected' : '' }}>
                                {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                <button type="submit" class="btn-primary">Update Pelanggan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection