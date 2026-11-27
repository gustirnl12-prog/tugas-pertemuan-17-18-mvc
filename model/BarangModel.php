<?php

class BarangModel
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['barang'])) {
            $_SESSION['barang'] = [
                ['kode' => 'BRG01', 'nama' => 'Buku Tulis', 'stok' => 25, 'harga' => 5000],
                ['kode' => 'BRG02', 'nama' => 'Pulpen Gel', 'stok' => 40, 'harga' => 3500],
            ];
        }
    }

    public function getAllBarang(): array
    {
        return $_SESSION['barang'];
    }

    public function tambahBarang(string $kode, string $nama, int $stok, int $harga): void
    {
        $_SESSION['barang'][] = [
            'kode' => $kode,
            'nama' => $nama,
            'stok' => $stok,
            'harga' => $harga,
        ];
    }

    public function hitungTotalNilaiPersediaan(): int
    {
        $total = 0;
        foreach ($_SESSION['barang'] as $item) {
            $total += $item['stok'] * $item['harga'];
        }
        return $total;
    }
}