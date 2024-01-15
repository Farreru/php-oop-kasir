<div class="modal fade" id="formModal" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajaxForm" action="" method="post" novalidate class="row g-3 needs-validation">
                    <input type="hidden" name="id" id="data-id">
                    <div class="col-lg-6">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                        <div class="invalid-feedback">Mohon inputkan nama.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="harga">Harga</label>
                        <input type="harga" name="harga" id="harga" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan harga.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan stok.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>