<?php

include('../../function/config.php');

$db = new DB();

$nama = "admin";
$username = "admin";
$email = "admin@gmail.com";
$password = password_hash("admin123", PASSWORD_BCRYPT);
$alamat = "admin default";
$role = "admin";
$status = "aktif";

$fillable = [
    'nama' => $nama,
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'alamat' => $alamat,
    'role' => $role,
    'status' => $status
];

$db->insert('user', $fillable);

echo "<script>window.location.href = '../'</script>";
