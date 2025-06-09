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
        }

        .qr-container {
            text-align: center;
            align-content: center
        }


        h1 {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $qrCode = SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate('https://example.com?slug=');
    @endphp
    <div class="qr-container">
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}">
    </div>
    <h1>{{ $data['name'] }}</h1>
</body>

</html>
