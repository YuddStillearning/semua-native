<h4 class="mb-3">Laporan Data Peserta</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode Peserta</th>
            <th>Nama Peserta</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM tpeserta ORDER BY Nama_Peserta ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['Kode_Peserta']}</td>
                    <td>{$row['Nama_Peserta']}</td>
                    <td>{$row['Tanggal_Lahir']}</td>
                    <td>{$row['Jenis_Kelamin']}</td>
                    <td>{$row['Alamat']}</td>
                    <td>{$row['Telepon']}</td>
                    <td>{$row['Email']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>
