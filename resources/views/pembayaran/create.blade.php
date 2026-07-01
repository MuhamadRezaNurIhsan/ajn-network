@extends('layouts.app')

@section('title', 'Tambah Pembayaran')
@section('content')
<div class="animate-fade">
    
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pembayaran.index') }}" class="text-red-500 hover:text-red-700 transition">
            ← Kembali
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Tambah Pembayaran</h1>
            <p class="text-slate-500 text-sm mt-1">Catat pembayaran pelanggan</p>
        </div>
    </div>

    <div class="card-glass p-6 max-w-2xl">
        <form action="{{ route('pembayaran.store') }}" method="POST">
            @csrf
            
            <div class="space-y-5">
                <div>
                    <label class="text-slate-400 text-sm block mb-2">Pilih Pelanggan *</label>
                    <select name="pelanggan_id" id="pelanggan_id" class="input-modern w-full" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id_pelanggan }}" 
                                    data-paket="{{ $pelanggan->paket->harga ?? 0 }}"
                                    data-nama-paket="{{ $pelanggan->paket->nama_paket ?? '-' }}">
                                {{ $pelanggan->nama }} - {{ $pelanggan->paket->nama_paket ?? 'No Paket' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="info-pelanggan p-4 bg-slate-800/30 rounded-lg hidden">
                    <h4 class="text-slate-200 font-semibold text-sm mb-2">Informasi Pelanggan</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="text-slate-400">Nama:</div>
                        <div class="text-slate-200" id="info_nama">-</div>
                        <div class="text-slate-400">Paket:</div>
                        <div class="text-slate-200" id="info_paket">-</div>
                        <div class="text-slate-400">Harga Paket:</div>
                        <div class="text-slate-200" id="info_harga">-</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-slate-400 text-sm block mb-2">Tanggal Bayar *</label>
                        <input type="date" name="tanggal_bayar" class="input-modern w-full" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="text-slate-400 text-sm block mb-2">Jumlah Bayar *</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="input-modern w-full" required placeholder="Contoh: 100000">
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                <button type="submit" class="btn-primary">Simpan Pembayaran</button>
                <a href="{{ route('pembayaran.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>

<script>
    // Auto fill jumlah bayar berdasarkan paket pelanggan yang dipilih
    const pelangganSelect = document.getElementById('pelanggan_id');
    const jumlahBayarInput = document.getElementById('jumlah_bayar');
    const infoPanel = document.querySelector('.info-pelanggan');
    const infoNama = document.getElementById('info_nama');
    const infoPaket = document.getElementById('info_paket');
    const infoHarga = document.getElementById('info_harga');
    
    pelangganSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-paket');
        const namaPaket = selectedOption.getAttribute('data-nama-paket');
        const namaPelanggan = selectedOption.text.split(' - ')[0];
        
        if (this.value && harga) {
            // Isi otomatis jumlah bayar dengan harga paket
            jumlahBayarInput.value = harga;
            
            // Tampilkan info pelanggan
            infoNama.textContent = namaPelanggan;
            infoPaket.textContent = namaPaket;
            infoHarga.textContent = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
            infoPanel.classList.remove('hidden');
        } else {
            jumlahBayarInput.value = '';
            infoPanel.classList.add('hidden');
        }
    });
</script>
@endsection