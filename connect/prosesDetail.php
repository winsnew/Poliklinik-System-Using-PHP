<?php
// Check if the form is submitted


if (isset($_POST['simpan'])) {
    // Retrieve form data
    $id_periksa = $_POST['id_periksa'];
    $id_obat = $_POST['id_obat'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE detail_periksa SET id_periksa='$id_periksa', id_obat='$id_obat' WHERE id=$id";
    } else {
        $query = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
    }
    
    if ($connection->query($query) === TRUE) {
        echo "Data pasien berhasil disimpan";
        header("Location: index.php?page=periksa"); 
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}

// ... (rest of your existing code)
?>