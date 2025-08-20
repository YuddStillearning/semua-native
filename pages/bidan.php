<?php
// Tambah Bidan
if (isset($_POST['add_bidan'])) {
    $kode = $_POST['Kode_Bidan'];
    $nama = $_POST['Nama_Bidan'];
    $poli = $_POST['Kode_Poli'];

    $sql = "INSERT INTO tbidan VALUES ('$kode', '$nama', '$poli')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data bidan berhasil ditambahkan!'); window.location='?page=bidan';</script>";
}

// Hapus Bidan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tbidan WHERE Kode_Bidan='$id'");
    echo "<script>alert('Data bidan berhasil dihapus!'); window.location='?page=bidan';</script>";
}

// Edit Bidan
if (isset($_POST['edit_bidan'])) {
    $kode = $_POST['Kode_Bidan'];
    $nama = $_POST['Nama_Bidan'];
    $poli = $_POST['Kode_Poli'];

    $sql = "UPDATE tbidan SET 
                Nama_Bidan='$nama', 
                Kode_Poli='$poli'
            WHERE Kode_Bidan='$kode'";
    mysqli_query($conn, $sql);
    echo "<script>alert('Data bidan berhasil diupdate!'); window.location='?page=bidan';</script>";
}

// Ambil data poli untuk dropdown
$poli_list = mysqli_query($conn, "SELECT * FROM tpoli ORDER BY Nama_Poli ASC");
?>

<h4 class="mb-3">Data Bidan</h4>

<!-- Tombol Tambah -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Bidan</button>

<!-- Tabel Data -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Bidan</th>
            <th>Poli</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT b.*, p.Nama_Poli FROM tbidan b 
                                        LEFT JOIN tpoli p ON b.Kode_Poli = p.Kode_Poli 
                                        ORDER BY b.Kode_Bidan ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['Kode_Bidan'] ?></td>
                <td><?= $row['Nama_Bidan'] ?></td>
                <td><?= $row['Nama_Poli'] ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['Kode_Bidan'] ?>">Edit</button>
                    <a href="?page=bidan&delete=<?= $row['Kode_Bidan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['Kode_Bidan'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Bidan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="Kode_Bidan" value="<?= $row['Kode_Bidan'] ?>">
                                <div class="mb-2">
                                    <label>Nama Bidan</label>
                                    <input type="text" name="Nama_Bidan" class="form-control" value="<?= $row['Nama_Bidan'] ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Poli</label>
                                    <select name="Kode_Poli" class="form-control" required>
                                        <?php
                                        $poli_list2 = mysqli_query($conn, "SELECT * FROM tpoli ORDER BY Nama_Poli ASC");
                                        while ($p = mysqli_fetch_assoc($poli_list2)) {
                                            $selected = ($p['Kode_Poli'] == $row['Kode_Poli']) ? 'selected' : '';
                                            echo "<option value='{$p['Kode_Poli']}' $selected>{$p['Nama_Poli']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_bidan" class="btn btn-success">Update</button>
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
                    <h5 class="modal-title">Tambah Bidan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Kode Bidan</label>
                        <input type="text" name="Kode_Bidan" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Nama Bidan</label>
                        <input type="text" name="Nama_Bidan" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Poli</label>
                        <select name="Kode_Poli" class="form-control" required>
                            <?php
                            mysqli_data_seek($poli_list, 0); // reset pointer result set
                            while ($p = mysqli_fetch_assoc($poli_list)) {
                                echo "<option value='{$p['Kode_Poli']}'>{$p['Nama_Poli']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_bidan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
