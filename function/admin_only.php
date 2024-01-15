<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_COOKIE['_users']) || $_SESSION['user']) {
    if ($_SESSION['user']['role'] === "admin") {
        return true;
    }
    echo "<script>window.location.href = '" . route('login') . "'</script>";
    exit;
}
