<?php
if (isset($_POST['simpan'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $password = md5($_POST['password']);
    $username = $_POST['username'];
    $level = $_POST['level'];

    $query = mysqli_query($koneksi, "INSERT INTO petugas (nama_petugas,password,username,level) VALUES ('$nama_petugas','$password','$username','$level')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=petugas"</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $password = md5($_POST['password']);
    $username = $_POST['username'];
    $level = $_POST['level'];

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas='$nama_petugas',username='$username',level='$level' WHERE id_petugas='$id_petugas'");
        if ($query) {
            echo '<script>alert("Data Berhasil di Edit");location.href="?page=petugas"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas='$nama_petugas',password='$password',username='$username',level='$level' WHERE id_petugas='$id_petugas'");
        if ($query) {
            echo '<script>alert("Data Berhasil di Edit");location.href="?page=petugas"</script>';
        }
    }
}
if (isset($_POST['hapus'])) {
    $id_petugas = $_POST['id_petugas'];

    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id_petugas'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=petugas"</script>';
    }
}
if (empty($_SESSION['user']['level'] == 'admin')) {
?>
    <script>
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3">Petugas</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahpetugas">
                    +Tambah Petugas
                </button>
                <table class="table table-bordered table-striped table-hover cell-border" id="petugas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['username'] ?></td>
                                <td><?php echo $data['level'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editpetugas<?php echo $data['id_petugas'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuspetugas<?php echo $data['id_petugas'] ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editpetugas<?php echo $data['id_petugas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Petugas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                    <label class="form-label">Nama Petugas</label>
                                                    <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Level</label>
                                                    <select name="level" class="form-select">
                                                        <option value="">Pilih</option>
                                                        <option value="admin" <?php if ($data['level'] == 'admin') {
                                                                                    echo 'selected';
                                                                                } ?>>Admin</option>
                                                        <option value="petugas" <?php if ($data['level'] == 'petugas') {
                                                                                    echo 'selected';
                                                                                } ?>>Petugas</option>
                                                    </select>
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
                            <div class="modal fade" id="hapuspetugas<?php echo $data['id_petugas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Petugas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Nama Petugas - <?php echo $data['nama_petugas'] ?>
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
    let table = new DataTable('#petugas');
</script>
<div class="modal fade" id="tambahpetugas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Petugas</h1>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
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