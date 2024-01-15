<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Kasir 7</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by
        <a href="https://github.com/Farreru">Muhammad Adit Farrel</a>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?= assets('vendor/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?= assets('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= assets('vendor/chart.js/chart.umd.js') ?>"></script>
<script src="<?= assets('vendor/echarts/echarts.min.js') ?>"></script>
<script src="<?= assets('vendor/quill/quill.min.js') ?>"></script>
<!-- <script src="<?= assets('vendor/simple-datatables/simple-datatables.js') ?>"></script> -->
<script src="<?= assets('vendor/tinymce/tinymce.min.js') ?>"></script>
<script src="<?= assets('vendor/php-email-form/validate.js') ?>"></script>

<!-- Template Main JS File -->
<script src="<?= assets('js/main.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.preloader').fadeOut('slow');
        }, 1800);

        $('body').on('click', '#profile-button', function() {
            $('#profile-button').toggleClass('show');
            $('#profile-tab').toggleClass('show');
        });


    });
</script>

</body>

</html>