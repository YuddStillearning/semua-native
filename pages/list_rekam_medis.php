<h4 class="mb-3">Laporan Data Rekam Medis</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No Transaksi</th>
            <th>Peserta</th>
            <th>Tanggal Berobat</th>
            <th>Bidan</th>
            <th>Poli</th>
            <th>Keluhan</th>
            <th>Biaya Admin</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT r.*, t.Nama_Peserta, b.Nama_Bidan, p.Nama_Poli
                                       FROM trekammedis r
                                       LEFT JOIN tpeserta t ON r.Kode_Peserta = t.Kode_Peserta
                                       LEFT JOIN tbidan b ON r.Kode_Bidan = b.Kode_Bidan
                                       LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli
                                       ORDER BY r.No_Transaksi ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['No_Transaksi']}</td>
                    <td>{$row['Nama_Peserta']}</td>
                    <td>{$row['Tgl_Berobat']}</td>
                    <td>{$row['Nama_Bidan']}</td>
                    <td>{$row['Nama_Poli']}</td>
                    <td>{$row['Keluhan']}</td>
                    <td>" . number_format($row['Biaya_Admin'], 0, ',', '.') . "</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>
