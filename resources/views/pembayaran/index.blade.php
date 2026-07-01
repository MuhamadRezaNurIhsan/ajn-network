@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')
@section('content')
<div class="animate-fade">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Riwayat Pembayaran</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar pembayaran pelanggan</p>
        </div>
        <a href="{{ route('pembayaran.create') }}" class="btn-primary inline-block text-center">
            + Tambah Pembayaran
        </a>
    </div>

    <div class="card-glass p-5">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-center py-3 px-3 text-s font-bold">No</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Pelanggan</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Tanggal Bayar</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Periode</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Jumlah</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayarans as $i => $p)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $i + $pembayarans->firstItem() }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $p->pelanggan->nama }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="text-center py-3 px-3">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('pembayaran.cetak', $p->id_pembayaran) }}" target="_blank" 
                                class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-500/20 text-blue-400 hover:bg-blue-500/40 transition-colors"> Cetak Kwitansi
                                </a>

                @if(Auth::user()->role == 'administrator')
                <form action="{{ route('pembayaran.destroy', $p->id_pembayaran) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/40 transition-colors"
                            onclick="return confirm('Yakin hapus pembayaran ini?')">
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $pembayarans->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection