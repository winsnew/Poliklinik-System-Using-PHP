<?php
include_once('./connect/connect.php');
include './connect/prosesDetail.php';

if (!isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
}


// Include your database connection file here if not already included
// Include "config.php" or something similar

if (isset($_GET['id_periksa'])) {
    $id_periksa = $_GET['id_periksa'];

    // Fetch details of the examination
    $result_detail = mysqli_query($connection, "SELECT pr.*, d.nama as 'nama_dokter', p.data_pasien as 'nama_pasien' 
                                                FROM periksa pr 
                                                LEFT JOIN dokter d ON (pr.id_dokter = d.id) 
                                                LEFT JOIN pasien p ON (pr.id_pasien = p.id) 
                                                WHERE pr.id_periksa = $id_periksa");
    $data_detail = mysqli_fetch_array($result_detail);

    // Fetch medication details related to the examination
    $result_meds = mysqli_query($connection, "SELECT * FROM detail_periksa WHERE id_periksa = $id_periksa");
    // You can fetch more details about medications if needed

} else {
    // Handle the case where no ID is provided
    echo "Invalid request. Please provide a valid ID.";
    exit();
}
?>

<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <div class="col">
    <?php
    $id_periksa = '';
    $id_obat = '';

    if (isset($_GET['id_periksa'])) {
        $ambil = mysqli_query($connection,
            "SELECT pr.*, d.nama as 'nama_dokter', p.data_pasien as 'nama_pasien'
            FROM periksa pr
            LEFT JOIN dokter d ON (pr.id_dokter = d.id)
            LEFT JOIN pasien p ON (pr.id_pasien = p.id) 
            WHERE pr.id_periksa='" . $_GET['id_periksa'] . "'");

        if ($ambil) {
            $row = mysqli_fetch_array($ambil);
            $id_periksa = $row['id_periksa'];
            $id_obat = $row['id_obat'];
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    ?>
        <input type="hidden" name="id_periksa" value="<?php echo $_GET['id_periksa']; ?>">
    <?php
    }
    ?>
    <div class="form-group mx-sm-3 mb-2">
        <label for="inputPasien" class="sr-only">Pasien</label>
        <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama" disabled value="<?php echo $data_detail['nama_pasien']; ?>">
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <label for="id_obat">Pilih Obat:</label>
        <select name="id_obat" class="form-control">
            <?php
            $obat_query = "SELECT id, nama_obat FROM obat";
            $result = mysqli_query($connection, $obat_query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id'] . '">' . $row['nama_obat'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <button type="submit" class="btn btn-primary rounded-pill px-3 pl-4" name="simpan">Simpan</button>
    </div>
</form>
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Tanggal Periksa</th>
            <th scope="col">Biaya Obat</th>
            <th scope="col">Biaya Total</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
    
    </tbody>
</table>

<?php
// Close the database connection
$connection->close();
?>
