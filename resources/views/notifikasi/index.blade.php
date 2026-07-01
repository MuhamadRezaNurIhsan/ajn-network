@extends('layouts.app')

@section('title', __('messages.notifikasi_tagihan'))
@section('content')
<div class="animate-fade">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">{{ __('messages.notifikasi_tagihan') }}</h1>
        <p class="text-slate-500 text-sm mt-1">{{ __('messages.kirim_pengingat_tagihan') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- CARD KIRI: Pilih Pelanggan -->
        <div class="card-glass p-5">
            <h3 class="text-slate-200 font-bold mb-4">{{ __('messages.pelanggan_mendekati_tenggang') }}</h3>
            
            <form action="{{ route('notifikasi.kirim') }}" method="POST">
                @csrf
                
                <!-- Tabel Pelanggan dengan Checkbox -->
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm">
                        <thead class="border-b border-white/10">
                            <tr>
                                <th class="text-left py-2 px-2 w-10">
                                    <input type="checkbox" id="selectAll" class="rounded border-white/20 bg-white/5">
                                </th>
                                <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.nama') }}</th>
                                <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.kontak') }}</th>
                                <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.masa_aktif') }}</th>
                                <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.sisa_hari') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelangganHampirHabis as $p)
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="py-2 px-2">
                                    <input type="checkbox" name="pelanggan_ids[]" value="{{ $p->id_pelanggan }}" class="pelanggan-checkbox rounded border-white/20 bg-white/5">
                                </td>
                                <td class="text-center py-2 px-2 text-slate-300">{{ $p->nama }}</td>
                                <td class="text-center py-2 px-2 text-slate-300">{{ $p->kontak }}</td>
                                <td class="text-center py-2 px-2 text-slate-300">{{ $p->masa_aktif_berakhir->format('d/m/Y') }}</td>
                                <td class="text-center py-2 px-2 text-orange-300">{{ now()->diffInDays($p->masa_aktif_berakhir) }} hari</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">
                                    Tidak ada pelanggan yang mendekati masa tenggang
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Form Pesan -->
                <div class="mb-4">
                    <label class="text-slate-400 text-sm block mb-2">{{ __('messages.pesan_notifikasi') }}</label>
                    <textarea name="pesan" class="input-modern w-full" rows="5" required>Yth. {nama_pelanggan}, masa aktif internet Anda akan berakhir pada {masa_aktif}. Segera lakukan pembayaran untuk menghindari pemutusan layanan. Terima kasih. PT. AJ NETWORK NET FIBER
                    </textarea>
                </div>
                
                <button type="submit" class="btn-primary w-full">
                     {{ __('messages.kirim_notifikasi') }}
                </button>
            </form>
        </div>
        
        <!-- CARD KANAN: Log Pengiriman -->
        <div class="card-glass p-5">
    <h3 class="text-slate-200 font-bold mb-4">{{ __('messages.log_pengiriman') }}</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10">
                <tr>
                    <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.waktu') }}</th>
                    <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.pelanggan') }}</th>
                    <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.jenis') }}</th>
                    <th class="text-center py-2 px-2 text-s font-bold">{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
    @forelse($notifikasis as $n)
    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($n->waktu_kirim)->format('d/m/Y H:i') }}</td>
        <td class="text-center py-3 px-3 text-slate-300 text-sm">{{ $n->pelanggan->nama }}</td>

        <td class="text-center py-2 px-2">
            @if($n->jenis == 'wa')
                <span class="badge-wa">WhatsApp</span>
            @else
                <span class="badge-sms">SMS</span>
            @endif
        </td>

        <td class="text-center py-2 px-2">
            @if($n->status == 'terkirim')
                <span class="badge-active">Terkirim</span>
            @else
                <span class="badge-nonactive">Gagal</span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="py-4 text-center text-slate-500">
            {{ __('messages.belum_ada_pengiriman') }}
        </td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>
</div>

<script>
    // Select All checkbox functionality
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.pelanggan-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = [...checkboxes].every(cb => cb.checked);
                const someChecked = [...checkboxes].some(cb => cb.checked);
                selectAll.checked = allChecked;
                selectAll.indeterminate = someChecked && !allChecked;
            });
        });
    }
</script>
@endsection