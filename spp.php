<?php
if (isset($_POST['simpan'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES ('$tahun','$nominal')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=spp"</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "UPDATE spp SET id_spp='$id_spp',tahun='$tahun',nominal='$nominal' WHERE id_spp='$id_spp'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Edit");location.href="?page=spp"</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];

    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=spp"</script>';
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

<h1 class="h3 mb-3">SPP</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahspp">
                    +Tambah SPP
                </button>
                <table class="table table-bordered table-striped table-hover cell-border" id="spp">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nominal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['tahun'] ?></td>
                                <td>Rp <?php echo number_format($data['nominal'], 2, ",", ".") ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editspp<?php echo $data['id_spp'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusspp<?php echo $data['id_spp'] ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editspp<?php echo $data['id_spp'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data SPP</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun</label>
                                                    <input type="text" name="tahun" class="form-control" value="<?php echo $data['tahun'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nominal</label>
                                                    <input type="text" name="nominal" class="form-control" value="<?php echo $data['nominal'] ?>">
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
                            <div class="modal fade" id="hapusspp<?php echo $data['id_spp'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data SPP</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        SPP - <?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?>
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
    let table = new DataTable('#spp');
</script>
<div class="modal fade" id="tambahspp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data SPP</h1>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" name="tahun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" name="nominal" class="form-control" required>
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