<?php
// Tambah Peserta
if (isset($_POST['add_peserta'])) {
    $kode = $_POST['Kode_Peserta'];
    $nama = $_POST['Nama_Peserta'];
    $tgl  = $_POST['Tanggal_Lahir'];
    $jk   = $_POST['Jenis_Kelamin'];
    $alamat = $_POST['Alamat'];
    $telp   = $_POST['Telepon'];
    $email  = $_POST['Email'];

    $sql = "INSERT INTO tpeserta VALUES ('$kode', '$nama', '$tgl', '$jk', '$alamat', '$telp', '$email')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data peserta berhasil ditambahkan!'); window.location='?page=peserta';</script>";
}

// Hapus Peserta
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tpeserta WHERE Kode_Peserta='$id'");
    echo "<script>alert('Data peserta berhasil dihapus!'); window.location='?page=peserta';</script>";
}

// Edit Peserta
if (isset($_POST['edit_peserta'])) {
    $kode = $_POST['Kode_Peserta'];
    $nama = $_POST['Nama_Peserta'];
    $tgl  = $_POST['Tanggal_Lahir'];
    $jk   = $_POST['Jenis_Kelamin'];
    $alamat = $_POST['Alamat'];
    $telp   = $_POST['Telepon'];
    $email  = $_POST['Email'];

    $sql = "UPDATE tpeserta SET 
                Nama_Peserta='$nama', 
                Tanggal_Lahir='$tgl', 
                Jenis_Kelamin='$jk', 
                Alamat='$alamat', 
                Telepon='$telp', 
                Email='$email'
            WHERE Kode_Peserta='$kode'";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data peserta berhasil diupdate!'); window.location='?page=peserta';</script>";
}
?>

<h4 class="mb-3">Data Peserta</h4>

<!-- Tombol Tambah -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Peserta</button>

<!-- Tabel Data -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM tpeserta ORDER BY Kode_Peserta ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['Kode_Peserta'] ?></td>
                <td><?= $row['Nama_Peserta'] ?></td>
                <td><?= $row['Tanggal_Lahir'] ?></td>
                <td><?= $row['Jenis_Kelamin'] ?></td>
                <td><?= $row['Alamat'] ?></td>
                <td><?= $row['Telepon'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['Kode_Peserta'] ?>">Edit</button>
                    <a href="?page=peserta&delete=<?= $row['Kode_Peserta'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['Kode_Peserta'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Peserta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="Kode_Peserta" value="<?= $row['Kode_Peserta'] ?>">
                                <div class="mb-2">
                                    <label>Nama Peserta</label>
                                    <input type="text" name="Nama_Peserta" class="form-control" value="<?= $row['Nama_Peserta'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="Tanggal_Lahir" class="form-control" value="<?= $row['Tanggal_Lahir'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Jenis Kelamin</label>
                                    <select name="Jenis_Kelamin" class="form-control" required>
                                        <option value="Laki-Laki" <?= $row['Jenis_Kelamin'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                                        <option value="Perempuan" <?= $row['Jenis_Kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Alamat</label>
                                    <input type="text" name="Alamat" class="form-control" value="<?= $row['Alamat'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Telepon</label>
                                    <input type="text" name="Telepon" class="form-control" value="<?= $row['Telepon'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Email</label>
                                    <input type="email" name="Email" class="form-control" value="<?= $row['Email'] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_peserta" class="btn btn-success">Update</button>
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
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Kode Peserta</label>
                        <input type="text" name="Kode_Peserta" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Nama Peserta</label>
                        <input type="text" name="Nama_Peserta" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="Tanggal_Lahir" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Jenis Kelamin</label>
                        <select name="Jenis_Kelamin" class="form-control" required>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Alamat</label>
                        <input type="text" name="Alamat" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Telepon</label>
                        <input type="text" name="Telepon" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="Email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_peserta" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
