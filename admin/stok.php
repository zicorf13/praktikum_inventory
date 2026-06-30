<?php
include '../koneksi.php';

// PROSES UPDATE STOK & LIMIT
if (isset($_POST['update_stok'])) {
    $id = $_POST['id'];
    $stok_baru = (int)$_POST['stok'];
    $limit_baru = (int)$_POST['limit_stok'];
    
    $query = "UPDATE barang SET stok='$stok_baru', limit_stok='$limit_baru' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: stok.php?status=updated");
    }
}

// AMBIL DATA BARANG + SINKRONISASI INNER JOIN
$query_barang = "SELECT b.id, b.nama_barang, b.stok, b.limit_stok, p.nama_penyimpanan 
                 FROM barang b 
                 LEFT JOIN penyimpanan p ON b.penyimpanan_id = p.id";
$data_stok = mysqli_query($koneksi, $query_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container bg-white p-4 rounded shadow-sm">
    <h3 class="mb-4">📊 Kontrol Stok & Batas Minimum Barang</h3>

    <table class="table table-hover table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th>Nama Barang</th>
                <th>Lokasi</th>
                <th>Stok Saat Ini</th>
                <th>Batas Minimum (Limit)</th>
                <th>Status Stok</th>
                <th width="300">Aksi Cepat</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($data_stok)) { 
                $kritis = ($row['stok'] <= $row['limit_stok']);
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['nama_barang']); ?></strong></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['nama_penyimpanan'] ?? 'Belum Diatur'); ?></span></td>
                <td><h5><?= $row['stok']; ?></h5></td>
                <td><?= $row['limit_stok']; ?></td>
                <td>
                    <?= $kritis ? '<span class="badge bg-danger">Kritis / Restock!</span>' : '<span class="badge bg-success">Aman</span>'; ?>
                </td>
                <td>
                    <!-- Form inline ubah nilai stok secara instan -->
                    <form method="POST" action="" class="d-flex gap-1">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="number" name="stok" class="form-control form-control-sm" value="<?= $row['stok']; ?>" title="Ubah Jumlah Stok" style="width: 80px;">
                        <input type="number" name="limit_stok" class="form-control form-control-sm" value="<?= $row['limit_stok']; ?>" title="Ubah Limit" style="width: 80px;">
                        <button type="submit" name="update_stok" class="btn btn-sm btn-dark">Simpan</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>