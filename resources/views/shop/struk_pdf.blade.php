<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Struk Resmi - {{ $orderCode }}</title>
    <style>
        @page {
            margin: 25px 30px 105px 30px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
            padding: 0;
            margin: 0;
        }

        .mono {
            font-family: 'Courier New', Courier, monospace;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .brand-title {
            font-size: 20px;
            font-weight: bold;
            color: #065f46;
            margin: 0 0 2px 0;
        }

        .brand-sub {
            font-size: 9px;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .brand-address {
            font-size: 9px;
            color: #64748b;
            line-height: 1.3;
        }

        .receipt-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 10px;
            border: 1px solid #bbf7d0;
            margin-bottom: 4px;
        }

        .receipt-no {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        .receipt-date {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Meta Box */
        .meta-table {
            margin-top: 15px;
            margin-bottom: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .meta-table td {
            padding: 10px 14px;
            vertical-align: top;
            width: 50%;
        }

        .meta-title {
            font-size: 8.5px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
        }

        .meta-desc {
            font-size: 9.5px;
            color: #475569;
            line-height: 1.3;
        }

        /* Products Table */
        .items-table {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .items-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
        }

        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            color: #334155;
        }

        .product-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 10.5px;
        }

        .product-cat {
            font-size: 8.5px;
            color: #64748b;
        }

        /* Transaction Closure Table (Signature & Summary) */
        .closure-table {
            margin-top: 12px;
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .summary-table td {
            padding: 6px 12px;
            font-size: 9.5px;
            color: #475569;
        }

        .summary-table .total-row td {
            border-top: 1px dashed #cbd5e1;
            padding-top: 9px;
            padding-bottom: 9px;
            font-size: 12px;
            font-weight: bold;
            color: #065f46;
        }

        /* Stamp & Signature (Non-footer) */
        .stamp-lunas {
            display: inline-block;
            border: 2px solid #16a34a;
            color: #16a34a;
            font-weight: bold;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .signature-box {
            text-align: left;
            width: 220px;
        }

        .signature-space {
            height: 25px;
        }

        .signature-name {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            border-top: 1px solid #94a3b8;
            padding-top: 4px;
            width: 180px;
        }

        .signature-title {
            font-size: 8.5px;
            color: #64748b;
        }

        /* Footer (Catatan dan Garansi) - Menempel di paling bawah kertas */
        .footer-section {
            position: fixed;
            bottom: -85px;
            left: 0;
            right: 0;
            width: 100%;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
        }

        .terms-title {
            font-size: 9px;
            font-weight: bold;
            color: #334155;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .terms-text {
            font-size: 8.5px;
            color: #64748b;
            line-height: 1.45;
        }

        .footer-closing {
            margin-top: 10px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- HEADER (TANPA GARIS HIJAU DI ATAS) -->
    <table class="header-table">
        <tr>
            <td style="width: 55px;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 48px; height: 48px; object-fit: contain;">
                @endif
            </td>
            <td>
                <h1 class="brand-title">RUANGBONSAI</h1>
                <div class="brand-sub">Official Store & Nursery Bonsai Indonesia</div>
                <div class="brand-address">
                    Jl. Flora Raya No. 88, Sentra Bonsai Lestari | Telp: +62 812-3456-7890<br>
                    Website: ruangbonsai.com | Email: billing@ruangbonsai.com
                </div>
            </td>
            <td style="text-align: right; width: 220px;">
                <div class="receipt-badge">Official Receipt</div>
                <div class="receipt-no mono">INV/{{ $order->created_at->format('Ymd') }}/{{ $orderCode }}</div>
                <div class="receipt-date">{{ $order->created_at->translatedFormat('d F Y - H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    <!-- METADATA BOX -->
    <table class="meta-table">
        <tr>
            <td>
                <div class="meta-title">Informasi Pelanggan</div>
                <div class="meta-value">{{ $order->user->name ?? 'Pelanggan RUANGBONSAI' }}</div>
                <div class="meta-desc">{{ $order->user->email ?? '-' }}</div>
                
                <div style="margin-top: 8px;">
                    <div class="meta-title">Alamat Pengiriman</div>
                    <div class="meta-desc">{{ $order->alamat_pengiriman }}</div>
                </div>
            </td>
            <td style="border-left: 1px solid #e2e8f0;">
                <div class="meta-title">Metode Pembayaran</div>
                <div class="meta-value" style="color: #065f46; text-transform: uppercase;">
                    {{ $order->metode_pembayaran ?: 'Midtrans Gateway' }}
                </div>
                <div class="meta-desc mono" style="font-size: 8.5px; margin-top: 2px;">
                    Order ID: {{ $order->midtrans_order_id ?: ($orderCode . '-' . $order->created_at->timestamp) }}
                </div>

                <div style="margin-top: 8px;">
                    <div class="meta-title">Status Pelunasan</div>
                    <div class="meta-value" style="color: #16a34a;">
                        LUNAS (Sudah Dibayar)
                    </div>
                    <div class="meta-desc" style="font-size: 8.5px;">
                        Diverifikasi: {{ $order->updated_at->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- PRODUCTS TABLE -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th>Deskripsi Produk</th>
                <th style="width: 40px; text-align: center;">Qty</th>
                <th style="width: 105px; text-align: right;">Harga Satuan</th>
                <th style="width: 105px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($allOrders ?? [$order] as $item)
                <tr>
                    <td style="text-align: center;" class="mono">{{ sprintf('%02d', $no++) }}</td>
                    <td>
                        <div class="product-name">{{ $item->bonsai ? $item->bonsai->name : 'Pohon Bonsai' }}</div>
                        <div class="product-cat">
                            {{ $item->bonsai && $item->bonsai->category ? $item->bonsai->category->name : 'Koleksi Bonsai Pilihan' }}
                            @if($item->catatan)
                                <span> — "{{ $item->catatan }}"</span>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;" class="mono">{{ $item->quantity }}</td>
                    <td style="text-align: right;" class="mono">
                        Rp {{ number_format($item->bonsai ? $item->bonsai->current_value : ($item->total_price / max(1, $item->quantity)), 0, ',', '.') }}
                    </td>
                    <td style="text-align: right;" class="mono" style="font-weight: bold;">
                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TRANSACTION CLOSURE: SIGNATURE & SUMMARY (SEJAJAR, BUKAN DI FOOTER) -->
    <table class="closure-table">
        <tr>
            <!-- KIRI: CAP LUNAS & TANDA TANGAN KASIR -->
            <td style="width: 48%; vertical-align: top;">
                <div class="signature-box">
                    <div class="stamp-lunas">LUNAS</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">Bagian Keuangan & Kasir</div>
                    <div class="signature-title">RUANGBONSAI Official Store</div>
                </div>
            </td>

            <!-- KANAN: RINGKASAN TOTAL PEMBAYARAN -->
            <td style="width: 52%; vertical-align: top;">
                <table class="summary-table">
                    <tr>
                        <td>Subtotal Produk:</td>
                        <td style="text-align: right;" class="mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Ongkos Kirim (Packing Kayu):</td>
                        <td style="text-align: right; color: #16a34a; font-weight: bold;" class="mono">Rp 0 (Gratis)</td>
                    </tr>
                    <tr>
                        <td>Biaya Layanan & Penanganan:</td>
                        <td style="text-align: right;" class="mono">Rp 0</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL DIBAYAR:</td>
                        <td style="text-align: right;" class="mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- FOOTER: CATATAN DAN GARANSI PEMBELIAN DI PALING BAWAH -->
    <div class="footer-section">
        <div class="terms-title">CATATAN & GARANSI PEMBELIAN:</div>
        <div class="terms-text">
            1. Struk ini adalah bukti pembayaran dan kepemilikan yang sah dari RUANGBONSAI.<br>
            2. Seluruh tanaman dikemas menggunakan peti kayu pengaman khusus dengan garansi hidup sampai ke alamat tujuan.<br>
            3. Silakan hubungi layanan pelanggan di WhatsApp <strong>+62 812-3456-7890</strong> jika memerlukan bantuan lebih lanjut.
        </div>
        <div class="footer-closing">
            Terima kasih telah berbelanja di RUANGBONSAI Official Store • Dokumen ini diterbitkan secara resmi oleh sistem komputerisasi.
        </div>
    </div>

</body>
</html>
