<?php
include_once('/xampp/htdocs/poliklinikUTS/connect/connect.php');
include "/xampp/htdocs/poliklinikUTS/connect/processPasien.php";


// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
}
?>
<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <!-- Kode php untuk menghubungkan form dengan database -->
    <?php
    $data_pasien = '';
    $alamat = '';
    $nohp = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($connection, 
        "SELECT * FROM pasien 
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $data_pasien = $row['data_pasien'];
            $alamat = $row['alamat'];
            $nohp = $row['nohp'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo
        $_GET['id'] ?>">
    <?php
    }
    ?>
    <div class="col">
    <div class="col">
        <label for="inputIsi" class="form-label fw-bold">
            Nama Pasien
        </label>
        <input type="text" class="form-control" name="data_pasien" id="data_pasien" placeholder="Nama" value="<?php echo $data_pasien ?>">
    </div>
    <div class="col">
        <label for="inputAlamat" class="form-label fw-bold">
            Alamat
        </label>
        <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
    </div>
    <div class="col mb-2">
        <label for="inputNoHp" class="form-label fw-bold">
        No_HP
        </label>
        <input type="text" class="form-control" name="nohp" id="nohp" placeholder="No Hp" value="<?php echo $nohp ?>">
    </div>
    <div class="col">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
    </div>
    </div>
</form>
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Alamat</th>
            <th scope="col">No_HP</th>
            
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
        berdasarkan status dan tanggal awal-->
        <?php
        $result = mysqli_query(
            $connection,"SELECT * FROM pasien "
            );
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['data_pasien'] ?></td>
                <td><?php echo $data['alamat'] ?></td>
                <td><?php echo $data['nohp'] ?></td>
                
                <td>
                    <a class="btn btn-info rounded-pill px-3" 
                    href="index.php?page=pasien&id=<?php echo $data['id'] ?>">Ubah
                    </a>
                    <a class="btn btn-danger rounded-pill px-3" 
                    href="index.php?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                    </a>
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