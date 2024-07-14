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
                        <h3 class="fw-bold mb-3">Data Pinjaman</h3>
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
                                <a href="#">Pinjaman</a>
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
                                                    <th>Tanggal Pengajuan</th>
                                                    <th>Besar Pinjaman</th>
                                                    <th>Tenor Pinjaman</th>
                                                    <th style="width: 10%">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pinjaman as $p)
                                                    <tr id="row_{{ $p->id_pinjaman }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $p->user->nama }}</td>
                                                        <td>{{ $p->tgl_pengajuan }}</td>
                                                        <td>{{ $p->besar_pinjaman }}</td>
                                                        <td>{{ $p->tenor_pinjaman }}</td>
                                                        <td id="aksi_{{ $p->id_pinjaman }}">
                                                            @if ($p->keterangan == 'Diproses')
                                                                <div class="d-flex justify-content-between">
                                                                    <form class="form-update-status"
                                                                        action="{{ route('pinjaman.updateStatus', $p->id_pinjaman) }}"
                                                                        method="post" data-id="{{ $p->id_pinjaman }}">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui">
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-setujui me-3">Disetujui</button>
                                                                    </form>
                                                                    <form class="form-update-status"
                                                                        action="{{ route('pinjaman.updateStatus', $p->id_pinjaman) }}"
                                                                        method="post" data-id="{{ $p->id_pinjaman }}">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Ditolak">
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-tolak">Ditolak</button>
                                                                    </form>
                                                                </div>
                                                            @elseif ($p->keterangan == 'Disetujui')
                                                                <button class="btn btn-success"
                                                                    disabled>Disetujui</button>
                                                            @elseif ($p->keterangan == 'Ditolak')
                                                                <button class="btn btn-danger" disabled>Ditolak</button>
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

    <!-- Tambahkan ini di bagian head HTML Anda -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

            // Handle form submission and update button status
            $(".form-update-status").on("submit", function(e) {
        e.preventDefault(); // Mencegah tindakan default dari klik
        var form = $(this);
        var id = form.data("id");
        var status = form.find("input[name='status']").val();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                if (status === "Disetujui") {
                    Swal.fire({
                        title: "Pinjaman disetujui",
                        icon: "success",
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Refresh halaman setelah alert ditutup
                        }
                    });
                } else if (status === "Ditolak") {
                    Swal.fire({
                        title: "Pinjaman ditolak",
                        icon: "error",
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Refresh halaman setelah alert ditutup
                        }
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: "Gagal memperbarui status",
                    text: response.responseJSON.message,
                    icon: "error"
                });
            }
        });
    });
        });
    </script>
</x-layout>
