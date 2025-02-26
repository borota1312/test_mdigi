@extends('layout.main')
@section('content')
    <h2>Tambah Via Pembayaran</h2>
    <div class="row card">
        <div class="card-body">
            <form action="{{ route('via_pembayaran.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="nama" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="col-12">
                    <a class="btn btn-outline-secondary" type="button" href="{{ route('via_pembayaran') }}">
                        Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
