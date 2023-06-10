<?php

include_once "../controllers/BooksLoan.php";

$book = new BooksLoan();

// persiapkan data utk dimasukkan kedalam </input>
$data = [
    'judul_buku' => '',
    'penulis_buku' => '',
    'sinopsis' => '',
    'gambar' => ''
];

// cek apakah ada query string (kode line 8-13)
if (isset($_GET['id'])) {
    // set data diedit
    $detail = $book->detailBook(($_GET['id']));
    if ($detail != null) {
        $data['judul_buku'] = $detail['judul_buku'];
        $data['penulis_buku'] = $detail['penulis_buku'];
        $data['sinopsis'] = $detail['sinopsis'];
        $data['gambar'] = $detail['gambar'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
</head>

<body>
    <div class='container'>
        <form class='mt-5' action='../controllers/BooksLoan.php' method='post' enctype="multipart/form-data">
            <h1 class='mb-3'>Form Add Book</h1>

            <?php if (isset($_GET['id'])) : ?>
                <input type="hidden" name='updating' value='true'>
                <input type="hidden" name='id' value='<?= $_GET['id'] ?>'>

            <?php else : ?>
                <input type="hidden" name="inserting" value="true"></input>

            <?php endif; ?>

            <div class="mb-1 row">
                <label for="judul_buku" class="col-sm-2 col-form-label"> Judul Buku </label>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' name='judul_buku' value='<?php echo $data['judul_buku'] ?>' placeholder="Masukkan judul buku"></input>
                </div>
            </div>

            <div class="mb-1 row">
                <label for="penulis" class="col-sm-2 col-form-label"> Penulis </label>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' name='penulis_buku' value='<?php echo $data['penulis_buku'] ?>' placeholder="Masukkan judul buku"></input>
                </div>
            </div>

            <div class="mb-1 row">
                <label for="sinopsis" class="col-sm-2 col-form-label"> Sinopsis </label>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' name='sinopsis' value='<?php echo $data['sinopsis'] ?>' placeholder="Masukkan judul buku"></input>
                </div>
            </div>

            <!-- <div class="mb-1 row">
                <label for="gambar" class="col-sm-2 col-form-label"> Cover </label>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' name='gambar' value='<?php echo $data['gambar'] ?>' placeholder="Masukkan judul buku"></input>
                </div>
            </div> -->

            <div class="mb-1 row">
                <label for="gambar"> Cover </label>
                <input id="gambar" name="gambar" type="file" />
            </div>

            <div class="mb-1">
                <button type="submit" class="btn btn-primary"> Submit </button>
            </div>

        </form>
    </div>

</body>

</html>