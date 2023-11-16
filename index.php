<?php
include 'koneksi.php';
if (empty($_SESSION['user'])) {
    header('location: login.php');
}

if (isset($_POST['pembayaran'])) {
    $id_petugas = $_SESSION['user']['id_petugas'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $query = mysqli_query($koneksi, "INSERT INTO pembayaran(id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_dibayar,id_spp,jumlah_bayar) VALUES ('$id_petugas','$nisn','$tgl_bayar','$bulan_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')");
    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=laporan"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';
        $cek = preg_replace('/-/', ' ', $page);
        $title = ucwords($cek);
        echo $title;
        ?>
    </title>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php
        if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
        ?>
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar">
                    <a class="sidebar-brand" href="index.php">
                        <span class="align-middle">AdminKit</span>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="sidebar-header">
                            Halaman
                        </li>

                        <li class="sidebar-item <?php echo (empty($_GET['page']) ? 'active' : '') ?>">
                            <a class="sidebar-link" href="index.php">
                                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'petugas' || $page == 'tambah-petugas' || $page == 'edit-petugas'  ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=petugas">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Petugas</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'kelas' || $page == 'tambah-kelas' || $page == 'edit-kelas'  ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=kelas">
                                <i class="align-middle" data-feather="box"></i> <span class="align-middle">Kelas</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'siswa' || $page == 'tambah-siswa' || $page == 'edit-siswa'  ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=siswa">
                                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'spp' || $page == 'tambah-spp' || $page == 'edit-spp'  ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=spp">
                                <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">SPP</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'laporan' || $page == 'tambah-laporan' || $page == 'edit-laporan'  ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=laporan">
                                <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Laporan</span>
                            </a>
                        </li>
                    </ul>
                    <div class="sidebar-cta">
                        <div class="sidebar-cta-content">
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahpembayaran">
                                    + Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <?php
        } else {
            if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'petugas')) {
            ?>
                <nav id="sidebar" class="sidebar js-sidebar">
                    <div class="sidebar-content js-simplebar">
                        <a class="sidebar-brand" href="index.php">
                            <span class="align-middle">AdminKit</span>
                        </a>
                        <ul class="sidebar-nav">
                            <li class="sidebar-header">
                                Halaman
                            </li>

                            <li class="sidebar-item <?php echo (empty($_GET['page']) ? 'active' : '') ?>">
                                <a class="sidebar-link" href="index.php">
                                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo ($page == 'siswa' || $page == 'tambah-siswa' || $page == 'edit-siswa'  ? 'active' : '') ?>">
                                <a class="sidebar-link" href="?page=siswa">
                                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo ($page == 'laporan' || $page == 'tambah-laporan' || $page == 'edit-laporan'  ? 'active' : '') ?>">
                                <a class="sidebar-link" href="?page=laporan">
                                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Laporan</span>
                                </a>
                            </li>
                        </ul>
                        <div class="sidebar-cta">
                            <div class="sidebar-cta-content">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahpembayaran">
                                        + Pembayaran
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
        <?php
            }
        }
        ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <?php
                if (!empty($_SESSION['user']['level'])) {
                ?>
                    <a class="sidebar-toggle js-sidebar-toggle">
                        <i class="hamburger align-self-center"></i>
                    </a>
                <?php
                }
                ?>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark">
                                    <?php
                                    if (!empty($_SESSION['user']['level'])) {
                                        echo $_SESSION['user']['nama_petugas'];
                                    } else {
                                        echo $_SESSION['user']['nama'];
                                    }
                                    ?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="logout.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                    include $page . '.php';
                    ?>
                </div>
            </main>
        </div>
    </div>

    <script src="js/app.js"></script>

    <div class="modal fade" id="tambahpembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pembayaran</h1>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <select name="nisn" class="form-select">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM siswa");
                                while ($siswa = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $siswa['nisn'] ?>"><?php echo $siswa['nama'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tgl_bayar" class="form-control">
                        </div>
                        <input type="hidden" name="bulan_bayar" class="form-control" value="<?php echo date('F') ?>">
                        <input type="hidden" name="tahun_bayar" class="form-control" value="<?php echo date('Y') ?>">
                        <div class="mb-3">
                            <label class="form-label">SPP</label>
                            <select name="id_spp" class="form-select">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM spp");
                                while ($spp = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $spp['id_spp'] ?>"><?php echo $spp['tahun'] ?> - <?php echo $spp['nominal'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="text" name="jumlah_bayar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="pembayaran">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>