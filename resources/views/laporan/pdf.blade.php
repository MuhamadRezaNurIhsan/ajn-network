<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - AJ NETWORK</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Segoe UI', sans-serif;
            font-size: 11px;
            background: white;
            color: #1E293B;
            padding: 28px 32px;
        }

        /* ============================================
           KOP SURAT
        ============================================ */
        .kop-wrapper {
            border-bottom: 3px solid #0B326D;
            padding-bottom: 8px; /* dikecilkan agar konten mepet ke garis */
            margin-bottom: 6px;
        }

        .kop {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .kop-logo,
        .kop-tengah,
        .kop-kanan {
            display: table-cell;
            vertical-align: middle;
        }

        .kop-logo {
            width: 100px;
            padding-right: 10px;
        }

        .kop-logo img {
            width: 120px;
            height: auto;
            display: block;
        }

        .kop-tengah {
            text-align: center;
            padding: 0 10px;
        }

        .kop-tengah .nama-perusahaan {
            font-size: 18px;
            font-weight: 900;
            color: #0B326D;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            white-space: nowrap;
        }

        .kop-tengah .divider-thin {
            border: none;
            border-top: 1px solid #CBD5E1;
            margin: 0 auto;
            width: 70%;
        }

        .kop-tengah .info-baris {
            font-size: 9px;
            color: #475569;
            line-height: 1.3;
            margin-bottom: 0; /* hilangkan jarak bawah agar teks mepet ke garis */
        }

        .kop-kanan {
            width: 110px;
            padding-left: 12px;
        }

        .kop-garis-bawah {
            height: 3px;
            background: linear-gradient(to right, #0B326D 70%, #F39C16 100%);
            margin-top: 0px;
            border-radius: 2px;
        }

        /* ============================================
           JUDUL LAPORAN
        ============================================ */
        .judul-section {
            text-align: center;
            margin: 20px 0 18px 0;
        }

        .judul-section h3 {
            font-size: 14px;
            font-weight: 900;
            color: #0B326D;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .judul-section .periode-text {
            font-size: 11px;
            color: #64748B;
            margin-top: 4px;
        }

        .judul-section .underline-judul {
            width: 60px;
            height: 3px;
            background: #0B326D;
            margin: 8px auto 0;
            border-radius: 2px;
        }

        /* ============================================
           LABEL SECTION
        ============================================ */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            color: #0B326D;
            margin: 18px 0 6px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #CBD5E1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============================================
           TABEL DETAIL PEMBAYARAN
        ============================================ */
        .table-detail {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .table-detail thead tr th {
            background: #0B326D;
            color: white;
            padding: 9px 10px;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #1a4a8a;
        }

        .table-detail tbody tr td {
            border: 1px solid #E2E8F0;
            padding: 7px 10px;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }

        .table-detail tbody tr:nth-child(even) td {
            background-color: #F8FAFC;
        }

        .td-nama {
            text-align: left !important;
        }

        .td-jumlah {
            text-align: right !important;
            font-weight: 700;
            color: #0B326D;
        }

        .row-total td {
            background: #EFF6FF !important;
            font-weight: 700;
            color: #0B326D;
            border-top: 2px solid #0B326D !important;
        }

        /* ============================================
           TABEL RINGKASAN
        ============================================ */
        .table-ringkasan {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .table-ringkasan thead tr th {
            background: #0B326D;
            color: white;
            padding: 9px 10px;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #1a4a8a;
        }

        .table-ringkasan tbody tr td {
            border: 1px solid #E2E8F0;
            padding: 9px 10px;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
            background: #F8FAFC;
        }

        .td-pemasukan { 
            color: #16A34A; 
            font-weight: 800;
        }
        .td-piutang   { 
            color: #DC2626; 
            font-weight: 800;
        }
        .td-aktif     { 
            color: #0B326D; 
            font-weight: 800;
        }
        .td-nonaktif  { 
            color: #64748B; 
        }

        /* ============================================
           FOOTER
        ============================================ */
        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px solid #E2E8F0;
            font-size: 9px;
            color: #94A3B8;
        }

        /* ============================================
           PRINT
        ============================================ */
        @media print {
            body {
                padding: 16px 20px;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>

    <!-- ===== KOP SURAT ===== -->
    <div class="kop-wrapper">
        <div class="kop">

            <!-- LOGO KIRI -->
            <div class="kop-logo">
                <img src="{{ public_path('images/logo_ajn.png') }}" alt="Logo AJ NETWORK">
            </div>

            <!-- TENGAH: IDENTITAS PERUSAHAAN -->
            <div class="kop-tengah">
                <div class="nama-perusahaan">PT. AJ NETWORK NET FIBER</div>
                <hr class="divider-thin">
                <div class="info-baris">
                    Perumahan Bumi Indah RT 02/RW09 Kelurahan Sukamantri,<br>
                    Kecamatan Pasarkemis, Kabupaten Tangerang, Banten. 15560
                </div>
            </div>

            <!-- SPACER KANAN (simetris dengan logo) -->
            <div class="kop-kanan"></div>

        </div>
        <div class="kop-garis-bawah"></div>
    </div>

    <!-- ===== JUDUL LAPORAN ===== -->
    <div class="judul-section">
        <h3>LAPORAN KEUANGAN</h3>
        <div class="periode-text">
            Periode: {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->isoFormat('MMMM') }} {{ $tahun }}
        </div>
        <div class="underline-judul"></div>
    </div>

    <!-- ===== TABEL DETAIL PEMBAYARAN ===== -->
    <div class="section-label">Detail Pembayaran</div>
    <table class="table-detail">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Nama Pelanggan</th>
                <th width="20%">Tanggal Bayar</th>
                <th width="30%">Jumlah Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="td-nama">{{ $p->pelanggan->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                <td class="td-jumlah">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#94A3B8; font-style:italic; padding: 16px;">
                    Belum ada data pembayaran pada periode ini.
                </td>
            </tr>
            @endforelse

            @if(count($pembayarans) > 0)
            <tr class="row-total">
                <td colspan="3" style="text-align:right; padding-right: 12px;">TOTAL PEMASUKAN</td>
                <td class="td-jumlah">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- ===== TABEL RINGKASAN ===== -->
    <div class="section-label" style="margin-top: 20px;">Ringkasan Keuangan</div>
    <table class="table-ringkasan">
        <thead>
            <tr>
                <th width="25%">Total Pemasukan</th>
                <th width="25%">Total Piutang</th>
                <th width="25%">Pelanggan Aktif</th>
                <th width="25%">Pelanggan Nonaktif</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="td-pemasukan">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="td-piutang">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</td>
                <td class="td-aktif">{{ $pelangganAktif ?? 0 }} orang</td>
                <td class="td-nonaktif">{{ $pelangganNonaktif ?? 0 }} orang</td>
            </tr>
        </tbody>
    </table>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp; Sistem Informasi & Monitoring Jaringan
    </div>

</body>
</html>