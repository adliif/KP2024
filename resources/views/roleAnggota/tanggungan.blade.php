<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="wrapper">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <div class="main-panel">
            <!-- Navbar -->
            <x-navbar></x-navbar>

            <!-- Content -->
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Tanggungan</h3>
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
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Tanggungan Pokok</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row2" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>jatuh Tempo</th>
                                                    <th>Iuran/Bulan</th>
                                                    <th style="text-align: center;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($transaksiPokok as $t)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $t->jatuh_tempo }}</td>
                                                        <td>Rp{{ number_format($t->simpanan_pokoks->iuran, 0, ',', '.') }}</td>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            @if ($t->keterangan == 'Lunas')
                                                                <button class="btn btn-dark"
                                                                    disabled>{{ $t->keterangan }}</button>
                                                            @else
                                                                <button class="btn btn-primary">{{ $t->keterangan }}</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty

                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Tanggungan Pinjaman</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>jatuh Tempo</th>
                                                    <th>Iuran/Bulan</th>
                                                    <th style="text-align: center;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($transaksiPinjaman as $t)
                                                    <tr id="row_{{ $t->id_transaksiPinjaman }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $t->jatuh_tempo }}</td>
                                                        <td>Rp{{ number_format($t->tanggungan->iuran_perBulan, 0, ',', '.') }}</td>
                                                        <td id="aksi_{{ $t->id_transaksiPinjaman }}" style="text-align: center;">
                                                            @if ($t->keterangan != 'Lunas')
                                                                @php
                                                                    $prevTransaksi = $transaksiPinjaman->where('id_transaksiPinjaman', $t->id_transaksiPinjaman - 1)->first();
                                                                @endphp
                                                                @if ($loop->first || ($prevTransaksi && $prevTransaksi->keterangan == 'Lunas'))
                                                                    <form class="form-update-status" action="{{ route('pinjaman.update', $t->id_transaksiPinjaman) }}" 
                                                                        method="post" data-id="{{ $t->id_transaksiPinjaman }}" >
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Lunas">
                                                                        <button type="submit" class="btn btn-primary btn-setujui">{{ $t->keterangan }}</button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-primary" disabled>{{ $t->keterangan }}</button>
                                                                @endif
                                                            @else
                                                                <button class="btn btn-dark" disabled>{{ $t->keterangan }}</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    
                                                @endforelse
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
        $(document).ready(function () {
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
                        if (status === "Lunas") {
                            Swal.fire({
                                title: "Pembayaran Berhasil!",
                                text: "Terima kasih telah membayar tepat waktu.",
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
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

            $("#add-row").DataTable({
                pageLength: 5,
            });

            $("#add-row2").DataTable({
                pageLength: 5,
            });

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