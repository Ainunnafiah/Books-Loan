<?php

include_once "../controllers/BooksLoan.php";

$book = new BooksLoan();

$secret = $_POST['rahasia'] ?? '';
$is_admin = $secret === 'iincans';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog-Practice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

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