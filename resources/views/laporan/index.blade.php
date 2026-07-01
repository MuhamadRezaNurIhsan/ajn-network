@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('content')
<div class="animate-fade">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">Laporan Keuangan</h1>
        <p class="text-slate-500 text-sm mt-1">Rekap pemasukan dan piutang</p>
    </div>

    <!-- Filter -->
    <div class="card-glass p-5 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="text-slate-400 text-sm block mb-2">Bulan</label>
                <select name="bulan" class="input-modern">
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}" {{ ($bulan ?? date('m')) == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="text-slate-400 text-sm block mb-2">Tahun</label>
                <select name="tahun" class="input-modern">
                    @for($i=2024; $i<=2030; $i++)
                        <option value="{{ $i }}" {{ ($tahun ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <button type="submit" class="btn-primary">Tampilkan</button>
            </div>
            <div>
                <a href="{{ route('laporan.pdf', ['bulan' => $bulan ?? date('m'), 'tahun' => $tahun ?? date('Y')]) }}" class="btn-secondary inline-block">Cetak PDF</a>
            </div>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="stat-card">
            <div class="text-2xl font-bold text-green-500">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="text-slate-500 text-sm mt-2">Total Pemasukan</div>
        </div>
        <div class="stat-card">
            <div class="text-2xl font-bold text-red-500">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
            <div class="text-slate-500 text-sm mt-2">Total Piutang</div>
        </div>
        <div class="stat-card">
            <div class="text-2xl font-bold text-green-500">{{ $pelangganAktif }}</div>
            <div class="text-slate-500 text-sm mt-2">Pelanggan Aktif</div>
        </div>
        <div class="stat-card">
            <div class="text-2xl font-bold text-red-500">{{ $pelangganNonaktif }}</div>
            <div class="text-slate-500 text-sm mt-2">Pelanggan Nonaktif</div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card-glass p-5">
        <h3 class="text-slate-200 font-bold mb-4">Detail Pembayaran</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-center py-3 px-3 text-s font-bold">No</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Pelanggan</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Tanggal Bayar</th>
                        <th class="text-center py-3 px-3 text-s font-bold">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayarans as $i => $p)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $i+1 }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $p->pelanggan->nama }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection