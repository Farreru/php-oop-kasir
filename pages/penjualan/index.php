<?php $title = "Penjualan" ?>
<?php include('../../layout/header.php'); ?>
<?php include('../../layout/navbar.php'); ?>
<?php include('../../layout/sidebar.php'); ?>
<?php
include('../../function/config.php');
$db = new DB();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Penjualan</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Data Penjualan</div>
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-primary " type="button" data-bs-toggle="modal" data-bs-target="#formModal">Transaksi Baru</button>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Total Harga</th>
                                        <th>Pelanggan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($db->select('penjualan', 'penjualan.id, penjualan.tanggal, penjualan.total_harga, pelanggan.nama AS nama_pelanggan, pelanggan.id AS id_pelanggan', "", 'pelanggan', 'penjualan.id_pelanggan = pelanggan.id', 'tanggal', 'DESC') as $index => $value) : ?>
                                        <tr>
                                            <td><?= ($index + 1) ?></td>
                                            <td><?= $value['tanggal'] ?></td>
                                            <td><?= 'Rp ' . number_format($value['total_harga'], 0, ',', '.'); ?></td>
                                            <td><?= $value['nama_pelanggan'] ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button id="btn-detail" data-id="<?= $value['id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-list-ul text-white"></i></button>
                                                    <button id="btn-delete" data-id="<?= $value['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->
<?php include('modal.php'); ?>
<?php include('../../layout/footer.php'); ?>

<script>
    $(document).ready(function() {
        var table = new DataTable('#data-table');
        var table2 = new DataTable('#data-produk');

        $('#formModal').on('hidden.bs.modal', function(e) {
            $('#modal-title').text('Tambah Data');
            $('#email').attr('disabled', false);
            $('#username').attr('disabled', false);
            $('#password').attr('required', true);
            $('#ajaxForm').trigger('reset');
        });

        $('.select2').select2({
            theme: 'bootstrap-5',
        });

        $.ajax({
            url: `api.php?action=pelanggan`,
            type: 'GET',
            success: function(res) {
                var jsonResponse = JSON.parse(res);
                if (jsonResponse.data && Array.isArray(jsonResponse.data)) {
                    jsonResponse.data.forEach(element => {
                        let temp = false;
                        // console.log(element);
                        option = new Option(element.nama, element.id, false, temp);
                        $('#pelanggan').append(option);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        setInterval(() => {
            var tanggal_sekarang = new Date();

            var year = tanggal_sekarang.getFullYear();
            var month = ('0' + (tanggal_sekarang.getMonth() + 1)).slice(-2); // Adding 1 to get the correct month
            var day = ('0' + tanggal_sekarang.getDate()).slice(-2);

            var hour = ('0' + tanggal_sekarang.getHours()).slice(-2);
            var minute = ('0' + tanggal_sekarang.getMinutes()).slice(-2);
            var second = ('0' + tanggal_sekarang.getSeconds()).slice(-2);

            var datetime = `${year}-${month}-${day} ${hour}:${minute}:${second}`;
            $('#tanggal').val(datetime);
            // console.log(datetime);
        }, 1000)

    });

    $('body').on('click', '#reset-button', function() {
        $('#ajaxForm').trigger('reset');
        window.location.reload();
        $('#produk-list').empty().append(`
        <tr>
            <td colspan="4" class="text-center">No data available</td>
        </tr>
        `);
    });

    $('body').on('click', '#btn-add', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var stokElement = $(`#produk-list-stok-${id}`);
        var stok = parseInt(stokElement.text());

        if (stok < 1) {
            return false;
        }

        if ($('#produk-list').html().includes('No data available')) {
            $('#produk-list').empty();
        }

        var rowIndex = $('#produk-list tr').length;
        if (!$(`#data-produk-list-${id}`).length) {
            $('#produk-list').append(`
                <tr data-id-produk="${id}" id="data-produk-list-${id}">
                    <td>${rowIndex + 1}</td>
                    <td>${nama}</td>
                    <td><input type="number" min="0" max="${stok}" oninput="inputQuantity(${id})" class="form-control" style="max-width: 5rem;" id="quantity-produk-${id}"></td>
                    <td id="subtotal-produk-${id}">0</td>
                </tr>
            `);
        }
    });

    function inputQuantity(id) {
        var elementHarga = parseInt($(`#produk-list-harga-${id}`).data('harga'));
        var element = parseInt($(`#produk-list-stok-${id}`).text());
        var maxStok = parseInt($(`#quantity-produk-${id}`).attr('max')); // Access max attribute

        var quantity = parseInt($(`#quantity-produk-${id}`).val());

        if (quantity > maxStok) {
            $(`#quantity-produk-${id}`).val(maxStok);
            $(`#subtotal-produk-${id}`).text(elementHarga * maxStok);
        } else {
            $(`#subtotal-produk-${id}`).text(elementHarga * quantity);
            console.log(element);
        }

        if ($(`#quantity-produk-${id}`).val() == "") {
            $(`#subtotal-produk-${id}`).text(0);
        }

        var totalHarga = 0;
        $('#produk-list tr').each(function() {
            var subtotalText = $(this).find('td:eq(3)').text();
            totalHarga += parseInt(subtotalText);
        });

        $('#total_harga').val(totalHarga);

    }



    $('body').on('click', '#btn-remove', function() {
        var id = $(this).data('id');

        var stokElement = $(`#produk-list-stok-${id}`);
        var stok = parseInt(stokElement.text());
        stokElement.text(stok + 1);

        $(`#data-produk-list-${id}`).remove();

        var totalHarga = 0;
        $('#produk-list tr').each(function() {
            var subtotalText = $(this).find('td:eq(3)').text();
            totalHarga += parseInt(subtotalText);
        });

        $('#total_harga').val(totalHarga);
    });


    $('body').on('click', '#btn-detail', function() {
        var id = $(this).data('id');
        window.location.href = `detail/?id=${id}`;
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

        var productListDetails = [];

        $('#produk-list tr').each(function() {
            var id = $(this).data('id-produk');
            var quantity = parseInt($(`#quantity-produk-${id}`).val());
            var subtotal = parseInt($(`#subtotal-produk-${id}`).text());

            var productDetails = {
                id_penjualan: 1,
                id_produk: id,
                jumlah: quantity,
                sub_total: subtotal
            };

            productListDetails.push(productDetails);
        });

        formData += '&productListDetails=' + JSON.stringify(productListDetails);

        console.log(formData);
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