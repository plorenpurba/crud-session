<?php 
session_start();

// Hapus tugas jika ada parameter "hapus" di URL
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['hapus'])) {
    $hapus = $_GET['hapus'];
    if (isset($_SESSION['tugas'][$hapus])) {
        unset($_SESSION['tugas'][$hapus]);
        $_SESSION['tugas'] = array_values($_SESSION['tugas']); // Reset indeks array
    }
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit();
}

// Tambah tugas jika ada POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $tugasBaru = $_POST['tugas'];
    $waktu = $_POST['waktu'];

    if (empty($tugasBaru) || empty($waktu)) {
        header('Location: ' . $_SERVER['SCRIPT_NAME']);
        exit();
    } else {
        if (!isset($_SESSION['tugas'])) {
            $_SESSION['tugas'] = [];
        }
        $_SESSION['tugas'][] = ['tugas' => $tugasBaru, 'waktu' => $waktu];

        header('Location: ' . $_SERVER['SCRIPT_NAME']);
        exit();
    }
}
?>

<form action="/" method="post">
    <h2>Tugas</h2>
    <input type="text" name="tugas">
    <h2>Waktu</h2>
    <input type="number" name="waktu">
    <button type="submit">Simpan</button>
</form>

<?php if (isset($_SESSION['tugas']) && count($_SESSION['tugas']) > 0): ?>
    <h2>Daftar Tugas</h2>
    <ol>
        <?php foreach ($_SESSION['tugas'] as $idx => $data): ?>
            <li>
                <p><?= htmlspecialchars($data['tugas']) ?></p>
                <p><?= htmlspecialchars($data['waktu']) ?> jam</p>
                <a href="?hapus=<?= $idx ?>">Hapus</a>
                <a href="edit.php?edit=<?= $idx ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <p>Belum ada tugas</p>
<?php endif; ?>
