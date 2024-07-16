<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="wrapper">
        <!-- Sidebar -->
        <x-sidebar-admin></x-sidebar-admin>

        <div class="main-panel">
            <!-- Navbar -->
            <x-nav-admin></x-nav-admin>

            <!-- Content -->
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Data Transaksi Pinjaman</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="#">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Transaksi Pinjaman</a>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    {{-- <div class="d-flex align-items-center">
                                        <a href="#" class="btn btn-success btn-round ms-auto">
                                            <i class="fa fa-file-excel"></i> Export Excel
                                        </a>
                                        <a href="#" class="btn btn-danger btn-round ms-3">
                                            <i class="fa fa-file-pdf"></i> Export PDF
                                        </a>
                                    </div> --}}
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Total Pembayaran</th>
                                                    <th>Jatuh Tempo</th>
                                                    <th>Tanggal Pembayaran</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ( $transaksiPinjaman as $tp)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $tp->tanggungan->pinjaman->user->nama }}</td>
                                                    <td>{{ 'Rp. ' . number_format($tp->tanggungan->total_pinjaman, 0, ',', '.') }}</td>
                                                    <td>{{ $tp->jatuh_tempo }}</td>
                                                    <td>{{ $tp->tanggal_pembayaran }}</td>
                                                    <td>{{ $tp->keterangan }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo2.js"></script>
    <script>
        $(document).ready(function () {
            $("#basic-datatables").DataTable({});

            // Add Row
            $("#add-row").DataTable({
                pageLength: 25,
            });
        });
    </script>
</x-layout>