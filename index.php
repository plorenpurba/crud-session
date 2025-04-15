<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['hapus'])) {
    $hapus = $_POST['hapus'];
    if (isset($_SESSION['tugas'][$hapus])) {
        unset($_SESSION['tugas'][$hapus]);
        $_SESSION['tugas'] = array_values($_SESSION['tugas']); // Reset indeks array
    }
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['tugas']) && isset($_POST['waktu'])) {
    $tugasBaru = $_POST['tugas'];
    $waktu = $_POST['waktu'];

    if (!empty($tugasBaru) && !empty($waktu)) {
        if (!isset($_SESSION['tugas'])) {
            $_SESSION['tugas'] = [];
        }
        $_SESSION['tugas'][] = ['tugas' => $tugasBaru, 'waktu' => $waktu];
    }

    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit();
}
?>

<!-- Form Tambah Tugas -->
<form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
    <h2>Tugas</h2>
    <input type="text" name="tugas" required>
    <h2>Waktu</h2>
    <input type="number" name="waktu" required>
    <button type="submit">Simpan</button>
</form>

<!-- Daftar Tugas -->
<?php if (isset($_SESSION['tugas']) && count($_SESSION['tugas']) > 0): ?>
    <h2>Daftar Tugas</h2>
    <ol>
        <?php foreach ($_SESSION['tugas'] as $idx => $data): ?>
            <li>
                <p><?= htmlspecialchars($data['tugas']) ?></p>
                <p><?= htmlspecialchars($data['waktu']) ?> jam</p>
                
                <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post" style="display:inline;">
                    <input type="hidden" name="hapus" value="<?= $idx ?>">
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</button>
                </form>

                <a href="edit.php?edit=<?= $idx ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <p>Belum ada tugas</p>
<?php endif; ?>
