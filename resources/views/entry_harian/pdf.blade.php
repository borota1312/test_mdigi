<!DOCTYPE html>
<html lang="en">

<head>
    <title>Export Data Entry Harian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead,
        tfoot {
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        tr.border-0 th {
            border: none !important;
        }
    </style>
</head>

<body>
    <table class="table">
        <thead style="text-align: center;">
            <tr class="border-0">
                <th colspan="8">
                    LAPORAN PENDAPATAN ASLI DAERAH {{ $via_bayar }} TAHUN {{ $tahun }}<br>s/d Tanggal :
                    {{ $tanggal }}
                </th>
            </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Nama Rekening</th>
                <th rowspan="2">Target(Rp)</th>
                <th colspan="3">Realisasi</th>
                <th rowspan="2">%</th>
            </tr>
            <tr>
                <th>s/d Bulan Lalu</th>
                <th>Bulan Ini</th>
                <th>s/d Bulan Ini</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8 (7/4)</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @foreach ($masters as $key => $master)
                <tr>
                    <td width="auto">{{ $key + 1 }}</td>
                    <td width="auto">{{ $master['kode_rekening'] }}</td>
                    <td width="auto">{{ $master['nama_rekening'] }}</td>
                    <td width="auto">{{ $master['target'] }}</td>
                    <td width="auto">{{ $master['sd_bulan_lalu'] }}</td>
                    <td width="auto">{{ $master['bulan_ini'] }}</td>
                    <td width="auto">{{ $master['sd_bulan_ini'] }}</td>
                    <td width="auto">{{ $master['persen'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="text-align: center;">
            <tr>
                <td width="auto" colspan="3">TOTAL</td>
                <td width="auto">{{ $total_target }}</td>
                <td width="auto">{{ $total_sd_bulan_lalu }}</td>
                <td width="auto">{{ $total_bulan_ini }}</td>
                <td width="auto">{{ $total_sd_bulan_ini }}</td>
                <td width="auto">{{ $total_persen }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
