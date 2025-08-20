<?php
// Tambah Poli
if (isset($_POST['add_poli'])) {
    $kode = $_POST['Kode_Poli'];
    $nama = $_POST['Nama_Poli'];

    $sql = "INSERT INTO tpoli VALUES ('$kode', '$nama')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data poli berhasil ditambahkan!'); window.location='?page=poli';</script>";
}

// Hapus Poli
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tpoli WHERE Kode_Poli='$id'");
    echo "<script>alert('Data poli berhasil dihapus!'); window.location='?page=poli';</script>";
}

// Edit Poli
if (isset($_POST['edit_poli'])) {
    $kode = $_POST['Kode_Poli'];
    $nama = $_POST['Nama_Poli'];

    $sql = "UPDATE tpoli SET Nama_Poli='$nama' WHERE Kode_Poli='$kode'";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data poli berhasil diupdate!'); window.location='?page=poli';</script>";
}
?>

<h4 class="mb-3">Data Poli</h4>

<!-- Tombol Tambah -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Poli</button>

<!-- Tabel Data -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Poli</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM tpoli ORDER BY Kode_Poli ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['Kode_Poli'] ?></td>
                <td><?= $row['Nama_Poli'] ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['Kode_Poli'] ?>">Edit</button>
                    <a href="?page=poli&delete=<?= $row['Kode_Poli'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['Kode_Poli'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Poli</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="Kode_Poli" value="<?= $row['Kode_Poli'] ?>">
                                <div class="mb-2">
                                    <label>Nama Poli</label>
                                    <input type="text" name="Nama_Poli" class="form-control" value="<?= $row['Nama_Poli'] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_poli" class="btn btn-success">Update</button>
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
                    <h5 class="modal-title">Tambah Poli</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Kode Poli</label>
                        <input type="text" name="Kode_Poli" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Nama Poli</label>
                        <input type="text" name="Nama_Poli" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_poli" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
