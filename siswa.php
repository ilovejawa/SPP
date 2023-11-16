<?php
if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    $cecknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $cecknis = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
    if (mysqli_num_rows($cecknisn) > 0 && mysqli_num_rows($cecknisn) > 0) {
        echo '<script>alert("NISN & NIS sudah digunakan");location.href="?page=siswa"</script>';
    } elseif (mysqli_num_rows($cecknisn) > 0) {
        echo '<script>alert("NISN sudah digunakan");location.href="?page=siswa"</script>';
    } elseif (mysqli_num_rows($cecknis) > 0) {
        echo '<script>alert("NIS sudah digunakan");location.href="?page=siswa"</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn,nis,nama,password,id_kelas,alamat,no_telp) VALUES ('$nisn','$nis','$nama','$password','$id_kelas','$alamat','$no_telp')");

        if ($query) {
            echo '<script>alert("Data Berhasil di Tambah");location.href="?page=siswa"</script>';
        }
    }
}

if (isset($_POST['edit'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama='$nama',id_kelas='$id_kelas',alamat='$alamat',no_telp='$no_telp' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data Berhasil di Edit");location.href="?page=siswa"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama='$nama',password='$password',id_kelas='$id_kelas',alamat='$alamat',no_telp='$no_telp' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data Berhasil di Edit");location.href="?page=siswa"</script>';
        }
    }
}
if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];

    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=siswa"</script>';
    }
}
if (empty($_SESSION['user']['level'])) {
?>
    <script>
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3">Siswa</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahsiswa">
                        +Tambah Siswa
                    </button>
                <?php
                }
                ?>

                <table class="table table-bordered table-striped table-hover cell-border" id="siswa">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Nama Kelas</th>
                            <th>Kompetensi Keahlian</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editsiswa<?php echo $data['nisn'] ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapussiswa<?php echo $data['nisn'] ?>">
                                            Delete
                                        </button>
                                        <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-info btn-sm">History</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-info btn-sm">History</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="editsiswa<?php echo $data['nisn'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Siswa</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldnisn" value="<?php echo $data['nisn'] ?>">
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" name="nisn" class="form-control" value="<?php echo $data['nisn'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIS</label>
                                                    <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelas dan Jurusan</label>
                                                    <select name="id_kelas" class="form-select" required>
                                                        <?php
                                                        $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                        while ($kelas = mysqli_fetch_array($query1)) {
                                                        ?>
                                                            <option value="<?php echo $kelas['id_kelas'] ?>" <?php if ($data['id_kelas'] == $kelas['id_kelas']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>>
                                                                <?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No Telp</label>
                                                    <input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp'] ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="edit">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="hapussiswa<?php echo $data['nisn'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Siswa</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="nisn" value="<?php echo $data['nisn'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Nama Siswa - <?php echo $data['nama'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="hapus">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let table = new DataTable('#siswa');
</script>
<div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Siswa</h1>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas dan Jurusan</label>
                        <select name="id_kelas" class="form-select" required>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <option value="<?php echo $data['id_kelas'] ?>"><?php echo $data['nama_kelas'] ?> - <?php echo $data['kompetensi_keahlian'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>