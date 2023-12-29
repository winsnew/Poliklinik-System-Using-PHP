<?php
include_once('./connect/connect.php');


if (!isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
}


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

?>
<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <div class="col">
    <?php
    $id_periksa = '';
    $id_pasien = '';
    $id_dokter = '';
    $tgl_periksa = '';
    $catatan = '';
    $biaya_periksa = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($connection,
            "SELECT * FROM periksa 
            WHERE id_periksa='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $id_periksa = $row['id_periksa'];
            $id_pasien = $row['id_pasien'];
            $id_dokter = $row['id_dokter'];
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
            $biaya_periksa = $row['biaya_periksa'];
        }
    ?>
        <input type="hidden" name="id_periksa" value="<?php echo $id_periksa; ?>">
    <?php
    }
    ?>
    <div class="form-group mx-sm-3 mb-2">
        <label for="inputPasien" class="sr-only">Pasien</label>
        $selectedPasienId = $id_pasien; // Use the selected patient ID
$pasien_query = "SELECT id, data_pasien FROM pasien";
$pasien_result = mysqli_query($connection, $pasien_query);

echo '<input class="form-control" name="id_pasien" list="pasienList">';
echo '<datalist id="pasienList">';

while ($data = mysqli_fetch_array($pasien_result)) {
    $selected = ($data['id'] == $selectedPasienId) ? 'selected="selected"' : '';
    echo '<option value="' . $data['data_pasien'] . '" ' . $selected . '></option>';
}

echo '</datalist>';
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
    <?php
        $result = mysqli_query($connection, "SELECT pr.*, p.data_pasien as 'nama_pasien', SUM(o.harga) as 'biaya_obat'
                    FROM periksa pr 
                    LEFT JOIN pasien p ON (pr.id_pasien=p.id)
                    LEFT JOIN detail_periksa dp ON (pr.id_periksa = dp.id_periksa)
                    LEFT JOIN obat o ON (dp.id_obat = o.id)
                    WHERE pr.id_periksa = $id_periksa
                    GROUP BY pr.id_periksa
                    ORDER BY pr.tgl_periksa DESC");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
            $biaya_total = $data['biaya_periksa'] + $data['biaya_obat'];
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['nama_pasien'] ?></td>
                <td><?php echo $data['tgl_periksa'] ?></td>
                <td><?php echo $data['biaya_obat'] ?></td>
                <td><?php echo $biaya_total ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id_periksa'] ?>">
                        Ubah</a>
                    <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id_periksa'] ?>&aksi=hapus">Hapus</a>
                    <a class="btn btn-danger rounded-pill px-3" href="index.php?page=detail&id=<?php echo $data['id_periksa'] ?>&aksi=detail">Detail</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php
// Close the database connection
$connection->close();
?>
