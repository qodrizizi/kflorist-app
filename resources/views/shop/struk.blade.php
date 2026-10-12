<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Resmi - {{ $orderCode }} - RUANGBONSAI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            line-height: 1.5;
            padding: 20px 0;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Top Action Bar (Screen Only) */
        .top-action-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            background: #ffffff;
            padding: 14px 24px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #047857, #059669);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        /* Main Receipt Sheet (Full Page A4 Proportion) */
        .receipt-container {
            max-width: 800px;
            min-height: 1050px;
            margin: 0 auto;
            background: #ffffff;
            padding: 48px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Header */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px dashed #e2e8f0;
            margin-bottom: 28px;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 12px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 900;
            color: #065f46;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            margin-top: 2px;
        }

        .brand-address {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
            line-height: 1.4;
        }

        .receipt-title-box {
            text-align: right;
        }

        .receipt-badge {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #bbf7d0;
            margin-bottom: 6px;
        }

        .receipt-no {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .receipt-date {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Metadata Grid */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background: #f8fafc;
            padding: 20px 24px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            margin-bottom: 28px;
        }

        .meta-item h4 {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .meta-item p {
            font-size: 13px;
            color: #1e293b;
            font-weight: 600;
        }

        .meta-item .address-text {
            font-size: 12px;
            color: #475569;
            line-height: 1.4;
            font-weight: 500;
        }

        /* Items Table */
        .table-container {
            margin-bottom: 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #0f172a;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 14px;
        }

        th:first-child { border-radius: 8px 0 0 8px; }
        th:last-child { border-radius: 0 8px 8px 0; text-align: right; }

        td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            color: #334155;
            vertical-align: middle;
        }

        td:last-child {
            text-align: right;
            font-weight: 700;
            color: #0f172a;
        }

        .item-row:hover td {
            background-color: #f8fafc;
        }

        .product-name {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .product-cat {
            font-size: 11px;
            color: #64748b;
        }

        /* Summary Calculations */
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }

        .summary-box {
            width: 320px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #475569;
            margin-bottom: 8px;
        }

        .summary-row.total-row {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px dashed #cbd5e1;
            font-size: 16px;
            font-weight: 900;
            color: #065f46;
        }

        /* Stamp & Verification */
        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 24px;
            border-top: 2px dashed #e2e8f0;
        }

        .terms-box {
            max-width: 440px;
        }

        .terms-title {
            font-size: 11px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .terms-text {
            font-size: 11px;
            color: #64748b;
            line-height: 1.5;
        }

        .signature-box {
            text-align: center;
            position: relative;
            min-width: 180px;
        }

        /* LUNAS Stamp Watermark */
        .stamp-lunas {
            display: inline-block;
            border: 3px solid #16a34a;
            color: #16a34a;
            font-weight: 900;
            font-size: 18px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 8px;
            transform: rotate(-10deg);
            margin-bottom: 12px;
            opacity: 0.9;
        }

        .signature-name {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            border-top: 1px solid #94a3b8;
            padding-top: 4px;
        }

        .signature-title {
            font-size: 10px;
            color: #64748b;
        }

        .footer-section {
            margin-top: auto;
            width: 100%;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .no-print, .top-action-bar {
                display: none !important;
            }

            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
                min-height: calc(100vh - 30mm) !important;
            }

            .footer-section {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                border-top: 1px dashed #cbd5e1 !important;
                padding-top: 10px !important;
            }

            @page {
                size: A4;
                margin: 15mm 20mm;
            }
        }
    </style>
