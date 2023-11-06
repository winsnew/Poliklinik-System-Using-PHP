<?php
if (isset($_POST['simpan'])) {
    
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];
    if (isset($_POST['id_periksa'])) {
        $id_periksa = $_POST['id_periksa'];
        $query = "UPDATE periksa SET id_pasien='$id_pasien', id_dokter='$id_dokter', tgl_periksa='$tgl_periksa', catatan='$catatan', obat='$obat WHERE id_periksa=$id_periksa";
    } else {
        
        $query = "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat) VALUES ('$id_pasien', '$id_dokter', '$tgl_periksa', '$catatan', '$obat')";
    }
    
    
    if ($connection->query($query) === TRUE) {
        echo "Data pasien berhasil disimpan";
        header("Location: index.php?page=periksa"); 
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($connection, "DELETE FROM periksa WHERE id_periksa = '" . $_GET['id'] . "'");
    }  
    echo "<script> 
            document.location='index.php?page=periksa';
            </script>";
}
?>