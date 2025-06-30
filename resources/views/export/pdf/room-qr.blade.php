<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>QR Code Center</title>
    <style>
        body {
            margin: 0;
            padding: 200px 0;
            display: flex;
            justify-content: center;
            /* Pusat horizontal */
            align-items: center;
            /* Pusat vertikal */
            page-break-after: always;
            /* Pastikan setiap QR di halaman baru */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        .qr-container {
            text-align: center;
            align-content: center
        }

        img {
            border: 1px solid #c7e8ff;
            border-radius: 12px;
            padding: 10px;
            width: 450px;
            height: 450px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 20px 0;
        }

        .qr-description {
            font-size: 20px;
            color: #7f8c8d;
            margin: 20px 0 0 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>{{ $name }}</h1>
    <div class="qr-container">
        <img src="data:image/png;base64,{{ $qrCode }}">
    </div>
    <p class="qr-description">Scan QR untuk melihat daftar barang.</p>

</body>

</html>
