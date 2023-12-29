<?php
session_start();
include_once('./connect/connect.php');
isset($_SESSION['username'])
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-md">
            <a class="navbar-brand" href="#">Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php?page=dokter">
                                    Dokter
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=pasien">
                                    Pasien
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=obat">
                                    Obat
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">
                            Periksa
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav float-md-end  mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['username'])) {
                ?>
                <li class="nav-item">
                    <span class="nav-link">Halo, <?php echo $_SESSION['username']; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <?php
                } else {
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php?page=register">
                            Register
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php?page=login">
                            login
                        </a>
                    </li>
                
                </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <main class="container-md" role="main">
        <?php
        if (isset($_GET['page'])) {
        ?>
            <h2><?php echo ucwords($_GET['page']) ?></h2>
        <?php
            include($_GET['page'] . ".php");
        } else {
            echo "Selamat Datang di Sistem Informasi Poliklinik";
        }
        ?>
        

    </main>
</body>

</html>





