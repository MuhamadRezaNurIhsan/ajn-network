@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('content')
<div class="animate-fade">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">Log Aktivitas</h1>
        <p class="text-slate-500 text-sm mt-1">Riwayat login/logout pelanggan</p>
    </div>

    <!-- Filter -->
    <div class="card-glass p-5 mb-6">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="text-slate-400 text-sm block mb-2">Dari Tanggal</label>
                <input type="date" name="dari" class="input-modern w-full" value="{{ request('dari') }}">
            </div>
            <div>
                <label class="text-slate-400 text-sm block mb-2">Sampai Tanggal</label>
                <input type="date" name="sampai" class="input-modern w-full" value="{{ request('sampai') }}">
            </div>
            <div>
                <label class="text-slate-400 text-sm block mb-2">Pelanggan</label>
                <select name="pelanggan_id" class="input-modern w-full">
                    <option value="">Semua Pelanggan</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}" {{ request('pelanggan_id') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                            {{ $pelanggan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">Filter</button>
            </div>
        </form>
    </div>

    <!-- Tabel Log -->
    <div class="card-glass p-5">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-center py-3 px-3  text-s font-bold">No</th>
                        <th class="text-center py-3 px-3  text-s font-bold">Pelanggan</th>
                        <th class="text-center py-3 px-3  text-s font-bold">Waktu Login</th>
                        <th class="text-center py-3 px-3  text-s font-bold">Waktu Logout</th>
                        <th class="text-center py-3 px-3  text-s font-bold">Durasi</th>
                        <th class="text-center py-3 px-3  text-s font-bold">Penggunaan Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $i => $log)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $i + $logs->firstItem() }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $log->pelanggan->nama }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($log->waktu_login)->format('d/m/Y H:i') }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $log->waktu_logout ? \Carbon\Carbon::parse($log->waktu_logout)->format('d/m/Y H:i') : '-' }}</td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">
                            @php
                                $jam = floor($log->durasi / 3600);
                                $menit = floor(($log->durasi % 3600) / 60);
                            @endphp
                            {{ $jam > 0 ? $jam.' jam ' : '' }}{{ $menit }} menit
                        </td>
                        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ number_format($log->total_data) }} MB</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $logs->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection