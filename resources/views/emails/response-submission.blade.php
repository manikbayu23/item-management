<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Status Permintaan Peminjaman</title>
    <style>
        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #f1f1f1;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .content {
            padding: 25px 30px;
        }

        .content p {
            font-size: 15px;
            margin-bottom: 20px;
        }

        .status {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .status.approved {
            color: #155724;
            border-left: 6px solid #28a745;
            background-color: #d4edda;

        }

        .status.rejected {
            color: #721c24;
            border-left: 6px solid #dc3545;
            background-color: #f8d7da;
        }

        .status.in_progress {
            color: #0c5460;
            border-left: 6px solid #17a2b8;
            background-color: #d1ecf1;

        }

        .status.cancel {
            color: #383d41;
            border-left: 6px solid #6c757d;
            background-color: #e2e3e5;

        }

        .status.completed {
            color: #155724;
            border-left: 6px solid #20c997;
            background-color: #d4edda;

        }

        .note {
            background-color: #f1f1f1;
            border-left: 4px solid #007bff;
            padding: 12px 15px;
            margin-top: 10px;
            border-radius: 5px;
            font-style: italic;
            color: #555;
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
            <h2 style="margin: 0; font-size: 22px; color: #000;">Status Permintaan Peminjaman</h2>
        </div>
        <div class="content">
            <div class="status {{ $data->status }}">
                Permintaan peminjaman Anda dengan nomor <strong>{{ $data->borrow_number }}</strong> telah
                <strong>
                    @if ($data->status == 'approved')
                        DISETUJUI
                    @elseif ($data->status == 'rejected')
                        DITOLAK
                    @elseif ($data->status == 'in_progress')
                        DIAMBIL / DIPINJAM
                    @elseif ($data->status == 'cancel')
                        DIBATALKAN
                    @elseif ($data->status == 'completed')
                        SELESAI
                    @else
                        STATUS TIDAK DIKETAHUI
                    @endif
                </strong>
            </div>
            @if ($data->status == 'approved')
                <p>Permintaan Anda telah <strong>disetujui</strong>. Silakan ambil barang sesuai dengan jadwal dan
                    ruangan yang telah ditentukan. Pastikan kondisi barang tetap baik selama peminjaman.</p>
            @elseif ($data->status == 'in_progress')
                <p>Barang telah <strong>dipinjam</strong>. Harap digunakan dengan baik dan sesuai keperluan. Jangan
                    lupa untuk mengembalikan barang tepat waktu dan dalam kondisi yang baik.</p>
            @elseif ($data->status == 'completed')
                <p>Proses peminjaman telah <strong>selesai</strong>. Terima kasih telah menjaga barang dengan baik.
                    Data peminjaman ini akan tersimpan sebagai arsip.</p>
            @elseif ($data->status == 'rejected')
                <p>Permintaan Anda <strong>ditolak</strong>. Silakan hubungi admin atau bagian terkait untuk informasi
                    lebih lanjut mengenai alasan penolakan.</p>
            @elseif ($data->status == 'cancel')
                <p>Permintaan Anda telah <strong>dibatalkan</strong>. Jika ini terjadi karena kesalahan, silakan
                    ajukan ulang atau hubungi admin untuk klarifikasi.</p>
            @endif

            @if (!empty($data->admin_notes))
                <div class="note">
                    <strong>Keterangan Approval:</strong><br>
                    {{ $data->admin_notes }}
                </div>
            @endif
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh sistem.<br>
            © {{ date('Y') }} Inventaris Panca Mahotama
        </div>
    </div>
</body>

</html>
