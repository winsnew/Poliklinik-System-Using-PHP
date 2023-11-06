<?php
    $server = 'localhost:3307';
    $username = 'root';
    $password = '';
    $database = 'poliklinik';

    $connection = new mysqli($server, $username, $password, $database);
    if ($connection->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>