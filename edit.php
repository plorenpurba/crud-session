<?php 
    session_start();
    $idx = isset($_GET['edit']) ? $_GET['edit'] : false;

    if ($idx === false || !isset($_SESSION['tugas'][$idx])) {
        header('Location: /');
    }
    $tugas = $_SESSION['tugas'][$idx]['tugas'];
    $waktu = $_SESSION['tugas'][$idx]['waktu'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tugas = $_POST['tugas'];
        $waktu = $_POST['waktu'];
        if (!empty($tugas) && !empty($waktu)) {
            $_SESSION['tugas'][$idx] = ['tugas' => $tugas, 'waktu' => $waktu];
            header('Location: /');
            exit; 
        }
    }
?>

<form action="" method="post">
    <h2>Tugas</h2>
    <input type="text" name="tugas"  value="<?= $tugas?>">
    <h2>Waktu</h2>
    <input type="number" name="waktu" value="<?= $waktu?>">
    <button type="submit">Simpan</button>
</form>
