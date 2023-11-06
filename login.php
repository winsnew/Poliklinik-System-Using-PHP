<?php
include_once('/xampp/htdocs/poliklinikUTS/connect/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan proses otentikasi sesuai dengan metode yang Anda tentukan
    // Contoh: 
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        // Set session atau cookie sesuai kebutuhan
        $_SESSION['username'] = $username;

        // Redirect ke halaman lain setelah login berhasil
        header("Location: index.php");
        exit();
    } else {
        echo "Username atau password salah";
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
  <button type="submit" name="login" class="btn btn-primary">Submit</button>
</form>
