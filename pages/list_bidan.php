<h4 class="mb-3">Laporan Data Bidan</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode Bidan</th>
            <th>Nama Bidan</th>
            <th>Poli</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT b.*, p.Nama_Poli FROM tbidan b 
                                        LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli 
                                        ORDER BY b.Kode_Bidan ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['Kode_Bidan']}</td>
                    <td>{$row['Nama_Bidan']}</td>
                    <td>{$row['Nama_Poli']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>
