<table>
    <thead style="text-align: center;">
        <tr>
            <th colspan="5" style="text-align: center; font-weight: bold; height: 50px;">Master Data Target Tahun
                {{ $tahun }} yang Berlaku<br> s/d Tanggal {{ $tanggal }}</th>
        </tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 150px;">Kode Rekening</th>
            <th style="width: 250px;">Nama Rekening</th>
            <th style="width: 150px;">Target(Rp)</th>
            <th style="width: 200px;">Masa Berlaku</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($masters as $key => $master)
            <tr>
                <td style="width: 50px;">{{ $key + 1 }}</td>
                <td style="width: 150px;">{{ $master->rekening->kode_rekening }}</td>
                <td style="width: 250px;">{{ $master->rekening->nama_rekening }}</td>
                <td style="width: 150px;">{{ number_format($master->target, 0, ',', '.') }}</td>
                <td style="width: 200px;">{{ $master->berlaku_start }} sd {{ $master->berlaku_end }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
