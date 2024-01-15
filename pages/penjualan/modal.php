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
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan username.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan email.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan password.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                        <div class="invalid-feedback">Mohon inputkan alamat.</div>
                    </div>
                    <div class="col-lg-6">
                        <label for="role">Role</label>
                        <select name="role" class="form-select" required id="role">
                            <option value=""></option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                        <div class="invalid-feedback">Mohon pilih role.</div>
                    </div>
                    <div class="col-lg-12">
                        <label for="status">Status</label>
                        <select name="status" class="form-select" required id="status">
                            <option value=""></option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        <div class="invalid-feedback">Mohon pilih status.</div>
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