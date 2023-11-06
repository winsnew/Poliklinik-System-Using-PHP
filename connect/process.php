<?php

if (isset($_POST['simpan'])) {
    
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE dokter SET nama='$nama', alamat='$alamat', nohp='$nohp' WHERE id=$id";
    } else {
        
        $query = "INSERT INTO dokter (nama, alamat, nohp) VALUES ('$nama', '$alamat', '$nohp')";
    }

    
    if ($connection->query($query) === TRUE) {
        echo "Data dokter berhasil disimpan";
        header("Location: index.php?page=dokter");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($connection, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }  
    echo "<script> 
            document.location='index.php?page=dokter';
            </script>";
}


