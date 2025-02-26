<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Mdigi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
</head>

<body>
    <main class="d-flex flex-nowrap">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; min-height:100vh">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi pe-none me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
                <span class="fs-4">Test Mdigi</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }} text-white"
                        aria-current="page">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('rekening') }}"
                        class="nav-link {{ Request::is('rekening') || Request::is('rekening/*') ? 'active' : '' }} text-white"
                        aria-current="page">
                        Data Rekening
                    </a>
                </li>
                <li>
                    <a href="{{ route('via_pembayaran') }}"
                        class="nav-link {{ Request::is('via_pembayaran') || Request::is('via_pembayaran/*') ? 'active' : '' }} text-white">
                        Data Via Pembayaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('master_target') }}"
                        class="nav-link {{ Request::is('master_target') || Request::is('master_target/*') ? 'active' : '' }} text-white">
                        Data Master Target
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        Data Entry Harian
                    </a>
                </li>
            </ul>
        </div>
        <div class="container py-4 px-3 mx-auto">
            @yield('content')
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "{{ session('success') }}",
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "{{ session('error') }}",
                });
            @endif
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
        const formatRupiah = (num) => num.toLocaleString("id-ID").replace(/,/g, ".");
    </script>
    @yield('script')
</body>

</html>
