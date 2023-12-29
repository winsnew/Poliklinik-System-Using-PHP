<?php
include_once('./connect/connect.php');
include "./connect/processObat.php";


// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
}
?>

<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <?php
    $nama_obat = '';
    $kemasan = '';
    $harga = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($connection, 
        "SELECT * FROM obat
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $nama_obat = $row['nama_obat'];
            $kemasan = $row['kemasan'];
            $harga = $row['harga'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo
        $_GET['id'] ?>">
    <?php
    }
    ?>
    <div class="col">
     <div class="col">
        <label for="namaObat" class="form-label fw-bold">
            Nama Obat
        </label>
        <input type="text" class="form-control" name="nama_obat" id="inputNama" placeholder="Nama" value="<?php echo $nama_obat ?>">
    </div>
    <div class="col">
        <label for="inputKemasan" class="form-label fw-bold">
            Kemasan
        </label>
        <input type="text" class="form-control" name="kemasan" id="inputKemasan" placeholder="Kemasan" value="<?php echo $kemasan ?>">
    </div>
    <div class="col mb-2">
        <label for="inputHarga" class="form-label fw-bold">
            Harga
        </label>
        <input type="number" class="form-control" name="harga" id="inputHarga" placeholder="Harga" value="<?php echo $harga ?>">
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
            <th scope="col">Nama Obat</th>
            <th scope="col">Kemasan</th>
            <th scope="col">Harga</th>
            
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
        berdasarkan status dan tanggal awal-->
        <?php
        $result = mysqli_query(
            $connection,"SELECT * FROM obat "
            );
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['nama_obat'] ?></td>
                <td><?php echo $data['kemasan'] ?></td>
                <td><?php echo $data['harga'] ?></td>
                
                <td>
                    <a class="btn btn-info rounded-pill px-3" 
                    href="index.php?page=obat&id=<?php echo $data['id'] ?>">Ubah
                    </a>
                    <a class="btn btn-danger rounded-pill px-3" 
                    href="index.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
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