<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../model/barang_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses'])) {
    $namaBarang = trim($_POST['nama_barang'] ?? '');
    $kategori   = trim($_POST['kategori'] ?? '');
    $stock      = (int) ($_POST['stock'] ?? 0);
    $lokasi     = trim($_POST['lokasi_simpan'] ?? 'Lokasi 1');
    $masaPakai  = (int) ($_POST['masa_pakai'] ?? 14);

    if ($namaBarang === '' || $kategori === '' || $stock <= 0) {
        header('Location: ../lat_index.php?status=invalid');
        exit;
    }

    if (simpanDataBarang($namaBarang, $kategori, $stock, $lokasi, $masaPakai)) {
        header('Location: ../lat_index.php?status=sukses');
    } else {
        header('Location: ../lat_index.php?status=gagal');
    }
    exit;
}

function prosesTampilBarang(): array
{
    return tampilDataBarang();
}

function prosesTotalPersediaan(array $data): int
{
    return hitungTotalPersediaan($data);
}