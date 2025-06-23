<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Permintaan Peminjaman Barang</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f1f1; margin: 0; padding: 0; color: #333;">
    <div
        style="max-width: 650px; margin: 30px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);">

        <!-- Header -->
        <div style="text-align: center; padding: 20px; border-bottom: 2px solid #f1f1f1;">
            {{-- <img src="http://127.0.0.1:8000/assets/img/panca-mahottama.png" alt="Logo Perusahaan"
                style="max-width: 100px; margin-bottom: 10px;"> --}}
            <h2 style="margin: 0; font-size: 22px; color: #000;">Permintaan Peminjaman Barang</h2>
        </div>

        <!-- Content -->
        <div style="padding: 25px 30px;">
            <p style="margin-bottom: 20px; font-size: 15px; color: #000;">Halo, berikut adalah detail permintaan
                peminjaman yang perlu
                ditinjau:</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px; border-collapse: collapse;">
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555; width: 40%;">No Peminjaman</td>
                    <td style="padding: 10px 8px;">{{ $data->borrow_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Nama Peminjam</td>
                    <td style="padding: 10px 8px;">{{ $user->name }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Divisi</td>
                    <td style="padding: 10px 8px;">{{ $user->division->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Ruangan Asal Barang</td>
                    <td style="padding: 10px 8px;">{{ $roomItem->room->name }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Kode Barang</td>
                    <td style="padding: 10px 8px;">{{ $roomItem->item->code }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Nama Barang</td>
                    <td style="padding: 10px 8px;">{{ $roomItem->item->name }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Jumlah Unit</td>
                    <td style="padding: 10px 8px;">{{ $data->qty }} {{ $roomItem->item->unit }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Tanggal Mulai</td>
                    <td style="padding: 10px 8px;">{{ \Carbon\Carbon::parse($data->start_date)->format('d-m-Y') }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Tanggal Selesai</td>
                    <td style="padding: 10px 8px;">{{ \Carbon\Carbon::parse($data->end_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Keterangan</td>
                    <td style="padding: 10px 8px;">{{ $data->notes }}</td>
                </tr>
            </table>

            <!-- Button -->
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ url('/admin/borrow-items') }}"
                    style="display:inline-block; padding:7px 14px; background-color:#007BFF; color:white; text-decoration:none; border-radius:4px; font-size:13px;">Buka
                    Sistem untuk Approve</a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f1f1; color: #777; text-align: center; font-size: 13px; padding: 15px;">
            Email ini dikirim otomatis oleh sistem.<br>
            © {{ date('Y') }} Inventaris Panca Mahotama
        </div>
    </div>
    {{-- @dd(1) --}}
</body>

</html>
