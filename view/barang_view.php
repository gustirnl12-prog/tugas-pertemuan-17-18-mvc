<?php
$daftarBarang = $daftarBarang ?? [];
$totalNilai = $totalNilai ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persediaan Barang - MVC</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 820px; margin: 32px auto; padding: 0 16px; }
        .form-group { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        input { padding: 6px 8px; }
        button { padding: 6px 14px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Persediaan Barang (MVC)</h1>

    <form method="POST" action="index.php" class="form-group">
        <input type="text" name="kode" placeholder="Kode (cth: BRG03)" required>
        <input type="text" name="nama" placeholder="Nama Barang" required>
        <input type="number" name="stok" placeholder="Stok" min="0" required>
        <input type="number" name="harga" placeholder="Harga (Rp)" min="0" required>
        <button type="submit">Tambah Barang</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarBarang)): ?>
                <tr>
                    <td colspan="5">Belum ada data barang.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarBarang as $item): ?>
                    <?php
                        $kode = htmlspecialchars((string) ($item['kode'] ?? ''));
                        $nama = htmlspecialchars((string) ($item['nama'] ?? ''));
                        $stok = (int) ($item['stok'] ?? 0);
                        $harga = (int) ($item['harga'] ?? 0);
                        $subtotal = $stok * $harga;
                    ?>
                    <tr>
                        <td><?= $kode ?></td>
                        <td><?= $nama ?></td>
                        <td><?= $stok ?></td>
                        <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><strong>Total Nilai Persediaan:</strong> Rp <?= number_format((int) $totalNilai, 0, ',', '.') ?></p>
</body>
</html>