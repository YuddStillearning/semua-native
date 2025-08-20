<?php
// Ambil daftar peserta
$peserta_list = mysqli_query($conn, "SELECT * FROM tpeserta ORDER BY Nama_Peserta ASC");

// Ambil daftar bidan
$bidan_list = mysqli_query($conn, "SELECT b.Kode_Bidan, b.Nama_Bidan, p.Nama_Poli 
                                   FROM tbidan b 
                                   LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli 
                                   ORDER BY b.Nama_Bidan ASC");

// Tambah Rekam Medis
if (isset($_POST['add_rekam'])) {
    $no   = $_POST['No_Transaksi'];
    $peserta = $_POST['Kode_Peserta'];
    $tgl  = $_POST['tgl'];
    $bln  = $_POST['bln'];
    $thn  = $_POST['thn'];
    $bidan = $_POST['Kode_Bidan'];
    $keluhan = $_POST['Keluhan'];
    $biaya = $_POST['Biaya_Admin'];

    // gabung jadi format YYYY-MM-DD
    $tanggal_berobat = $thn . "-" . $bln . "-" . str_pad($tgl, 2, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO trekammedis VALUES ('$no', '$peserta', '$tanggal_berobat', '$bidan', '$keluhan', '$biaya')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data rekam medis berhasil ditambahkan!'); window.location='?page=rekam_medis';</script>";
}

// Hapus Rekam Medis
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM trekammedis WHERE No_Transaksi='$id'");
    echo "<script>alert('Data rekam medis berhasil dihapus!'); window.location='?page=rekam_medis';</script>";
}

// Edit Rekam Medis
if (isset($_POST['edit_rekam'])) {
    $no   = $_POST['No_Transaksi'];
    $peserta = $_POST['Kode_Peserta'];
    $tgl  = $_POST['tgl'];
    $bln  = $_POST['bln'];
    $thn  = $_POST['thn'];
    $bidan = $_POST['Kode_Bidan'];
    $keluhan = $_POST['Keluhan'];
    $biaya = $_POST['Biaya_Admin'];

    $tanggal_berobat = $thn . "-" . $bln . "-" . str_pad($tgl, 2, "0", STR_PAD_LEFT);

    $sql = "UPDATE trekammedis SET 
                Kode_Peserta='$peserta', 
                Tgl_Berobat='$tanggal_berobat', 
                Kode_Bidan='$bidan', 
                Keluhan='$keluhan', 
                Biaya_Admin='$biaya'
            WHERE No_Transaksi='$no'";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data rekam medis berhasil diupdate!'); window.location='?page=rekam_medis';</script>";
}
?>

<h4 class="mb-3">Data Rekam Medis</h4>

<!-- Tombol Tambah -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Rekam Medis</button>

<!-- Tabel Data -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No Transaksi</th>
            <th>Kode Peserta</th>
            <th>Nama Peserta</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Keluhan</th>
            <th>Nama Poli</th>
            <th>Nama Bidan</th>
            <th>Biaya Admin</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT r.*, t.Nama_Peserta, t.Tanggal_Lahir, t.Jenis_Kelamin, b.Nama_Bidan, p.Nama_Poli
                                       FROM trekammedis r
                                       LEFT JOIN tpeserta t ON r.Kode_Peserta = t.Kode_Peserta
                                       LEFT JOIN tbidan b ON r.Kode_Bidan = b.Kode_Bidan
                                       LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli
                                       ORDER BY r.No_Transaksi ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            // Hitung usia dari Tanggal_Lahir
            $tgl_lahir = new DateTime($row['Tanggal_Lahir']);
            $today = new DateTime();
            $usia = $today->diff($tgl_lahir)->y;

            // pecah tanggal berobat untuk edit
            $tgl_old = date("d", strtotime($row['Tgl_Berobat']));
            $bln_old = date("m", strtotime($row['Tgl_Berobat']));
            $thn_old = date("Y", strtotime($row['Tgl_Berobat']));
            ?>
            <tr>
                <td><?= $row['No_Transaksi'] ?></td>
                <td><?= $row['Kode_Peserta'] ?></td>
                <td><?= $row['Nama_Peserta'] ?></td>
                <td><?= $usia ?></td>
                <td><?= $row['Jenis_Kelamin'] ?></td>
                <td><?= $row['Keluhan'] ?></td>
                <td><?= $row['Nama_Poli'] ?></td>
                <td><?= $row['Nama_Bidan'] ?></td>
                <td><?= number_format($row['Biaya_Admin'], 0, ',', '.') ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['No_Transaksi'] ?>">Edit</button>
                    <a href="?page=rekam_medis&delete=<?= $row['No_Transaksi'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Del</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <!-- Modal Edit -->
<div class="modal fade" id="editModal<?= $row['No_Transaksi'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="No_Transaksi" value="<?= $row['No_Transaksi'] ?>">

                    <div class="mb-2">
                        <label>No Transaksi</label>
                        <input type="text" class="form-control" value="<?= $row['No_Transaksi'] ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label>Nama Peserta</label>
                        <select name="Kode_Peserta" class="form-control" required>
                            <?php
                            $peserta_edit = mysqli_query($conn, "SELECT * FROM tpeserta ORDER BY Nama_Peserta ASC");
                            while ($p = mysqli_fetch_assoc($peserta_edit)) {
                                $sel = ($p['Kode_Peserta'] == $row['Kode_Peserta']) ? 'selected' : '';
                                echo "<option value='{$p['Kode_Peserta']}' $sel>{$p['Nama_Peserta']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <label>Tanggal Berobat</label>
                    <div class="row mb-2">
                        <div class="col-4">
                            <input type="number" name="tgl" min="1" max="31" class="form-control" value="<?= $tgl_old ?>" required>
                        </div>
                        <div class="col-4">
                            <select name="bln" class="form-control" required>
                                <option value="">-- Bulan --</option>
                                <option value="01" <?= ($bln_old=="01"?"selected":"") ?>>Januari</option>
                                <option value="02" <?= ($bln_old=="02"?"selected":"") ?>>Februari</option>
                                <option value="03" <?= ($bln_old=="03"?"selected":"") ?>>Maret</option>
                                <option value="04" <?= ($bln_old=="04"?"selected":"") ?>>April</option>
                                <option value="05" <?= ($bln_old=="05"?"selected":"") ?>>Mei</option>
                                <option value="06" <?= ($bln_old=="06"?"selected":"") ?>>Juni</option>
                                <option value="07" <?= ($bln_old=="07"?"selected":"") ?>>Juli</option>
                                <option value="08" <?= ($bln_old=="08"?"selected":"") ?>>Agustus</option>
                                <option value="09" <?= ($bln_old=="09"?"selected":"") ?>>September</option>
                                <option value="10" <?= ($bln_old=="10"?"selected":"") ?>>Oktober</option>
                                <option value="11" <?= ($bln_old=="11"?"selected":"") ?>>November</option>
                                <option value="12" <?= ($bln_old=="12"?"selected":"") ?>>Desember</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="number" name="thn" class="form-control" value="<?= $thn_old ?>" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Nama Bidan</label>
                        <select name="Kode_Bidan" class="form-control" required>
                            <?php
                            $bidan_edit = mysqli_query($conn, "SELECT b.Kode_Bidan, b.Nama_Bidan, p.Nama_Poli 
                                                               FROM tbidan b 
                                                               LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli 
                                                               ORDER BY b.Nama_Bidan ASC");
                            while ($b = mysqli_fetch_assoc($bidan_edit)) {
                                $sel = ($b['Kode_Bidan'] == $row['Kode_Bidan']) ? 'selected' : '';
                                echo "<option value='{$b['Kode_Bidan']}' $sel>{$b['Nama_Bidan']} ({$b['Nama_Poli']})</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Keluhan</label>
                        <textarea name="Keluhan" class="form-control" required><?= $row['Keluhan'] ?></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Biaya Admin</label>
                        <input type="number" name="Biaya_Admin" class="form-control" value="<?= $row['Biaya_Admin'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit_rekam" class="btn btn-success">Submit</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
            </div>
        </form>
    </div>
</div>

            <?php
        }
        ?>
    </tbody>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- No Transaksi -->
                            <div class="mb-2">
                                <label>No Transaksi</label>
                                <input type="text" name="No_Transaksi" class="form-control" required>
                            </div>

                            <!-- Kode Peserta manual -->
                            <div class="mb-2">
                                <label>Kode Peserta</label>
                                <input type="text" name="Kode_Peserta" class="form-control" required>
                            </div>

                            <!-- Tanggal dipisah -->
                            <label>Tanggal Berobat</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" name="tgl" min="1" max="31" class="form-control" placeholder="Tanggal" required>
                                </div>
                                <div class="col-4">
                                    <select name="bln" class="form-control" required>
                                        <option value="">-- Bulan --</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="number" name="thn" class="form-control" placeholder="Tahun" required>
                                </div>
                            </div>

                            <!-- Bidan -->
                            <div class="mb-2 mt-2">
                                <label>Nama Bidan</label>
                                <select name="Kode_Bidan" class="form-control" required>
                                    <option value="">-- Pilih Bidan --</option>
                                    <?php
                                    mysqli_data_seek($bidan_list, 0);
                                    while ($b = mysqli_fetch_assoc($bidan_list)) {
                                        echo "<option value='{$b['Kode_Bidan']}'>{$b['Nama_Bidan']} ({$b['Nama_Poli']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Keluhan -->
                            <div class="mb-2">
                                <label>Keluhan</label>
                                <textarea name="Keluhan" class="form-control" required></textarea>
                            </div>

                            <!-- Biaya Admin -->
                            <div class="mb-2">
                                <label>Biaya Admin</label>
                                <input type="number" name="Biaya_Admin" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_rekam" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
            </div>
        </form>
    </div>
</div>

