<?php
$dataBarang = $dataBarang ?? [];
$totalPersediaan = $totalPersediaan ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas Pertemuan 17-18 - MVC Persediaan Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        table { border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #444; padding: 8px 10px; text-align: left; }
        th { background-color: #efefef; }
        .sukses { color: green; font-weight: bold; }
        .gagal { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h3>INPUT DATA BARANG</h3>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'sukses'): ?>
            <p class="sukses">Data berhasil disimpan</p>
        <?php elseif ($_GET['status'] === 'invalid'): ?>
            <p class="gagal">Data tidak valid</p>
        <?php else: ?>
            <p class="gagal">Data gagal disimpan</p>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="controller/proses_barang.php">
        <table border="0" cellpadding="6">
            <tr>
                <td>NAMA BARANG</td>
                <td>
                    <input type="text" name="nama_barang" list="daftar_barang" placeholder="Contoh: Minyak Goreng" required>
                    <datalist id="daftar_barang">
                        <option value="Beras Premium">
                        <option value="Minyak Goreng">
                        <option value="Gula Pasir">
                        <option value="Tepung Terigu">
                        <option value="Kopi Bubuk">
                    </datalist>
                </td>
            </tr>
            <tr>
                <td>KATEGORI</td>
                <td>
                    <label><input type="radio" name="kategori" value="Makanan" required> Makanan</label>
                    <label><input type="radio" name="kategori" value="Pangan"> Pangan</label>
                    <label><input type="radio" name="kategori" value="Minuman"> Minuman</label>
                </td>
            </tr>
            <tr>
                <td>STOCK</td>
                <td><input type="number" name="stock" min="1" placeholder="Contoh: 12" required></td>
            </tr>
            <tr>
                <td>MASA PAKAI (HARI)</td>
                <td><input type="number" name="masa_pakai" min="0" value="14" required></td>
            </tr>
            <tr>
                <td>LOKASI SIMPAN</td>
                <td>
                    <select name="lokasi_simpan">
                        <option value="Lokasi 1">Lokasi 1</option>
                        <option value="Lokasi 2">Lokasi 2</option>
                        <option value="Lokasi 3">Lokasi 3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="proses" value="PROSES"></td>
            </tr>
        </table>
    </form>

    <h3>OUTPUT DATA PERSEDIAAN BARANG</h3>
    <table>
        <thead>
            <tr>
                <th>KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th>KATEGORI</th>
                <th>STOCK</th>
                <th>HARGA SATUAN</th>
                <th>LOKASI SIMPAN</th>
                <th>NILAI PERSEDIAAN</th>
                <th>TANGGAL EXPIRED</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataBarang)): ?>
                <tr>
                    <td colspan="8">Belum ada data barang.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($dataBarang as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($row['kode_barang'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($row['nama_barang'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($row['kategori'] ?? '')) ?></td>
                        <td><?= number_format((int) ($row['stock'] ?? 0), 0, ',', '.') ?></td>
                        <td>Rp <?= number_format((int) ($row['harga_satuan'] ?? 0), 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars((string) ($row['lokasi_simpan'] ?? '')) ?></td>
                        <td>Rp <?= number_format((int) ($row['nilai_persediaan'] ?? 0), 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars((string) ($row['tanggal_expired'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <h4>TOTAL PERSEDIAAN: Rp <?= number_format((int) $totalPersediaan, 0, ',', '.') ?></h4>
</body>
</html>