@extends('layout.main')
@section('content')
    <h2>Data Rekening</h2>
    <div class="row">
        <a class="btn btn-primary mb-2 mt-2 col-md-3" type="button" href="{{ route('master_target.create') }}">
            Tambah Data
        </a>
    </div>
    <div class="row card">
        <div class="card-body">
            <table id="datatable_target" class="table table-responsive">
                <thead class="text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kode Rekening</th>
                        <th>Nama Rekening</th>
                        <th>Target(Rp)</th>
                        <th>Masa Berlaku</th>
                        <th>#</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><input type="date" class="form-control" id="filter-tanggal"></th>
                        <th></th>
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
        const table = $("#datatable_target").DataTable({
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
                [0, "desc"]
            ],
            "ajax": {
                url: "{{ route('master_target.datatables') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}",
                        d.tanggal = $('#filter-tanggal').val()
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
                "data": "rekening.kode_rekening",
                "className": "text-center",
                "sortable": true,
                "render": function(data, type, row, meta) {
                    return data;

                }
            }, {
                "targets": 2,
                "data": "rekening.nama_rekening",
                "sortable": true,
                "render": function(data, type, row, meta) {
                    return data;
                }
            }, {
                "targets": 3,
                "data": "target",
                "className": "text-center",
                "sortable": true,
                "render": function(data, type, row, meta) {
                    return formatRupiah(data);

                }
            }, {
                "targets": 4,
                "data": "berlaku_start",
                "sortable": false,
                "render": function(data, type, row, meta) {
                    return data + ' sd ' + row.berlaku_end;
                }
            }, {
                "targets": 5,
                "data": "uuid",
                "sortable": false,
                "render": function(data, type, row, meta) {
                    let urlEdit =
                        "{{ route('master_target.edit', ['uuid' => ':uuid']) }}".replace(':uuid',
                            data);
                    return `
                              <a class="btn btn-warning" href="${urlEdit}">Edit</a>
                              <a class="btn btn-danger" onclick="hapus(${row.id})">Hapus</a>
                                `;
                }
            }]
        });

        $("#filter-tanggal").change(function() {
            filterTable();
        });

        function filterTable() {
            table.ajax.reload(null, false)
        }

        function hapus(id) {
            Swal.fire({
                title: "Apakah yakin menghapus data ini?",
                text: "Jika data terhapus, data akan hilang selamanya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                const url = "{{ route('master_target.destroy') }}"
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
