<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    session_destroy();
    unset($_SESSION);
    setcookie('_users', '', time() - 3600, '/');
    echo "<script> window.location.href = '../login' </script>";
} else {
    echo "<script> window.location.href = '../login' </script>";
}
