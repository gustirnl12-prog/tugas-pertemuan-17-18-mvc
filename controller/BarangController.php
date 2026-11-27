<?php

require_once __DIR__ . '/../model/BarangModel.php';

class BarangController
{
    private BarangModel $model;

    public function __construct()
    {
        $this->model = new BarangModel();
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $stok = (int) ($_POST['stok'] ?? 0);
            $harga = (int) ($_POST['harga'] ?? 0);

            if ($kode !== '' && $nama !== '' && $stok >= 0 && $harga >= 0) {
                $this->model->tambahBarang($kode, $nama, $stok, $harga);
                header('Location: index.php');
                exit;
            }
        }

        $daftarBarang = $this->model->getAllBarang();
        $totalNilai = $this->model->hitungTotalNilaiPersediaan();

        require_once __DIR__ . '/../view/barang_view.php';
    }
}