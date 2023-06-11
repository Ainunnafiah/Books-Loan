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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
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