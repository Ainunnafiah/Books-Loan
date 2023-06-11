<?php

include_once '../controllers/BooksLoan.php';

$buku = new BooksLoan();
$detail = $buku->detailBook($_GET['id']);
$secret = $_POST['rahasia'] ?? '';

$is_admin = $secret === 'iincans';

if ($detail === null) {
    echo "<script>
        window.location.href = '../views/daftar-buku.php'
    </script>";
}

$dataPeminjam = $buku->detailBookPinjam($_GET['id']);

$title = "Buku " . $detail['judul_buku'];

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once "./templates/head.php"; ?>

<body>
    <div class="container">
        <a href='daftar-buku.php'> Back </a href>
        <div class="row">
            <div class="col-6">
                <img src="../images/<?= $detail['gambar']; ?>" class="card-img-top" style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover;" alt="...">
            </div>

            <div class="col-6 mt-5">
                <h3><?php echo $detail['judul_buku'] ?></h3>
                <h6><?php echo $detail['sinopsis'] ?></h6>
                <?php if ($is_admin) : ?>
                    <a onclick="return confirm('Yakin hapus nehh?')" class="btn btn-sm btn-danger" href="../controllers/BooksLoan.php?id=<?= $_GET['id']; ?>&deleting=true">Hapus Buku</a>
                <?php else : ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="password" class="form-control" name="rahasia" placeholder="Masukkan password dan enter untuk menghapus buku">
                        </div>
                    </form>
                <?php endif; ?>

                <form action="../controllers/BooksLoan.php" class="mt-4" method="post">
                    <h4>Pinjam Buku</h4>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="name@example.com">
                    </div>
                    <input type="hidden" name="id_buku" value="<?= $detail['id']; ?>" />
                    <input type="hidden" name="tanggal_pinjam" value="<?= date('Y-m-d'); ?>">
                    <input type="hidden" name="lagi_minjem" value="true" />
                    <button type="submit" class="btn btn-primary btn-sm">Pinjam</button>
                </form>
            </div>

            <table class="table">
                <thead>
                    <tr class="bg-secondary">
                        <th> No </th>
                        <th> Nama </th>
                        <th> Tanggal Pinjam </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i = 0; $i < count($dataPeminjam); $i++) : ?>
                        <?php $currentData = $dataPeminjam[$i] ?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td><?= $currentData['nama']; ?></td>
                            <td><?= $currentData['tanggal_pinjam']; ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>