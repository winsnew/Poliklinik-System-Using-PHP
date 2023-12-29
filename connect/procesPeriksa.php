<?php
if (isset($_POST['simpan'])) {
    
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $biaya_periksa = $_POST['biaya_periksa'];
    if (isset($_POST['id_periksa'])) {
        $id_periksa = $_POST['id_periksa'];
        $query = "UPDATE periksa SET id_pasien='$id_pasien', id_dokter='$id_dokter', tgl_periksa='$tgl_periksa', catatan='$catatan', biaya_periksa='$biaya_periksa WHERE id_periksa=$id_periksa";
    } else {
        
        $query = "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan,  biaya_periksa) VALUES ('$id_pasien', '$id_dokter', '$tgl_periksa', '$catatan', '$biaya_periksa')";
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

if (isset($_GET['id_periksa']) && isset($_GET['aksi']) && $_GET['aksi'] == 'detail') {
    $id_periksa = $_GET['id_periksa'];

    // Fetch patient and examination details based on id_periksa
    $query = "SELECT pr.*, p.data_pasien 
              FROM periksa pr 
              LEFT JOIN pasien p ON (pr.id_pasien = p.id)
              WHERE pr.id_periksa = $id_periksa";

    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Display patient and examination details
        echo '<h2>Detail Periksa</h2>';
        echo '<p>Nama Pasien: ' . $data['data_pasien'] . '</p>';
        echo '<p>Tanggal Periksa: ' . $data['tgl_periksa'] . '</p>';
        // Add other details as needed
    } else {
        echo '<p>Data not found.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>