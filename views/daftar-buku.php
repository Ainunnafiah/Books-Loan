<?php

include_once "../controllers/BooksLoan.php";

$book = new BooksLoan();

$secret = $_POST['rahasia'] ?? '';
$is_admin = $secret === 'iincans';

$title = "Daftar Buku";

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once "./templates/head.php"; ?>

<body>
  <div class="container">
    <div class="mb-1">
      <?php if ($is_admin) : ?>
        <a href="add-book.php" class="btn btn-primary">Tambah Buku</a>
    </div>
  <?php else : ?>
    <form action="" method="post">
      <div class="mb-3">
        <input type="password" class="form-control" name="rahasia" placeholder="Masukkan password dan enter untuk menambahkan buku">
      </div>
    </form>
  <?php endif; ?>
  <div class="row">
    <?php foreach ($book->getBooks() as $key) : ?>
      <div class="col-4 mb-1">
        <div class="card">
          <img src="../images/<?= $key['gambar']; ?>" class="card-img-top" style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover;" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?= $key['judul_buku']; ?></h5>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tristique tortor in interdum pretium. Suspendisse ultrices gravida bibendum.</p>
            <a href="detail-buku.php?id=<?= $key['id']; ?>" class="btn btn-primary">Detail Book</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  </div>
  </div>
</body>

</html>