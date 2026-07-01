@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('content')
<div class="animate-fade">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Data Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data pelanggan internet</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="btn-primary inline-block text-center">
            + Tambah Pelanggan
        </a>
    </div>

    <div class="card-glass p-5">
        <!-- Filter & Search -->
        <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2 flex-wrap">
    
        {{-- Search --}}
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau kontak..."
            class="input-modern w-full sm:w-64">

        {{-- Filter Paket --}}
        <select name="paket_id" class="input-modern w-full sm:w-48">
            <option value="">Semua Paket</option>
                @foreach($pakets as $paket)
                    <option value="{{ $paket->id_paket }}" {{ request('paket_id') == $paket->id_paket ? 'selected' : '' }}>
                        {{ $paket->nama_paket }}
                    </option>
                @endforeach
        </select>

        {{-- Filter Status --}}
        <select name="status" class="input-modern w-full sm:w-40">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        {{-- Urutan --}}
        <select name="sort" class="input-modern w-full sm:w-48">
            <option value="">Terbaru</option>
            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
            <option value="masa_aktif" {{ request('sort') == 'masa_aktif' ? 'selected' : '' }}>Masa Aktif Terdekat</option>
        </select>

        {{-- Tombol --}}
        <button type="submit" class="btn-primary">Filter</button>
        </form>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-center py-3 px-3 text-s font-bold">No</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Nama</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Kontak</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Paket</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Masa Aktif</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Status</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($pelanggans as $i => $p)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="px-3 py-3 text-center text-slate-300 text-sm">{{ $i + $pelanggans->firstItem() }}</td>
                        <td class="px-3 py-3 text-center text-slate-300 text-sm">{{ $p->nama }}</td>
                        <td class="px-3 py-3 text-center text-slate-300 text-sm">{{ $p->kontak }}</td>
                        <td class="px-3 py-3 text-center text-slate-300 text-sm">{{ $p->paket->nama_paket ?? '-' }}</td>
                        <td class="px-3 py-3 text-center text-slate-300 text-sm">{{ \Carbon\Carbon::parse($p->masa_aktif_berakhir)->format('d/m/Y') }}</td>
                        <td class="px-3 py-3 text-center text-sm">
                        <span class="{{ $p->status == 'aktif' ? 'badge-active' : 'badge-nonactive' }}">{{ ucfirst($p->status) }}</span>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" 
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-500/20 text-blue-400 hover:bg-blue-500/40 transition-colors">
                                        Edit
                                    </a>

                <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/40 transition-colors"
                            onclick="return confirm('Yakin hapus pelanggan ini?')">
                        Hapus
                    </button>
                </form>

                <a href="{{ route('pelanggan.toggle', $p->id_pelanggan) }}" 
                class="inline-flex items-center justify-center w-24 px-3 py-1.5 rounded-lg text-xs font-medium {{ $p->status == 'aktif' ? 'bg-orange-500/20 text-orange-400 hover:bg-orange-500/40' : 'bg-green-500/20 text-green-400 hover:bg-green-500/40' }} transition-colors">
                {{ $p->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
            </a>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $pelanggans->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection