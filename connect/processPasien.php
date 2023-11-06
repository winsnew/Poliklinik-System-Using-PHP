<?php
if (isset($_POST['simpan'])) {
    
    $data_pasien = $_POST['data_pasien'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE pasien SET data_pasien='$data_pasien', alamat='$alamat', nohp='$nohp' WHERE id=$id";
    } else {
        // Jika tidak ada data ID, maka kita insert data baru
        $query = "INSERT INTO pasien (data_pasien, alamat, nohp) VALUES ('$data_pasien', '$alamat', '$nohp')";
    }
    
    
    if ($connection->query($query) === TRUE) {
        echo "Data pasien berhasil disimpan";
        
        
        header("Location: index.php?page=pasien"); 
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($connection, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }  
    echo "<script> 
            document.location='index.php?page=pasien';
            </script>";
}
?>