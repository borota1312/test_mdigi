@extends('layout.main')
@section('content')
    <h2>Master Data Target</h2>
    <div class="row">
        <a class="btn btn-primary mb-2 mt-2 col-md-2" type="button" href="{{ route('master_target.create') }}">
            Tambah Data
        </a>
    </div>
    <div class="row card">
        <div class="card-body">
            <div class="d-flex justify-content-end align-items-center">
                <div class="ms-2 me-2">Filter s/d Tanggal</div>
                <input type="date" id="export_tanggal" class="form-control w-auto ms-2 me-2">
                <div class="ms-2 me-2">Export</div>
                <button class="btn btn-danger me-2" onclick="exportPdf()"><i class="bi bi-file-pdf-fill"></i> PDF</button>
                <button class="btn btn-success" onclick="exportExcel()"><i class="bi bi-file-excel-fill"></i> Excel</button>
            </div>
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
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        let master = [];
        const table = $("#datatable_target").DataTable({
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, 'All Data']
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
                        d.tanggal = $('#export_tanggal').val()
                }
            },
            "columnDefs": [{
                "targets": 0,
                "data": "id",
                "sortable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    master[row.id] = row;
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "targets": 1,
                "data": "kode_rekening",
                "className": "text-center",
                "sortable": true,
                "render": function(data, type, row, meta) {
                    return data;

                }
            }, {
                "targets": 2,
                "data": "nama_rekening",
                "sortable": true,
                "className": "text-center",
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
                "className": "text-center",
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

        $("#export_tanggal").change(function() {
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

        function exportExcel() {
            let filter = $('#export_tanggal').val() ?? null;
            let url = "{{ route('master_target.excel') }}";

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    filter: filter
                },
                success: function(response) {
                    window.location.href = url + "?filter=" + encodeURIComponent(filter);
                }
            });
        }

        function exportPdf() {
            let filter = $('#export_tanggal').val() ?? null;
            let url = "{{ route('master_target.pdf') }}";

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    filter: filter
                },
                success: function(response) {
                    window.location.href = url + "?filter=" + encodeURIComponent(filter);
                }
            });
        }
    </script>
@endsection
