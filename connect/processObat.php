<?php

if (isset($_POST['simpan'])) {
    
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];

    
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE obat SET nama_obat='$nama_obat', kemasan='$kemasan', harga='$harga' WHERE id=$id";
    } else {
        
        $query = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan', '$harga')";
    }

    
    if ($connection->query($query) === TRUE) {
        
        header("Location: index.php?page=obat");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($connection, "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'");
    }  
    echo "<script> 
            document.location='index.php?page=obat';
            </script>";
}


