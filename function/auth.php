<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

function route($path)
{
    $baseURL = $_ENV['APP_URL'];
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
