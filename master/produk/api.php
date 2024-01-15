<?php
include('../../function/auth.php');
include('../../function/config.php');
$db = new DB();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            if (isset($_POST['nama'])) {

                $fillable = [
                    'nama' => $_POST['nama'],
                    'harga' => $_POST['harga'],
                    'stok' => $_POST['stok'],
                ];

                $insert = $db->insert('produk', $fillable);
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

                $fillable = [
                    'nama' => $_POST['nama'],
                    'harga' => $_POST['harga'],
                    'stok' => $_POST['stok'],
                ];

                $insert = $db->update('produk', $fillable, "id = '$id'");
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
                $delete = $db->delete("produk", "id = '$id'");
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
                $data = $db->select("produk", '*', "id = '$id'");
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
