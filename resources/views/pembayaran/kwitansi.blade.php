<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - AJ NETWORK</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            transition: background 0.3s ease;
        }
        .kwitansi-container {
            max-width: 500px;
            width: 100%;
        }
        .kwitansi {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            text-align: center;
            padding: 24px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .header .logo {
            width: 70px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }
        .header p {
            font-size: 12px;
            color: #64748B;
        }
        .header .alamat {
            font-size: 10px;
            color: #64748B;
            margin-top: 6px;
        }
        .content {
            padding: 24px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-size: 13px;
            font-weight: 500;
            color: #64748B;
        }
        .info-value {
            font-size: 13px;
            font-weight: 600;
            color: #1E293B;
            text-align: right;
        }
        .total {
            text-align: center;
            margin: 20px 0 0 0;
            padding: 16px;
            background: #F8FAFC;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .total .amount {
            font-size: 26px;
            font-weight: 800;
            transition: color 0.3s ease;
        }
        .total .label {
            font-size: 11px;
            color: #64748B;
            margin-top: 4px;
        }
        .footer {
            text-align: center;
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
            background: #F8FAFC;
            font-size: 10px;
            color: #64748B;
            transition: all 0.3s ease;
        }
        .footer strong {
            transition: color 0.3s ease;
        }
        .btn-print {
            display: block;
            width: 100%;
            margin-top: 16px;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-print:hover {
            transform: translateY(-1px);
        }
        
        @media print {
            body {
                background: white !important;
                padding: 0;
            }
            .kwitansi {
                box-shadow: none;
                border-radius: 0;
            }
            .btn-print {
                display: none;
            }
        }

        /* Light Mode */
        body.light-mode {
            background: #F5F6F5;
        }
        body.light-mode .header h2 {
            color: #0B326D;
        }
        body.light-mode .total .amount {
            color: #0B326D;
        }
        body.light-mode .footer strong {
            color: #0B326D;
        }
        body.light-mode .btn-print {
            background: #0B326D;
            color: white;
        }
        body.light-mode .btn-print:hover {
            background: #08234d;
        }

        /* Dark Mode */
        body.dark-mode {
            background: #F5F6F5;
        }
        body.dark-mode .header h2 {
            color: #0B326D;
        }
        body.dark-mode .total .amount {
            color: #0B326D;
        }
        body.dark-mode .footer strong {
            color: #0B326D;
        }
        body.dark-mode .btn-print {
            background: #F39C16;
            color: white;
        }
        body.dark-mode .btn-print:hover {
            background: #E67E22;
        }

        @media print {
            body.dark-mode {
                background: white !important;
            }
            body.dark-mode .kwitansi {
                background: white !important;
            }
            body.dark-mode .header h2,
            body.dark-mode .total .amount,
            body.dark-mode .footer strong {
                color: #0B326D !important;
            }
            body.dark-mode .info-label,
            body.dark-mode .header p,
            body.dark-mode .total .label,
            body.dark-mode .footer {
                color: #64748B !important;
            }
            body.dark-mode .info-value {
                color: #1E293B !important;
            }
            body.dark-mode .total,
            body.dark-mode .footer {
                background: #F8FAFC !important;
                border-color: #e2e8f0 !important;
            }
        }
    </style>
</head>
<body class="dark-mode" id="kwitansiBody">
    <div class="kwitansi-container">
        <div class="kwitansi">
            <div class="header">
                <img src="{{ asset('images/logo_ajn.png') }}" alt="Logo AJ NETWORK" class="logo" style="width: 100px; height: auto; margin-bottom: 12px;">
                <h2>AJ NETWORK</h2>
                <p>NET FIBER</p>
                <div class="alamat">Jl. Bougenville 10, Pasar Kemis, Tangerang</div>
            </div>
            
            <div class="content">
                <div class="info-row">
                    <span class="info-label">No. Kwitansi</span>
                    <span class="info-value">INV/{{ $pembayaran->id_pembayaran }}/{{ date('Ymd') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pelanggan</span>
                    <span class="info-value">{{ $pembayaran->pelanggan->nama }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $pembayaran->pelanggan->alamat }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Periode</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->locale('id')->isoFormat('MMMM YYYY') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket</span>
                    <span class="info-value">{{ $pembayaran->pelanggan->paket->nama_paket ?? '-' }}</span>
                </div>
                
                <div class="total">
                    <div class="amount">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                    <div class="label">Total Pembayaran</div>
                </div>
            </div>
            
            <div class="footer">
                <p>Terima kasih atas pembayaran Anda</p>
                <p style="margin-top: 4px;">Hormat kami,</p>
                <p><strong>AJ NETWORK NET FIBER</strong></p>
            </div>
        </div>
        
        <button class="btn-print" onclick="window.print()">Cetak Kwitansi</button>
    </div>
    <script>
        const theme = localStorage.getItem('theme') || 'dark';
        document.getElementById('kwitansiBody').className = theme === 'light' ? 'light-mode' : 'dark-mode';
    </script>
</body>
</html>