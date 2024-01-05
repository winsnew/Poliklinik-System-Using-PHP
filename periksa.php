<?php
include("./connect/connect.php");
include "./connect/procesPeriksa.php";

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
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
            <select class="form-control" name="id_pasien">
                <?php
                $selected = '';
                $pasien = mysqli_query($connection, "SELECT * FROM pasien");
                while ($data = mysqli_fetch_array($pasien)) {
                    if ($data['id'] == $id) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['data_pasien'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputDokter" class="sr-only">Dokter</label>
            <select class="form-control" name="id_dokter">
                <?php
                $selected = '';
                $dokter = mysqli_query($connection, "SELECT * FROM dokter");
                while ($data = mysqli_fetch_array($dokter)) {
                    if ($data['id'] == $id) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputTanggal" class="sr-only">Tanggal Periksa</label>
            <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" placeholder="tgl periksa" value="<?php echo $tgl_periksa ?>">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputTanggal" class="sr-only">Catatan</label>
            <input type="text" class="form-control" name="catatan" id="catatan" placeholder="catatan" value="<?php echo $catatan ?>">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputTanggal" class="sr-only">Biaya Periksa</label>
            <input type="text" class="form-control" name="biaya_periksa" id="biaya" placeholder="biaya" value="<?php echo $biaya_periksa ?>">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <button type="submit" class="btn btn-primary rounded-pill px-3 pl-4" name="simpan">Simpan</button>
        </div>
    </div>
</form>
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Tanggal Periksa</th>
            <th scope="col">Catatan</th>
            <th scope="col">Biaya</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <?php        
        $result = mysqli_query($connection, "SELECT pr.*, d.nama as 'nama_dokter', p.data_pasien as 'nama_pasien', SUM(o.harga) as 'biaya_obat_total' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) LEFT JOIN detail_periksa dp ON (pr.id_periksa=dp.id_periksa) LEFT JOIN obat o ON (dp.id_obat=o.id) GROUP BY pr.id_periksa ORDER BY pr.tgl_periksa DESC");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['nama_pasien'] ?></td>
                <td><?php echo $data['nama_dokter'] ?></td>
                <td><?php echo $data['tgl_periksa'] ?></td>
                <td><?php echo $data['catatan'] ?></td>
                <td><?php echo $data['biaya_periksa'] + $data['biaya_obat_total'] ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id_periksa'] ?>">
                        Ubah</a>
                    <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id_periksa'] ?>&aksi=hapus">Hapus</a>
                    <a class="btn btn-danger rounded-pill px-3" href="index.php?page=detail&id_periksa=<?php echo $data['id_periksa'] ?>">Detail</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
// Menutup koneksi
$connection->close();
?>