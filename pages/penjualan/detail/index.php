<?php $title = "Detail Penjualan" ?>
<?php include('../../../layout/header.php'); ?>
<?php include('../../../layout/navbar.php'); ?>
<?php include('../../../layout/sidebar.php'); ?>
<?php
include('../../../function/config.php');
$db = new DB();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detail Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Detail Penjualan</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Detail Penjualan</div>
                        <h3 class="mb-2">KSRID/<?= $_GET['id'] ?></h3>
                        <div class="table-responsive p-1">
                            <table id="data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody id="produk-list">
                                    <?php $id = $_GET['id']; ?>
                                    <?php foreach ($db->select('detail_penjualan', '*', "id_penjualan = '$id'", 'produk', 'detail_penjualan.id_produk = produk.id') as $index => $value) : ?>
                                        <tr>
                                            <td><?= ($index + 1) ?></td>
                                            <td><?= $value['nama'] ?></td>
                                            <td><?= $value['jumlah'] ?></td>
                                            <td data-subtotal="<?= $value['sub_total'] ?>"><?= 'Rp ' . number_format($value['sub_total'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="d-flex flex-column justify-content-end align-items-end mt-2 me-2">
                                <h5 class="fw-bold text-uppercase">Total Harga</h5>
                                <h5 id="total-harga-text">RP . </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->
<?php include('modal.php'); ?>
<?php include('../../../layout/footer.php'); ?>

<script>
    $(document).ready(function() {
        var table = new DataTable('#data-table', {
            paging: false,
            searching: false,
            info: false,
        });

        $('#formModal').on('hidden.bs.modal', function(e) {
            $('#modal-title').text('Tambah Data');
            $('#email').attr('disabled', false);
            $('#username').attr('disabled', false);
            $('#password').attr('required', true);
            $('#ajaxForm').trigger('reset');
        });

        var totalHarga = 0;
        $('#produk-list tr').each(function() {
            var subtotalText = $(this).find('td:eq(3)').data('subtotal');
            totalHarga += parseInt(subtotalText);
        });

        console.log(totalHarga);

        const formattedNumber = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(totalHarga);

        $('#total-harga-text').text(formattedNumber);
    });

    $('body').on('click', '#btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            icon: 'info',
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus data ini?',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `api.php?action=delete&id=${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            }).then((result) => {
                                if (result) {
                                    window.location.reload();
                                }
                            });
                        } else if (!res.success) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message
                            }).then((result) => {
                                if (result) {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        })
    });

    $('body').on('click', '#btn-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: `api.php?action=show&id=${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $('#data-id').val(res.data.id);
                    $('#nama').val(res.data.nama);
                    $('#alamat').val(res.data.alamat);
                    $('#email').val(res.data.email).attr('readonly', true);
                    $('#username').val(res.data.username).attr('readonly', true);
                    $('#role').val(res.data.role);
                    $('#status').val(res.data.status);

                    $('#password').attr('required', false);
                    $('#modal-title').text("Edit Data");
                    $('#formModal').modal('show');

                } else if (!res.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    }).then((result) => {
                        if (result) {
                            window.location.reload();
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });


    });

    $('body').on('submit', '#ajaxForm', function(e) {
        e.preventDefault();
        var formData = $("#ajaxForm").serialize();
        if ($('#data-id').val() === '') {
            $.ajax({
                url: 'api.php?action=add',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        $('#formModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then((result) => {
                            if (result) {
                                window.location.reload();
                            }
                        });
                    } else if (!res.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $.ajax({
                url: `api.php?action=update&id=${$('#data-id').val()}`,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        $('#formModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then((result) => {
                            if (result) {
                                window.location.reload();
                            }
                        });
                    } else if (!res.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>