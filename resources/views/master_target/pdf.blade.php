<!DOCTYPE html>
<html lang="en">

<head>
    <title>Export Master Data Target</title>
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
                <th colspan="5">Master Data Target Tahun {{ $tahun }} yang Berlaku<br>s/d Tanggal
                    {{ $tanggal }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Kode Rekening</th>
                <th>Nama Rekening</th>
                <th>Target(Rp)</th>
                <th>Masa Berlaku</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @foreach ($masters as $key => $master)
                <tr>
                    <td width="auto">{{ $key + 1 }}</td>
                    <td width="auto">{{ $master->rekening->kode_rekening }}</td>
                    <td width="auto">{{ $master->rekening->nama_rekening }}</td>
                    <td width="auto">{{ number_format($master->target, 0, ',', '.') }}</td>
                    <td width="auto">{{ $master->berlaku_start }} sd {{ $master->berlaku_end }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
