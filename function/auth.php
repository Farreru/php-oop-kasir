<?php
function route($path)
{
    $baseURL = 'http://localhost/kasir-adit';
    $path = ltrim($path, '/');

    return $baseURL . '/' . $path;
}

if (isset($_COOKIE['_users'])) {
    $usersCookieValue = json_decode($_COOKIE['_users'], true);
    if (isset($usersCookieValue['id'])) {
        $_SESSION['user'] = $usersCookieValue;
    }
} else {
    echo "<script>window.location.href = '" . route('login') . "'</script>";
    exit;
}
