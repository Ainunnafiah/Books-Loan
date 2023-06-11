<?php
include_once '../models/Database.php';

class BooksLoan extends Database
{
    public function getBooks()
    {
        $query = "SELECT  * FROM buku";
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

    private function uploadImage($file)
    {
        // check extension file should be an image
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'png', 'jpeg'];
        if (!in_array($extension, $allowed)) {
            return 'default.png';
        }

        //check file size 
        // if ($file['size'] > 1000000) {
        //     return 'default.png';
        // }
        // generate file name
        $filename = rand();

        // move file to folder
        move_uploaded_file($file['tmp_name'], '../images/' . $filename . '.' . $extension);
        return  $filename . '.' . $extension;
    }

    public function createBook($data, $file)
    {
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $sinopsis = $data['sinopsis'];
        $gambar = 'default.png';

        if (isset($file['gambar']) && $file['gambar']['error'] === 0) {
            $gambar = $this->uploadImage($file['gambar']);
        }

        $query = "INSERT INTO buku (judul_buku, penulis_buku, sinopsis, gambar) VALUES ('$judul_buku', '$penulis_buku', '$sinopsis', '$gambar')";

        $insert = $this->runQuery($query);

        if (!$insert) {
            $this->getErrors();
            return null;
        }
        return $insert;
    }

    public function updateBook($data, $file)
    {
        $id = $data['id'];
        $before = $this->detailBook($id);
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $sinopsis = $data['sinopsis'];
        $gambar = $before['gambar'];

        if (isset($file['gambar']) && $file['gambar']['error'] === 0) {
            if ($gambar !== 'default.png') {
                unlink('../images/' . $gambar);
            }
            $gambar = $this->uploadImage($file['gambar']);
        }

        $query = "UPDATE buku SET judul_buku = '$judul_buku', penulis_buku = '$penulis_buku', sinopsis = '$sinopsis', gambar='$gambar' WHERE id = $id";

        $update = $this->runQuery($query);
        if (!$update) {
            $this->getErrors();
            return null;
        }
        return $update;
    }

    public function deleteBook($id)
    {
        $detail = $this->detailBook($id);
        if ($detail === null) {
            echo "<div>
            <script>
            alert('ID Buku tidak ditemukan');
            window.location.href = '../views/daftar-buku.php';
            </script>
            </div>";
            return;
        }

        // hapus gambarnya dulu supaya tidak jadi ainun
        if ($detail['gambar'] !== 'default.png') {
            unlink('../images/' . $detail['gambar']);
        }

        $this->runQuery("DELETE FROM pinjaman WHERE id_buku = $id");
        $isSucces = $this->runQuery("DELETE FROM buku WHERE id = '$id'");

        if ($isSucces) {
            echo "<div>
        <script>
        alert('Berhasil Menghapus Data');
        window.location.href = '../views/daftar-buku.php';
        </script>
        </div>";
        } else {
            $this->getErrors();
        }
    }

    public function detailBookPinjam($id)
    {
        $data = $this->runSelectQuery("SELECT * FROM pinjaman WHERE id_buku = $id");
        return $data;
    }

    public function pinjamBuku($data)
    {
        $id_buku = $data['id_buku'];
        $nama = $data['nama'];
        $tanggal_pinjam = $data['tanggal_pinjam'];

        $result = $this->runQuery("INSERT INTO 
            pinjaman(nama, tanggal_pinjam, id_buku) 
        VALUES
            ('$nama', '$tanggal_pinjam', '$id_buku')
        ");

        if ($result) {
            echo "
                <script>
                    alert('Berhasil meminjam buku');
                    window.location.href = '../views/detail-buku.php?id=$id_buku';
                </script>
            ";
        } else {
            echo $this->getErrors();
        }
    }
}

// buat instance BooksLoan untuk digunakan di bawah
$book = new BooksLoan();

if (isset($_POST['inserting'])) {
    $books = $book->createBook([
        'judul_buku' => $_POST['judul_buku'],
        'penulis_buku' => $_POST['penulis_buku'],
        'sinopsis' => $_POST['sinopsis'],
    ], $_FILES);

    if ($books) {
        echo "<div>
        <script>
        alert('berhasil menambahkan buku')
        window.location.href = '../views/daftar-buku.php'
        </script>
        </div>";
    } else {
        $this->getErrors();
    }
    exit;
}

if (isset($_POST['id']) && (isset($_POST['updating']))) {
    $books = $book->updateBook([
        'id' => $_POST['id'],
        'judul_buku' => $_POST['judul_buku'],
        'penulis_buku' => $_POST['penulis_buku'],
        'sinopsis' => $_POST['sinopsis'],
    ], $_FILES);

    if ($books) {
        echo "<div>
        <script>
        alert('berhasil mengedit buku')
        window.location.href = '../views/daftar-buku.php'
        </script>
        </div>";
    } else {
        $this->getErrors();
    }
    exit;
}

if (isset($_GET['id']) && isset($_GET['deleting'])) {
    $books = $book->deleteBook($_GET['id']);
    exit;
}

if (isset($_POST['lagi_minjem']) && isset($_POST['id_buku'])) {
    $book->pinjamBuku([
        'id_buku' => $_POST['id_buku'],
        'nama' => $_POST['nama'],
        'tanggal_pinjam' => $_POST['tanggal_pinjam'],
    ]);
    exit;
}
