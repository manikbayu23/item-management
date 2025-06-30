<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $room->name }}</title>
</head>

<body>
    <table>
        <tr>
            <td colspan="12" align="center">
                <strong>PERUSAHAAN UMUM DAERAH AIR MINUM</strong>
            </td>
        </tr>

        <tr>
            <td colspan="12" align="center">
                <strong>PANCA MAHOTTAMA</strong>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                <strong>KABUPATEN KLUNGKUNG</strong>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                Jalan I Gusti Ngurah Rai
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                No Telp. (0366) 21336, fax. (0366) 22166
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                Website: www.pdamklungkung.co.id
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                <strong>S E M A R A P U R A 80711</strong>
            </td>
        </tr>

        <tr>
            <td colspan="12" align="center">&nbsp;</td>
        </tr>

        <tr>
            <td colspan="12" align="center"><strong>KARTU INVENTARIS RUANGAN</strong></td>
        </tr>
        <tr>
            <td colspan="12" align="center"><strong>PERUMDA AIR MINUM PANCA MAHOTTAMA KABUPATEN KLUNGKUNG</strong>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center"><strong>TAHUN {{ Carbon\Carbon::now()->year }}</strong></td>
        </tr>
        <tr>
            <td colspan="12" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="12">RUANGAN : {{ $room->name }}</td>
        </tr>
        <tr>
            <td colspan="12" align="center">&nbsp;</td>
        </tr>
        @php
            $style = 'border:1px solid grey; background-color: #8DB4E2; ';
            $borderStyle = 'border:1px solid grey;';
        @endphp

        <tr style="background-color: #ccc; font-weight: bold;">
            <td style="{{ $style }}">No</td>
            <td style="{{ $style }}" width="100px">Kode Barang</td>
            <td style="{{ $style }}" width="200px">Nama Barang</td>
            <td style="{{ $style }}">Merk</td>
            <td style="{{ $style }}">Satuan</td>
            <td style="{{ $style }}">Total</td>
            <td style="{{ $style }}">Baik</td>
            <td style="{{ $style }}">Rusak</td>
            <td style="{{ $style }}">Hilang </td>
            <td style="{{ $style }}">Dipinjam </td>
            <td style="{{ $style }}">Tersedia </td>
            <td style="{{ $style }}" width="250px">Keterangan</td>
        </tr>

        @foreach ($room->roomitems as $index => $row)
            @php
                $total = 0;
                $totalBaik = 0;
                $toalRusak = 0;
                $totalHilang = 0;
                $totalPinjam = 0;

                foreach ($row->conditions as $key => $condition) {
                    if ($condition->condition == 'baik') {
                        $totalBaik = $totalBaik + $condition->qty;
                    } elseif ($condition->condition == 'rusak') {
                        $toalRusak = $toalRusak + $condition->qty;
                    } elseif ($condition->condition == 'hilang') {
                        $totalHilang = $totalHilang + $condition->qty;
                    }
                    $total = $total + $condition->qty;
                }

                foreach ($row->borrowings as $key => $borrow) {
                    $totalPinjam = $totalPinjam + $borrow->qty;
                }
            @endphp
            <tr>
                <td style="{{ $borderStyle }}">{{ $index + 1 }}</td>
                <td style="{{ $borderStyle }}">{{ $row->item->code }}</td>
                <td style="{{ $borderStyle }}">{{ $row->item->name }}</td>
                <td style="{{ $borderStyle }}">{{ $row->item->brand }}</td>
                <td style="{{ $borderStyle }}">{{ $row->item->unit }}</td>
                <td style="{{ $borderStyle }}">{{ $total }}</td>
                <td style="{{ $borderStyle }}">{{ $totalBaik }}</td>
                <td style="{{ $borderStyle }}">{{ $toalRusak }}</td>
                <td style="{{ $borderStyle }}">{{ $totalHilang }}</td>
                <td style="{{ $borderStyle }}">{{ $totalPinjam }}</td>
                <td style="{{ $borderStyle }}">{{ $totalBaik - $totalPinjam }}</td>
                <td style="{{ $borderStyle }}">{{ $row->item->notes }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="12">&nbsp;</td>
        </tr>

        <tr>
            <td colspan="6" align="center">Diperiksa Oleh,</td>
            <td colspan="6" align="center">
                Semarapura, {{ Carbon\Carbon::now()->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center">Kabag Administrasi dan Keuangan</td>
            <td colspan="6" align="center">
                Dibuat Oleh,
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center">&nbsp;</td>
            <td colspan="6" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" align="center">&nbsp;</td>
            <td colspan="6" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" align="center"><u>Putu Subarta</u></td>
            <td colspan="6" align="center">
                <u>{{ $user->name }}</u>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">Disetujui Oleh,</td>
        </tr>
        <tr>
            <td colspan="12" align="center">Direktur,</td>
        </tr>
        <tr>
            <td colspan="12" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="12" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="12" align="center">
                <u>I Nyoman Renin Suyasa, S.Sos</u>
            </td>
        </tr>
    </table>

</body>
{{-- @dd('halo') --}}

</html>
