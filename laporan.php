<?php
if (isset($_POST['edit'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $query = mysqli_query($koneksi, "UPDATE pembayaran SET jumlah_bayar='$jumlah_bayar' WHERE id_pembayaran='$id_pembayaran'");
    if ($query) {
        echo '<script>alert("Data Berhasil di Edit");location.href="?page=laporan"</script>';
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

<h1 class="h3 mb-3">Laporan</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <a href="cetak-laporan.php" target="_blank" class="btn btn-success btn-sm mb-3">Print</a>

                <?php
                }
                ?>
                <table class="table table-bordered table-striped table-hover cell-border" id="laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Bayar</th>
                            <th>Bulan Bayar</th>
                            <th>Tahun Bayar</th>
                            <th>SPP</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['tgl_bayar'] ?></td>
                                <td><?php echo $data['bulan_bayar'] ?></td>
                                <td><?php echo $data['tahun_dibayar'] ?></td>
                                <td><?php echo $data['tahun'] ?> - Rp. <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                                <td> Rp. <?php echo number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    if ($data['nominal'] >  $data['jumlah_bayar']) {
                                        echo 'Kurang';
                                    } else {
                                        echo 'Lunas';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['nominal'] == $data['jumlah_bayar']) {
                                    ?>
                                        <button type="button" class="btn btn-success btn-sm">
                                            Lunas
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editlaporan<?php echo $data['id_pembayaran'] ?>">
                                            Lunasi
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="editlaporan<?php echo $data['id_pembayaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Laporan</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran'] ?>">
                                                    <label class="form-label">Nama Petugas</label>
                                                    <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Bayar</label>
                                                    <input type="text" name="tgl_bayar" class="form-control" value="<?php echo $data['tgl_bayar'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bulan Bayar</label>
                                                    <input type="text" name="bulan_bayar" class="form-control" value="<?php echo $data['bulan_bayar'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun Bayar</label>
                                                    <input type="text" name="tahun_bayar" class="form-control" value="<?php echo $data['tahun_dibayar'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">SPP</label>
                                                    <input type="text" name="spp" class="form-control" value="<?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah</label>
                                                    <input type="text" name="jumlah_bayar" class="form-control" value="<?php echo $data['jumlah_bayar'] ?>">
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
    let table = new DataTable('#laporan');
</script>