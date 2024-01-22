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

                $penjualanId = $db->insert('penjualan', $fillablePenjualan);
                $productListDetails = json_decode($_POST['productListDetails'], true);

                foreach ($productListDetails as $productDetails) {
                    $fillableDetailPenjualan = [
                        'id_penjualan' => $penjualanId,
                        'id_produk' => $productDetails['id_produk'],
                        'jumlah' => $productDetails['jumlah'],
                        'sub_total' => $productDetails['sub_total'],
                    ];

                    $selectProduk = $db->select('produk', 'stok', 'id = ' . $productDetails['id_produk']);
                    $jumlahBaru = ($selectProduk[0]['stok'] - $productDetails['jumlah']);
                    $updateStok = $db->update('produk', ['stok' => $jumlahBaru], "id = " . $productDetails['id_produk']);

                    $insertDetailPenjualan = $db->insert('detail_penjualan', $fillableDetailPenjualan);

                    if ($insertDetailPenjualan === false) {
                        echo json_encode(['success' => false, 'message' => 'Gagal Menambahkan Detail Penjualan']);
                        exit;
                    }
                }

                echo json_encode(['success' => true, 'message' => 'Berhasil Menambahkan Data']);
                exit;
            }
            echo json_encode(['success' => false, 'message' => 'Gagal Menambahkan Data']);
            exit;
            break;


        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $detailsPenjualanData = $db->select('detail_penjualan', "*", "id_penjualan = $id");

                $productIds = array_column($detailsPenjualanData, 'id_produk');
                $detailsProdukData = $db->select('produk', '*', "id IN (" . implode(',', $productIds) . ")");

                $delete = $db->delete("detail_penjualan", "id_penjualan = '$id'");
                $delete2 = $db->delete("penjualan", "id = $id");

                if ($delete !== false) {
                    foreach ($detailsProdukData as $productDetails) {
                        $productId = $productDetails['id'];

                        $quantity = array_values(array_filter($detailsPenjualanData, function ($detail) use ($productId) {
                            return $detail['id_produk'] == $productId;
                        }))[0]['jumlah'];

                        $currentStock = $productDetails['stok'];

                        $newStock = $currentStock + $quantity;
                        $updateStok = $db->update('produk', ['stok' => $newStock], "id = $productId");

                        if ($updateStok === false) {
                            echo json_encode(['success' => false, 'message' => 'Gagal Mengembalikan Stok']);
                            exit;
                        }
                    }

                    echo json_encode(['success' => true, 'message' => 'Berhasil Dihapus']);
                    exit;
                }

                echo json_encode(['success' => false, 'message' => 'Gagal Dihapus!']);
                exit;
            }
            break;

        case 'pelanggan':
            $data = $db->select('pelanggan', '*');
            if (count($data) > 0) {
                echo json_encode(['success' => true, 'message' => 'Berhasil Didapatkan', 'data' => $data]);
                exit;
            }
            echo json_encode(['success' => false, 'message' => 'Gagal Didapatkan!']);
            exit;
            break;

        case 'show':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $data = $db->select(
                    'penjualan',
                    'penjualan.id, penjualan.tanggal, penjualan.total_harga, pelanggan.nama AS nama_pelanggan, pelanggan.id AS id_pelanggan',
                    "penjualan.id = '$id'",
                    'pelanggan',
                    'penjualan.id_pelanggan = pelanggan.id',
                    'tanggal',
                    'DESC'
                );
                if (count($data) > 0) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Didapatkan', 'data' => $data[0]]);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Didapatkan!']);
                exit;
            }
            break;

        case 'produk_detail':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $data = $db->select('detail_penjualan', '*', "id_penjualan = '$id'", 'produk', 'detail_penjualan.id_produk = produk.id');
                if (count($data) > 0) {
                    echo json_encode(['success' => true, 'message' => 'Berhasil Didapatkan', 'data' => $data]);
                    exit;
                }
                echo json_encode(['success' => false, 'message' => 'Gagal Didapatkan!']);
                exit;
            }
            break;

        case 'produk':
            $produkData = $db->select('produk', '*', '', '', '', 'nama', 'ASC');

            echo json_encode($produkData);
            break;

        default:
            # code...
            break;
    }
}
