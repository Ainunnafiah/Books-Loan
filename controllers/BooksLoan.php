<?php
include_once '../models/Database.php';

class BooksLoan extends Database
{
    public function getBooks()
    {
        $query = "SELECT 
        buku.id,
        buku.judul_buku,
        buku.penulis_buku,
        buku.sinopsis,
        buku.gambar,
        pinjaman.id,
        pinjaman.nama,
        pinjaman.id_buku,
        pinjaman.tanggal_pinjam,
        member.id
        member.nama,
        member.alamat,
        member.tanggal_lahir,
        member.no_hp,
        member.email,
        FROM books_loan
        ";

        $data = $this->runSelectQuery($query);
        return $data;
    }

    public function detailBook($id)
    {
        $data = $this->runSelectQuery("SELECT * FROM buku WHERE id = $id");
        if (count($data) === 0) {
            return null;
        } else {
            return $data[0];
        }
    }

    public function createBook($data)
    {
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $sinopsis = $data['sinopsis'];
        $gambar = $data['gambar'];

        $query = "INSERT INTO buku (judul_buku, penulis_buku, sinopsis, gambar) VALUES ('$judul_buku', '$penulis_buku', '$sinopsis', '$gambar')";

        $insert = $this->runQuery($query);

        if (!$insert) {
            return $this->getErrors();
        }
        return $insert;
    }

    public function updateBook($data)
    {
        $id = $data['id'];
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $sinopsis = $data['sinopsis'];
        $gambar = $data['gambar'];

        $query = "UPDATE buku SET judul_buku = '$judul_buku', penulis_buku = '$penulis_buku', sinopsis = '$sinopsis', gambar='$gambar' WHERE id = $id";

        $update = $this->runQuery($query);
        if (!$update) {
            return $this->getErrors();
        }
        return $update;
    }
}
$book = new BooksLoan();
if (isset($_POST['inserting'])) {
    $book->createBook([
        'judul_buku' => $_POST['judul_buku'],
        'penulis_buku' => $_POST['penulis_buku'],
        'sinopsis' => $_POST['sinopsis'],
        'gambar' => $_POST['gambar']
    ]);
    exit;

}

if (isset($_POST['id']) && (isset($_POST['updating']))){
    $book->updateBook([
        'id' => $_POST['id'],
        'judul_buku' => $_POST['judul_buku'],
        'penulis_buku' => $_POST['penulis_buku'],
        'sinopsis' => $_POST['sinopsis'],
        'gambar' => $_POST['gambar']

    ]);
}