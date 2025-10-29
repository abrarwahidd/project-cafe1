<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan {{ $pesanan->kode_pesanan }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            width: 300px; /* Lebar struk thermal printer */
            margin: 0 auto;
        }
        .container {
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .header p {
            margin: 0;
            font-size: 10px;
        }
        .info {
            margin-bottom: 10px;
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        .info p {
            margin: 0;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px 0;
        }
        .items th, .items td {
            border-bottom: 1px dashed #333;
        }
        .items .item-name {
            text-align: left;
        }
        .items .qty, .items .price {
            text-align: right;
        }
        .total {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kedai Kopi Apik</h1>
            <p>Jalan Kafe No. 123, Kota Majalengka</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <div class="info">
            <p>Kode Pesanan: {{ $pesanan->kode_pesanan }}</p>
            <p>Tanggal: {{ $pesanan->created_at->format('d/m/Y H:i') }}</p>
            <p>Meja: {{ $pesanan->meja->nomor_meja }}</p>
            <p>Kasir: (Nama Kasir jika ada)</p>
            <p>Status: LUNAS</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th class="item-name">Menu</th>
                    <th class="qty">Qty</th>
                    <th class="price">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detailPesanans as $detail)
                    <tr>
                        <td class="item-name">{{ $detail->menu->nama }}</td>
                        <td class="qty">{{ $detail->jumlah }}</td>
                        <td class="price">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>-- Struk Ini Dicetak Otomatis oleh Sistem --</p>
        </div>
    </div>
</body>
</html>