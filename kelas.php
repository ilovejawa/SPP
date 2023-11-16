<?php
if (isset($_POST['simpan'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];

    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES ('$nama_kelas','$kompetensi_keahlian')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=kelas"</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];

    $query = mysqli_query($koneksi, "UPDATE kelas SET id_kelas='$id_kelas',nama_kelas='$nama_kelas',kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id_kelas'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Edit");location.href="?page=kelas"</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_kelas = $_POST['id_kelas'];

    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=kelas"</script>';
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

<h1 class="h3 mb-3">Kelas</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahkelas">
                    +Tambah Kelas
                </button>
                <table class="table table-bordered table-striped table-hover cell-border" id="kelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Kompetensi Keahlian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editkelas<?php echo $data['id_kelas'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuskelas<?php echo $data['id_kelas'] ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editkelas<?php echo $data['id_kelas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Kelas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kelas</label>
                                                    <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kompetensi Keahlian</label>
                                                    <input type="text" name="kompetensi_keahlian" class="form-control" value="<?php echo $data['kompetensi_keahlian'] ?>">
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
                            <div class="modal fade" id="hapuskelas<?php echo $data['id_kelas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Kelas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Nama Kelas - <?php echo $data['nama_kelas'] ?>
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
    let table = new DataTable('#kelas');
</script>
<div class="modal fade" id="tambahkelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kelas</h1>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kompetensi Keahlian</label>
                        <input type="text" name="kompetensi_keahlian" class="form-control" required>
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