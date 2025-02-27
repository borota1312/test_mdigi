<table class="table table-bordered">
    <thead style="text-align: center;">
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; height: 50px;">
                LAPORAN PENDAPATAN ASLI DAERAH {{ $via_bayar }} TAHUN {{ $tahun }}<br>s/d Tanggal :
                {{ $tanggal }}
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 50px;text-align: center;">No</th>
            <th rowspan="2" style="width: 150px;text-align: center;">Kode Rekening</th>
            <th rowspan="2" style="width: 250px;text-align: center;">Nama Rekening</th>
            <th rowspan="2" style="width: 150px;text-align: center;">Target(Rp)</th>
            <th colspan="3" style="width: 450px;text-align: center;">Realisasi</th>
            <th rowspan="2" style="width: 100px;text-align: center;">%</th>
        </tr>
        <tr>
            <th style="width: 150px;text-align: center;">s/d Bulan Lalu</th>
            <th style="width: 150px;text-align: center;">Bulan Ini</th>
            <th style="width: 150px;text-align: center;">s/d Bulan Ini</th>
        </tr>
        <tr>
            <th style="width: 50px;text-align: center;">1</th>
            <th style="width: 150px;text-align: center;">2</th>
            <th style="width: 250px;text-align: center;">3</th>
            <th style="width: 150px;text-align: center;">4</th>
            <th style="width: 150px;text-align: center;">5</th>
            <th style="width: 150px;text-align: center;">6</th>
            <th style="width: 150px;text-align: center;">7</th>
            <th style="width: 100px;text-align: center;">8 (7/4)</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($masters as $key => $master)
            <tr>
                <td style="width: 50px;text-align: left;">{{ $key + 1 }}</td>
                <td style="width: 150px;text-align: left;">{{ $master['kode_rekening'] }}</td>
                <td style="width: 250px;text-align: center;">{{ $master['nama_rekening'] }}</td>
                <td style="width: 150px;text-align: center;">{{ $master['target'] }}</td>
                <td style="width: 150px;text-align: center;">{{ $master['sd_bulan_lalu'] }}</td>
                <td style="width: 150px;text-align: center;">{{ $master['bulan_ini'] }}</td>
                <td style="width: 150px;text-align: center;">{{ $master['sd_bulan_ini'] }}</td>
                <td style="width: 100px;text-align: center;">{{ $master['persen'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot style="text-align: center;">
        <tr>
            <td colspan="3" style="width: 50px;text-align: center;">TOTAL</td>
            <td style="width: 150px;text-align: center;">{{ $total_target }}</td>
            <td style="width: 150px;text-align: center;">{{ $total_sd_bulan_lalu }}</td>
            <td style="width: 150px;text-align: center;">{{ $total_bulan_ini }}</td>
            <td style="width: 150px;text-align: center;">{{ $total_sd_bulan_ini }}</td>
            <td style="width: 100px;text-align: center;">{{ $total_persen }}</td>
        </tr>
    </tfoot>
</table>
