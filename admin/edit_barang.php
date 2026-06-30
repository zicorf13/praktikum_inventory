<?php
session_start();
include '../koneksi.php';

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak");
}

$id = $_GET['id'];

$data = mysqli_query($koneksi, "
SELECT * FROM barang
WHERE id='$id'
");

$row = mysqli_fetch_assoc($data);

$status = mysqli_query(
    $koneksi,
    " SELECT * FROM status_barang"
);

$penyimpanan = mysqli_query(
    $koneksi,
    "SELECT * FROM penyimpanan"
);

if (isset($_POST['update'])) {

    $nama           = $_POST['nama'];
    $status_id      = $_POST['status'];
    $penyimpanan_id = $_POST['penyimpanan'];
    $harga          = $_POST['harga'];

    mysqli_query($koneksi, "
    UPDATE barang SET

    nama_barang='$nama',
    status_id='$status_id',
    penyimpanan_id='$penyimpanan_id',
    harga_barang='$harga'

    WHERE id='$id'
    ");

    echo "
    <script>
        alert('Data berhasil diupdate');
        window.location='index.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Barang</title>

    <link rel="stylesheet" href="../AdminLTE-4.0.0-rc7/dist/css/adminlte.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card card-warning card-outline">

                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Barang
                        </h3>
                    </div>

                    <form method="POST">

                        <div class="card-body">

                            <!-- Nama Barang -->
                            <div class="mb-3">

                                <label>Nama Barang</label>

                                <input type="text" name="nama" class="form-control" value="<?= $row['nama_barang']; ?>"
                                    required>

                            </div>

                            <!-- Status -->
                            <div class="mb-3">

                                <label>Status Barang</label>

                                <select name="status" class="form-control">

                                    <?php
                                    while ($s = mysqli_fetch_assoc($status)) {
                                    ?>

                                        <option value="<?= $s['id']; ?>" <?php
                                                                            if ($row['status_id'] == $s['id']) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>>

                                            <?= $s['nama_status']; ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- Penyimpanan -->
                            <div class="mb-3">

                                <label>Penyimpanan</label>

                                <select name="penyimpanan" class="form-control">

                                    <?php
                                    while ($p = mysqli_fetch_assoc($penyimpanan)) {
                                    ?>

                                        <option value="<?= $p['id']; ?>" <?php
                                                                            if ($row['penyimpanan_id'] == $p['id']) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>>

                                            <?= $p['nama_penyimpanan']; ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- Harga -->
                            <div class="mb-3">

                                <label>Harga Barang</label>

                                <input type="number" name="harga" class="form-control"
                                    value="<?= $row['harga_barang']; ?>" required>

                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit" name="update" class="btn btn-warning">

                                Update

                            </button>

                            <a href="dashboard.php" class="btn btn-secondary">

                                Kembali

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>