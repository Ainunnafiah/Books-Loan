<?php

class Database {
    private function connect(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'books_loan');
        return $koneksi;
    }
    public function runQuery($query){
        $connection = $this->connect();
        $result = mysqli_query($connection, $query);
        return $result;
    }
    public function runSelectQuery($query){
        $data = [];
        $result = $this->runQuery($query);
        while ($res = mysqli_fetch_assoc($result)) {
            array_push($data, $res);
        }
        return $data;
    }
    public function getErrors(){
        echo mysqli_error($this->connect());
}
}

?>