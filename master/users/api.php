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
                    echo json_encode(['success' => false, 'message' => 'email already taken']);
                    exit;
                }

                if (count($usernameCheck) > 0) {
                    echo json_encode(['success' => false, 'message' => 'username already taken']);
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
                    echo json_encode(['success' => true, 'message' => 'berhasil ditambahkan']);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'gagal menambahkan']);
                exit;
            }
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $delete = $db->delete("user", "id = '$id'");
                if ($delete !== false) {
                    echo json_encode(['success' => true, 'message' => 'berhasil hapus']);
                    exit;
                }
                echo json_encode(['success' => false]);
                exit;
            }
            break;

        default:
            # code...
            break;
    }
}
