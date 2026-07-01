@extends('layouts.app')

@section('title', __('messages.dashboard'))
@section('content')
<div class="animate-fade">
    
    <!-- Header -->
    <div class="mb-4 sm:mb-6 md:mb-8">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-100">{{ __('messages.dashboard') }}</h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">{{ __('messages.welcome_back') }}, <span class="text-blue-400">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span></p>
    </div>

    <!-- Stat Cards: 2 kolom di mobile, 4 kolom di desktop -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="stat-card">
            <div class="text-xl sm:text-2xl md:text-4xl font-bold text-slate-100 leading-tight">{{ $totalPelanggan }}</div>
            <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ __('messages.total_pelanggan') }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xl sm:text-2xl md:text-4xl font-bold text-green-500 leading-tight">{{ $pelangganAktif }}</div>
            <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ __('messages.pelanggan_aktif') }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xl sm:text-base md:text-4xl font-bold text-green-500 leading-tight">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ __('messages.pendapatan_bulan_ini') }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xl sm:text-2xl md:text-4xl font-bold text-red-500 leading-tight">{{ $menunggak }}</div>
            <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ __('messages.menunggak') }}</div>
        </div>
    </div>

    <!-- Charts: stack di mobile, side-by-side di desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-4 sm:gap-6 mb-6 sm:mb-8">

        <!-- Bandwidth Chart -->
        <div class="col-span-1 lg:col-span-4 card-glass p-4 sm:p-5">
            <div class="flex justify-between items-center mb-3 sm:mb-4">
                <h3 class="text-slate-200 font-bold text-sm sm:text-base">{{ __('messages.monitoring_bandwidth') }} (24 Jam)</h3>
                <span class="text-xs bg-green-500/15 text-green-400 px-2 sm:px-3 py-1 rounded-full flex-shrink-0">LIVE</span>
            </div>
            <!-- Container dengan tinggi tetap agar chart tidak overflow -->
            <div class="relative w-full" style="height: 220px;">
                <canvas id="bandwidthChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="col-span-1 lg:col-span-3 card-glass p-4 sm:p-5">
            <h3 class="text-slate-200 font-bold mb-3 sm:mb-4 text-sm sm:text-base text-center">{{ __('messages.distribusi_paket') }}</h3>
            <div class="relative w-full" style="height: 220px;">
                <canvas id="paketChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top 5 Pelanggan -->
    <div class="card-glass p-4 sm:p-5">
        <h3 class="text-slate-200 font-bold mb-3 sm:mb-4 text-sm sm:text-base">{{ __('messages.top_5_pelanggan') }}</h3>
        <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
            <table class="min-w-full" style="min-width: 480px;">
                <thead>
                    <tr>
                        <th class="text-center text-s font-bold tracking-wider px-3 py-3">No</th>
                        <th class="text-center text-s font-bodd tracking-wider px-3 py-3">{{ __('messages.nama') }}</th>
                        <th class="text-center text-s font-bold tracking-wider px-3 py-3">{{ __('messages.paket') }}</th>
                        <th class="text-center text-s font-bold tracking-wider px-3 py-3">{{ __('messages.status') }}</th>
                        <th class="text-center text-s font-bold tracking-wider px-3 py-3">{{ __('messages.masa_aktif') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topPelanggan as $i => $p)
                    <tr class="transition-colors">
                        <td class="text-center px-3 py-3 text-xs sm:text-sm text-slate-300">{{ $i+1 }}</td>
                        <td class="text-center px-3 py-3 text-xs sm:text-sm text-slate-300">{{ $p->nama }}</td>
                        <td class="text-center px-3 py-3 text-xs sm:text-sm text-slate-300">{{ $p->paket->nama_paket ?? '-' }}</td>
                        <td class="text-center px-3 py-3"><span class="badge-active">{{ __('messages.aktif') }}</span></td>
                        <td class="text-center px-3 py-3 text-xs sm:text-sm text-slate-300">{{ \Carbon\Carbon::parse($p->masa_aktif_berakhir)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>

    // ===== BANDWIDTH CHART 24 JAM =====
new Chart(document.getElementById('bandwidthChart'), {
    type: 'line',
    data: {
        labels: @json($timeLabels),
        datasets: [
            {
                label: 'Download (Mbps)',
                data: @json($downloadHistory),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59,130,246,0.05)',
                fill: true,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#0F172A'
            },
            {
                label: 'Upload (Mbps)',
                data: @json($uploadHistory),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16,185,129,0.05)',
                fill: true,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#0F172A'
            }
        ]
    },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: '#94A3B8', font: { size: 11 } },
                position: 'top'
            }
        },
        scales: {
            y: {
                grid: { color: 'rgba(255,255,255,0.05)' },
                ticks: { color: '#64748B', font: { size: 10 } },
                title: { display: true, text: 'Mbps', color: '#94A3B8', font: { size: 10 } }
            },
            x: {
                grid: { display: false },
                ticks: { 
                    color: '#64748B', 
                    maxRotation: 45, 
                    minRotation: 45, 
                    autoSkip: false,
                    maxTicksLimit: 6,
                    font: { size: 9 }
                }
            }
        },
        layout: {
            padding: { left: 5, right: 5, top: 10, bottom: 5 }
        }
    }
});

    // ===== DOUGHNUT CHART =====
    new Chart(document.getElementById('paketChart'), {
        type: 'doughnut',
        data: {
            labels: @json($paketLabels),
            datasets: [{
                data: @json($paketCounts),
                backgroundColor: ['#3B82F6', '#8B5CF6', '#10B981', '#F59E0B'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 8 },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#94A3B8',
                        font: { size: 11 },
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });
</script>
@endpush