</head>
<body>

    <!-- TOP ACTION BAR (ONLY ON SCREEN) -->
    <div class="top-action-bar no-print">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-invoice text-emerald-600" style="color: #10b981; font-size: 18px;"></i>
            <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Struk Resmi Transaksi RUANGBONSAI</span>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('shop.pesanan') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
            </a>
            <a href="{{ route('shop.pesanan.struk', $order->id) }}" onclick="downloadStrukPdf(event, this.href)" class="btn btn-primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <!-- MAIN RECEIPT DOCUMENT -->
    <div class="receipt-container" id="receipt-sheet">

        <!-- HEADER -->
        <div class="header-section">
            <div class="brand-box">
                <img src="{{ asset('images/logo.png') }}" alt="Logo RUANGBONSAI" class="brand-logo">
                <div>
                    <h1 class="brand-title">RUANGBONSAI</h1>
                    <p class="brand-subtitle">Official Store & Nursery Bonsai Indonesia</p>
                    <p class="brand-address">
                        Jl. Flora Raya No. 88, Sentra Bonsai Lestari | Telp: +62 812-3456-7890<br>
                        Website: ruangbonsai.com | Email: billing@ruangbonsai.com
                    </p>
                </div>
            </div>

            <div class="receipt-title-box">
                <span class="receipt-badge">Official Receipt</span>
                <div class="receipt-no mono">INV/{{ $order->created_at->format('Ymd') }}/{{ $orderCode }}</div>
                <div class="receipt-date">{{ $order->created_at->translatedFormat('d F Y - H:i') }} WIB</div>
            </div>
        </div>

        <!-- METADATA INFORMATION -->
        <div class="meta-grid">
            <div class="meta-item">
                <h4>Informasi Pelanggan</h4>
                <p>{{ $order->user->name ?? Auth::user()->name }}</p>
                <p style="font-size: 12px; color: #64748b; font-weight: 500;">{{ $order->user->email ?? Auth::user()->email }}</p>
                <div style="margin-top: 8px;">
                    <h4>Alamat Pengiriman</h4>
                    <p class="address-text">{{ $order->alamat_pengiriman }}</p>
                </div>
            </div>

            <div class="meta-item">
                <h4>Metode Pembayaran</h4>
                <p style="text-transform: uppercase; color: #065f46;">
                    <i class="fas fa-wallet" style="margin-right: 4px;"></i> {{ $order->metode_pembayaran ?: 'Midtrans Gateway' }}
                </p>
                <p style="font-size: 11px; color: #64748b; margin-top: 4px;">
                    Order ID: <span class="mono">{{ $order->midtrans_order_id ?: ($orderCode . '-' . $order->created_at->timestamp) }}</span>
                </p>

                <div style="margin-top: 12px;">
                    <h4>Status Pelunasan</h4>
                    <p style="color: #16a34a; font-weight: 800;">
                        <i class="fas fa-check-circle"></i> LUNAS (Sudah Dibayar)
                    </p>
                    <p style="font-size: 11px; color: #64748b;">
                        Diverifikasi pada: {{ $order->updated_at->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- PRODUCTS TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>Deskripsi Produk</th>
                        <th style="text-align: center; width: 80px;">Qty</th>
                        <th style="text-align: right; width: 140px;">Harga Satuan</th>
                        <th style="text-align: right; width: 140px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $idx = 1; @endphp
                    @foreach($allOrders ?? [$order] as $item)
                        <tr class="item-row">
                            <td class="mono" style="color: #94a3b8;">{{ sprintf('%02d', $idx++) }}</td>
                            <td>
                                <div class="product-name">{{ $item->bonsai ? $item->bonsai->name : 'Pohon Bonsai' }}</div>
                                <div class="product-cat">
                                    {{ $item->bonsai && $item->bonsai->category ? $item->bonsai->category->name : 'Koleksi Bonsai Pilihan' }}
                                    @if($item->catatan)
                                        <span style="font-style: italic; color: #94a3b8;"> — "{{ $item->catatan }}"</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;" class="mono font-bold">{{ $item->quantity }}</td>
                            <td style="text-align: right;" class="mono">
                                Rp {{ number_format($item->bonsai ? $item->bonsai->current_value : ($item->total_price / max(1, $item->quantity)), 0, ',', '.') }}
                            </td>
                            <td style="text-align: right;" class="mono">
                                Rp {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- CLOSURE SECTION: SIGNATURE & SUMMARY SEJAJAR -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; gap: 24px;">
            <!-- KIRI: CAP LUNAS & TANDA TANGAN KASIR -->
            <div class="signature-box" style="text-align: left; min-width: 200px;">
                <div class="stamp-lunas">
                    LUNAS
                </div>
                <div style="height: 30px;"></div>
                <div class="signature-name" style="width: 180px;">Bagian Keuangan & Kasir</div>
                <div class="signature-title">RUANGBONSAI Official Store</div>
            </div>

            <!-- KANAN: RINGKASAN TOTAL DIBAYAR -->
            <div class="summary-box" style="width: 320px;">
                <div class="summary-row">
                    <span>Subtotal Produk:</span>
                    <span class="mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkos Kirim (Packing Kayu):</span>
                    <span class="mono" style="color: #16a34a; font-weight: 700;">Rp 0 (Gratis)</span>
                </div>
                <div class="summary-row">
                    <span>Biaya Layanan / Penanganan:</span>
                    <span class="mono">Rp 0</span>
                </div>
                <div class="summary-row total-row">
                    <span>TOTAL DIBAYAR:</span>
                    <span class="mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- FOOTER: CATATAN & GARANSI PEMBELIAN DI PALING BAWAH -->
        <div class="footer-section" style="border-top: 1px dashed #e2e8f0; padding-top: 20px;">
            <div class="terms-box" style="max-width: 100%;">
                <div class="terms-title">CATATAN & GARANSI PEMBELIAN:</div>
                <p class="terms-text">
                    1. Struk ini adalah bukti pembayaran dan kepemilikan yang sah dari RUANGBONSAI.<br>
                    2. Seluruh tanaman dikemas menggunakan peti kayu pengaman khusus dengan garansi hidup sampai ke alamat tujuan.<br>
                    3. Silakan hubungi layanan pelanggan di WhatsApp <strong>+62 812-3456-7890</strong> jika memerlukan bantuan lebih lanjut.
                </p>
                <p style="margin-top: 10px; font-size: 11px; color: #94a3b8; text-align: center;">
                    Terima kasih telah berbelanja di RUANGBONSAI Official Store • Dokumen ini diterbitkan secara resmi oleh sistem komputerisasi.
                </p>
            </div>
        </div>

    </div>

    <script>
        function downloadStrukPdf(event, url) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            let iframe = document.getElementById('hidden-download-frame');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'hidden-download-frame';
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
            }
            iframe.src = url;
        }
    </script>
</body>
</html>
