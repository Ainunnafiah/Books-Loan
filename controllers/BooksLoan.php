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

    public function detailBooks($id)
    {
        $data = $this->runSelectQuery("SELECT * FROM blog WHERE id = $id");
        if (count($data) === 0) {
            return null;
        } else {
            return $data[0];
        }
    }

    public function createBook() {
        $judul_buku = $_POST['judul_buku'];
        $penulis_buku = $_POST['penulis_buku'];
        $sinopsis = $_POST['sinopsis'];
        $gambar = $_POST['gambar'];

        $query = "INSERT INTO buku (judul_buku, penulis_buku, sinopsis, gambar VALUES '$judul_buku', '$penulis_buku', '$sinopsis', '$gambar')";

        $insert = $this->runQuery($query);
        return $insert;

    }
}
