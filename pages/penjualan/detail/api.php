<?php
include('../../function/auth.php');
include('../../function/config.php');
$db = new DB();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            if (isset($_POST['nama'])) {
                $email = $_POST['email'];
                $username = $_POST['username'];
                $emailCheck = $db->select('user', 'email', "email = '$email'");
                $usernameCheck = $db->select('user', 'username', "username = '$username'");

                if (count($emailCheck) > 0) {
                    echo json_encode(['success' => false, 'message' => 'Email telah tersedia!']);
                    exit;
                }

                if (count($usernameCheck) > 0) {
                    echo json_encode(['success' => false, 'message' => 'Username telah tersedia!']);
                    exit;
                }

                $fillable = [
                    'nama' => $_POST['nama'],
                    'email' => $_POST['email'],
                    'alamat' => $_POST['alamat'],
                    'password' => md5($_POST['password']),
                    'username' => $_POST['username'],
                    'status' => $_POST['status'],
                    'role' => $_POST['role']
                ];

                $insert = $db->insert('user', $fillable);
                if ($insert !== false) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Menambahkan Data']);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Menambahkan Data']);
                exit;
            }
            break;

        case 'update':
            if (isset($_POST['id'])) {
                $id = $_GET['id'];

                $password = $_POST['password'];

                $fillable = [
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'status' => $_POST['status'],
                    'role' => $_POST['role']
                ];

                if ($password !== null) {
                    $password = md5($password);
                    $fillable['password'] = $password;
                }

                $insert = $db->update('user', $fillable, "id = '$id'");
                if ($insert !== false) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Perubahan Data']);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Perubahan Data']);
                exit;
            }
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $delete = $db->delete("user", "id = '$id'");
                if ($delete !== false) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Dihapus']);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Dihapus!']);
                exit;
            }
            break;

        case 'show':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $data = $db->select("user", 'id,nama,alamat,username,role,status,email', "id = '$id'");
                if (count($data) > 0) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Didapatkan', 'data' => $data[0]]);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Didapatkan!']);
                exit;
            }
            break;

        default:
            # code...
            break;
    }
}
