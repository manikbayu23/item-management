<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Asset List</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .barcode-page {
            width: 100%;
            text-align: center;
            page-break-inside: avoid;
            break-inside: avoid;
            display: block;
            padding: 2.5mm 1mm;
        }

        .barcode-label {
            font-family: monospace;
            font-size: 10px;
            letter-spacing: 1px;
            text-align: center;
            margin-top: 5px;
            line-height: 1;
        }
    </style>
</head>

<body>

    @foreach ($assets as $asset)
        <div class="barcode-page">
            <img src="data:image/png;base64,{{ Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($asset['code'], 'C128') }}"
                style="width: 80%; height: auto; text-align: center;">
            <div class="barcode-label">
                {{ $asset['code'] }}
            </div>
        </div>
    @endforeach
</body>

</html>
