@extends('layout.main')
@section('content')
    <h2>Tambah Data Entry Harian</h2>
    <div class="row card">
        <div class="card-body">
            <form action="{{ route('entry_harian.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6 mb-2">
                    <label for="rekening_id" class="form-label">Rekening</label>
                    <select id="rekening_id" class="form-select select2" name="rekening_id" required>
                        <option value="">Pilih Rekening</option>
                        @foreach ($rekenings as $rek)
                            <option value="{{ $rek->id }}">
                                {{ $rek->kode_rekening }} - {{ $rek->nama_rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="via_id" class="form-label">Via Pembayaran</label>
                    <select id="via_id" class="form-select select2" name="via_id" required>
                        <option value="">Pilih Via Pembayaran</option>
                        @foreach ($vias as $via)
                            <option value="{{ $via->id }}">
                                {{ $via->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="tanggal_setor" class="form-label">Tanggal Setor</label>
                    <input type="date" class="form-control" id="tanggal_setor" name="tanggal_setor" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar(Rp)</label>
                    <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required>
                </div>

                <div class="col-12">
                    <a class="btn btn-outline-secondary" type="button" href="{{ route('entry_harian') }}">
                        Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
