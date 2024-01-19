<?php
include('../../function/auth.php');
include('../../function/config.php');
$db = new DB();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            if (isset($_POST['pelanggan'])) {
                $fillablePenjualan = [
                    'id_pelanggan' => $_POST['pelanggan'],
                    'tanggal' => $_POST['tanggal'],
                    'total_harga' => $_POST['total_harga'],
                ];

                $penjualanId = $db->insert('penjualan', $fillablePenjualan, true);

                if ($penjualanId !== false) {
                    foreach ($_POST['productListDetails'] as $productDetails) {
                        $fillableDetailPenjualan = [
                            'id_penjualan' => $penjualanId,
                            'id_produk' => $productDetails['id_produk'],
                            'jumlah' => $productDetails['jumlah'],
                            'sub_total' => $productDetails['sub_total'],
                        ];

                        $insertDetailPenjualan = $db->insert('detail_penjualan', $fillableDetailPenjualan);

                        if ($insertDetailPenjualan === false) {
                            echo json_encode(['success' => false, 'message' => 'Gagal Menambahkan Detail Penjualan']);
                            exit;
                        }
                    }

                    echo json_encode(['success' => true, 'message' => 'Berhasil Menambahkan Data']);
                    exit;
                }
            }
            echo json_encode(['success' => false, 'message' => 'Gagal Menambahkan Data']);
            exit;
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
