<?php

function daftarHargaBarang(): array
{
    return [
        'beras premium' => 14000,
        'minyak goreng' => 18000,
        'gula pasir'    => 16000,
        'tepung terigu' => 12000,
        'kopi bubuk'    => 25000,
    ];
}

function tentukanHargaSatuan(string $namaBarang): int
{
    $key = strtolower(trim($namaBarang));
    $daftar = daftarHargaBarang();
    return $daftar[$key] ?? 10000;
}

function buatKodeBarang(string $namaBarang, string $kategori, int $stock): string
{
    $bersihNama = preg_replace('/[^A-Za-z0-9]/', '', $namaBarang);
    if ($bersihNama === '') {
        $bersihNama = 'BR';
    }

    $awalNama  = strtoupper(substr($bersihNama, 0, 1));
    $akhirNama = strtoupper(substr($bersihNama, -1, 1));
    $xx        = $awalNama . $akhirNama;

    $bersihKat = preg_replace('/[^A-Za-z]/', '', $kategori);
    $yy        = strtoupper(substr(str_pad($bersihKat, 2, 'X'), 0, 2));

    $z         = abs($stock) % 10;

    return "{$xx}-{$yy}-{$z}";
}

function hitungTanggalExpired(int $masaPakaiHari): string
{
    $hari = max(0, $masaPakaiHari);
    $tanggal = new DateTime('today');
    $tanggal->modify("+{$hari} days");
    return $tanggal->format('Y-m-d');
}

function initDataBarang(): void
{
    if (!isset($_SESSION['data_barang'])) {
        $_SESSION['data_barang'] = [
            [
                'kode_barang'      => buatKodeBarang('Beras Premium', 'Pangan', 10),
                'nama_barang'      => 'Beras Premium',
                'kategori'         => 'Pangan',
                'stock'            => 10,
                'harga_satuan'     => tentukanHargaSatuan('Beras Premium'),
                'lokasi_simpan'    => 'Lokasi 1',
                'nilai_persediaan' => 10 * tentukanHargaSatuan('Beras Premium'),
                'tanggal_expired'  => hitungTanggalExpired(30),
            ],
        ];
    }
}

function simpanDataBarang(string $namaBarang, string $kategori, int $stock, string $lokasi, int $masaPakai): bool
{
    initDataBarang();

    $namaBersih = trim($namaBarang);
    $katBersih  = trim($kategori);

    if ($namaBersih === '' || $katBersih === '' || $stock <= 0 || $masaPakai < 0) {
        return false;
    }

    $hargaSatuan     = tentukanHargaSatuan($namaBersih);
    $nilaiPersediaan = $stock * $hargaSatuan;

    $_SESSION['data_barang'][] = [
        'kode_barang'      => buatKodeBarang($namaBersih, $katBersih, $stock),
        'nama_barang'      => $namaBersih,
        'kategori'         => $katBersih,
        'stock'            => $stock,
        'harga_satuan'     => $hargaSatuan,
        'lokasi_simpan'    => $lokasi,
        'nilai_persediaan' => $nilaiPersediaan,
        'tanggal_expired'  => hitungTanggalExpired($masaPakai),
    ];

    return true;
}

function tampilDataBarang(): array
{
    initDataBarang();
    return $_SESSION['data_barang'];
}

function hitungTotalPersediaan(array $data): int
{
    $total = 0;
    foreach ($data as $row) {
        $total += (int) ($row['nilai_persediaan'] ?? 0);
    }
    return $total;
}