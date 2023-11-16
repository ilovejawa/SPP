<?php
include 'koneksi.php';
?>

<script>
    window.print();
</script>

<table border=1 cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th colspan="9">Laporan Pembayaran</th>
    </tr>
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
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>