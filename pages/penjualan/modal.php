<div class="modal fade" id="formModal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form id="ajaxForm" action="" method="post" novalidate class="row pb-4 needs-validation">
                            <input type="hidden" name="id" id="data-id">
                            <div class="row px-2 g-3 mx-2">
                                <div class="col-lg-12">
                                    <label for="pelanggan">Pelanggan</label>
                                    <select name="pelanggan" class="form-select select2" required id="pelanggan">
                                        <option value=""></option>
                                    </select>
                                    <div class="invalid-feedback">Mohon pilih pelanggan.</div>
                                </div>
                                <div class="col-lg-12">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="datetime-local" class="form-control" name="tanggal" readonly id="tanggal" value="<?= date('Y-m-d H:i:s') ?>" class="form-control" required>
                                    <!-- <div class="invalid-feedback">Mohon inputkan username.</div> -->
                                </div>
                                <div class="col-lg-12">
                                    <label for="total_harga">Total Harga</label>
                                    <input type="text" name="total_harga" id="total_harga" readonly class="form-control">
                                    <!-- <div class="invalid-feedback">Mohon inputkan email.</div> -->
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" name="submit" class="btn btn-success me-auto">Buat Transaksi</button>
                                    <div class="gap-1">
                                        <button id="reset-button" type="reset" class="btn btn-warning text-white ">Reset</button>
                                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-lg-7">
                        <div class="py-2 px-4">
                            <div class="table-responsive">
                                <table id="data-produk" class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($db->select('produk', '*', "", '', '', 'nama', 'ASC') as $index => $value) : ?>
                                            <tr>
                                                <td><?= ($index + 1) ?></td>
                                                <td><?= $value['nama'] ?></td>
                                                <td id="produk-list-harga-<?= $value['id'] ?>" data-harga="<?= $value['harga'] ?>"><?= 'Rp ' . number_format($value['harga'], 0, ',', '.'); ?></td>
                                                <td id="produk-list-stok-<?= $value['id'] ?>"><?= $value['stok'] ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button id="btn-add" data-harga="<?= $value['harga'] ?>" data-nama="<?= $value['nama'] ?>" data-id="<?= $value['id'] ?>" class="btn btn-success btn-sm"><i class="bi bi-cart text-white"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <table class="mt-2 table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Produk</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="produk-list">
                                        <tr>
                                            <td colspan="4" class="text-center">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>