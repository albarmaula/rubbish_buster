<?php


class CommentDB {
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $db = "rubbish_buster";
    private static $connection = null;

    public static function getConnection() {
        // Cek apakah koneksi sudah ada, jika ya, gunakan koneksi yang sudah ada
        if (self::$connection) {
            return self::$connection;
        }

        // Buat koneksi baru jika belum ada koneksi
        self::$connection = new mysqli(self::$host, self::$username, self::$password, self::$db);

        // Periksa apakah terjadi kesalahan dalam koneksi
        if (self::$connection->connect_error) {
            die("Koneksi ke database gagal: " . self::$connection->connect_error);
        }

        return self::$connection;
    }
}


?>
