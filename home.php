<?php
if (!empty($_SESSION['user']['level'])) {
?>
    <h1>Dashboard</h1>

    <div class="row">
        <div class="col-12">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Jumlah Petugas</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM petugas");
                                    $data = mysqli_fetch_assoc($query);
                                    echo $data['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Jumlah Kelas</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="box"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
                                    $data = mysqli_fetch_assoc($query);
                                    echo $data['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Jumlah Siswa</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
                                    $data = mysqli_fetch_assoc($query);
                                    echo $data['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Transaksi</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT SUM(nominal) AS total FROM pembayaran INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
                                    $data = mysqli_fetch_assoc($query);
                                    echo $data['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
} else {
    ?>
        <h1 class="h3 mb-3">History, <?php echo $_SESSION['user']['nama'] ?></h1>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover cell-border" id="historysiswa">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nisn = $_SESSION['user']['nisn'];
                                $i = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");
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
                                    </tr>
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
            let table = new DataTable('#historysiswa');
        </script>
    <?php
}
    ?>