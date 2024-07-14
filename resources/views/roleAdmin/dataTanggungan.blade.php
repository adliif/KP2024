    <x-layout>
        <x-slot:title>{{ $title }}</x-slot:title>

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
                            <h3 class="fw-bold mb-3">Data Tanggungan</h3>
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
                                    <a href="#">Tanggungan</a>
                                </li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table id="add-row" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama</th>
                                                        <th>Besar Pinjaman</th>
                                                        <th>Tenor</th>
                                                        <th>Bunga Pinjaman</th>
                                                        <th>Total Pinjaman</th>
                                                        <th>Iuran/Bulan</th>
                                                        <th>Sisa Pinjaman</th>
                                                        <th>Status Pinjaman</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tanggungan as $t)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $t->pinjaman->user->nama }}</td>
                                                            <td>{{ $t->pinjaman->besar_pinjaman }}</td>
                                                            <td>{{ $t->pinjaman->tenor_pinjaman }}</td>
                                                            <td>{{ $t->bunga_pinjaman }}</td>
                                                            <td>{{ $t->total_pinjaman }}</td>
                                                            <td>{{ $t->iuran_perBulan }}</td>
                                                            <td>{{ $t->sisa_pinjaman }}</td>
                                                            <td id="aksi_{{ $t->sisa_pinjaman }}">
                                                                @if ($t->sisa_pinjaman > 0)
                                                                    <button class="btn btn-danger" disabled>Belum Lunas</button>
                                                                @else
                                                                    <button class="btn btn-success" disabled>Lunas</button>
                                                                @endif
                                                            </td>
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
            $(document).ready(function() {
                $("#basic-datatables").DataTable({});

                $("#multi-filter-select").DataTable({
                    pageLength: 5,
                    initComplete: function() {
                        this.api()
                            .columns()
                            .every(function() {
                                var column = this;
                                var select = $(
                                        '<select class="form-select"><option value=""></option></select>'
                                    )
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function() {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function(d, j) {
                                        select.append(
                                            '<option value="' + d + '">' + d + "</option>"
                                        );
                                    });
                            });
                    },
                });

                // Add Row
                $("#add-row").DataTable({
                    pageLength: 5,
                });

                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

                $("#addRowButton").click(function() {
                    $("#add-row")
                        .dataTable()
                        .fnAddData([
                            $("#addName").val(),
                            $("#addPosition").val(),
                            $("#addOffice").val(),
                            action,
                        ]);
                    $("#addRowModal").modal("hide");
                });
            });
        </script>
    </x-layout>
