<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pengingat Pengembalian Barang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            padding: 25px;
            border-bottom: 2px solid #f1f1f1;
            color: white;
        }

        .header img {
            max-width: 90px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 10px 0 0;
            font-size: 22px;
        }

        .content {
            padding: 25px 30px;
        }

        .content p {
            font-size: 15px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .reminder-box {
            background-color: #fff3cd;
            color: #856404;
            border-left: 6px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .footer {
            background-color: #f1f1f1;
            color: #777;
            text-align: center;
            font-size: 13px;
            padding: 15px;
        }
    </style>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f1f1; margin: 0; padding: 0; color: #333;">
    <div class="container">
        <div class="header">
            <img src="https://drive.google.com/uc?export=view&id=1BDCcJO0kMfIR35TUBXl2BppY0BVFNnok" alt="Logo Perusahaan"
                style="max-width: 100px; margin-bottom: 10px;">
            <h2 style="margin: 0; font-size: 22px; color: #000;">Pengingat Pengembalian Barang</h2>
        </div>
        <div class="content" style="color: #333">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <div class="reminder-box" style="color: #333">
                Ini adalah pengingat bahwa barang yang Anda pinjam dengan nomor
                <strong>{{ $data->borrow_number }}</strong> sudah melewati batas waktu peminjaman pada
                <strong>{{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</strong>. Dimohonkan untuk segera
                dikembalikan.
            </div>
            <p>Mohon pastikan barang dikembalikan dalam kondisi baik dan lengkap.</p>
            <p>Jika Anda mengalami kendala atau membutuhkan perpanjangan waktu, silakan hubungi bagian terkait
                secepatnya.</p>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh sistem.<br>
            © {{ date('Y') }} Inventaris Panca Mahotama
        </div>
    </div>
</body>

</html>
