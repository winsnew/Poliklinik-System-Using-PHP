<?php
include_once('/xampp/htdocs/poliklinikUTS/connect/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Jika username belum digunakan, proses registrasi berjalan
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $insert_result = mysqli_query($connection, $insert_query);

        if ($insert_result) {
            echo "Registrasi berhasil. Silakan login.";
            header("Location: index.php?page=login");
        } else {
            echo "Registrasi gagal. Kesalahan: " . mysqli_error($connection);
        }
    }
}

// Menutup koneksi
$connection->close();
?>

<form method="POST" action="" name="myForm" onsubmit="return(validate());">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control"  required>
    
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control"  required>
  </div>
  <button type="submit" name="register" class="btn btn-primary">Submit</button>
</form>
