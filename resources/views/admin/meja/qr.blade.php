<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Meja {{ $meja->nomor_meja }}</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        h1 { font-size: 2.5rem; }
        p { font-size: 1.2rem; }
        .qr-container { padding: 20px; display: inline-block; }
        @media print {
            body { margin-top: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h1>Meja {{ $meja->nomor_meja }}</h1>

        <div style="padding: 10px;">
            {!! QrCode::size(300)->generate($url) !!}
        </div>

        <p>Scan QR Code ini untuk memesan.</p>
        <button class="no-print" onclick="window.print()">Cetak Halaman Ini</button>
    </div>
</body>
</html>