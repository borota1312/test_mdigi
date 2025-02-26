@extends('layout.main')
@section('content')
    <h2>Edit Rekening</h2>
    <div class="row card">
        <div class="card-body">
            <form action="{{ route('master_target.update', $master->uuid) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-6 mb-2">
                    <label for="rekening_id" class="form-label">Rekening</label>
                    <select id="rekening_id" class="form-select select2" name="rekening_id" required>
                        <option value="">Pilih Rekening</option>
                        @foreach ($rekenings as $rek)
                            <option value="{{ $rek->id }}" {{ $master->rekening_id == $rek->id ? 'selected' : '' }}>
                                {{ $rek->kode_rekening }} - {{ $rek->nama_rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="target" class="form-label">Target(Rp)</label>
                    <input type="number" class="form-control" id="target" name="target" value="{{ $master->target }}"
                        required>
                </div>

                <div class="row">
                    <label for="tgl_berlaku" class="form-label">Tanggal Berlaku</label>
                    <label for="berlaku_start" class="col-md-2 col-form-label">Dari</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="berlaku_start" name="berlaku_start"
                            value="{{ $master->berlaku_start }}" required>
                    </div>
                    <label for="berlaku_end" class="col-md-2 col-form-label">Sampai</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="berlaku_end" name="berlaku_end"
                            value="{{ $master->berlaku_end }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <a class="btn btn-outline-secondary" type="button" href="{{ route('master_target') }}">
                        Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
