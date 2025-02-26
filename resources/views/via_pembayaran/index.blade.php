@extends('layout.main')
@section('content')
    <h2>Data Via Pembayaran</h2>
    <div class="row">
        <a class="btn btn-primary mb-2 mt-2 col-md-3" type="button" href="{{ route('via_pembayaran.create') }}">
            Tambah Data
        </a>
    </div>
    <div class="row card">
        <div class="card-body">
            <table id="datatable_via" class="table table-responsive">
                <thead class="text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Jenis Pembayaran</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        let rekening = [];
        const table = $("#datatable_via").DataTable({
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All Data']
            ],
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "processing": true,
            "bServerSide": true,
            "order": [
                [0, "asc"]
            ],
            "ajax": {
                url: "{{ route('via_pembayaran.datatables') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "data": "id",
                    "sortable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        rekening[row.id] = row;
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    "targets": 1,
                    "data": "nama",
                    "className": "text-center",
                    "sortable": true,
                    "render": function(data, type, row, meta) {
                        return data;

                    }
                },
                {
                    "targets": 2,
                    "data": "uuid",
                    "sortable": false,
                    "render": function(data, type, row, meta) {
                        let urlEdit =
                            "{{ route('via_pembayaran.edit', ['uuid' => ':uuid']) }}".replace(':uuid',
                                data);
                        return `
                              <a class="btn btn-warning" href="${urlEdit}">Edit</a>
                              <a class="btn btn-danger" onclick="hapus(${row.id})">Hapus</a>
                                `;
                    }
                }
            ]
        });

        function hapus(id) {
            Swal.fire({
                title: "Apakah yakin menghapus data ini?",
                text: "Jika data terhapus, data akan hilang selamanya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                const url = "{{ route('via_pembayaran.destroy') }}"
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        type: 'delete',
                        dataType: "JSON",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response, textStatus, xhr) {
                            if (xhr.status === 204) {
                                Swal.fire({
                                    title: "Berhasil",
                                    text: "Data berhasil dihapus.",
                                    icon: "success"
                                });
                                table.ajax.reload(null, false);
                            }
                        },
                        error: function(xhr) {
                            let message = "Terjadi kesalahan.";

                            if (xhr.status === 404) {
                                message = "Data tidak ditemukan.";
                            } else if (xhr.status === 400) {
                                message = "Gagal menghapus data.";
                            }

                            Swal.fire({
                                title: "Gagal",
                                text: message,
                                icon: "error"
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Berhasil Membatalkan.",
                        icon: "success"
                    });
                }
            });
        };
    </script>
@endsection
