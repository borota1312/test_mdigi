@extends('layout.main')
@section('content')
    <h2>Edit Rekening</h2>
    <div class="row card">
        <div class="card-body">
            <form action="{{ route('rekening.update', $rekening->uuid) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="kode_rekening" class="form-label">Kode Rekening</label>
                    <input type="text" class="form-control" value="{{ $rekening->kode_rekening }}" id="kode_rekening"
                        name="kode_rekening" required>
                </div>
                <div class="col-md-6">
                    <label for="nama_rekening" class="form-label">Nama Rekening</label>
                    <input type="text" class="form-control" value="{{ $rekening->nama_rekening }}" id="nama_rekening"
                        name="nama_rekening" required>
                </div>

                <div class="col-12">
                    <a class="btn btn-outline-secondary" type="button" href="{{ route('rekening') }}">
                        Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
