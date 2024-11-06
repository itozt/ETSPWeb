<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penyanyi = $_POST['penyanyi'];

    // Ambil data lagu lama untuk pengecekan file
    $sql = "SELECT * FROM lagu WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $song = mysqli_fetch_assoc($result);

    if (!$song) {
        echo "song not found.";
        exit();
    }

    // Proses upload cover baru jika ada
    if (!empty($_FILES['cover']['name'])) {
        $cover = $_FILES['cover']['name'];
        $cover_tmp = $_FILES['cover']['tmp_name'];

        // Hapus cover lama jika ada
        if ($song['cover'] && file_exists("img_lagu/" . $song['cover'])) {
            unlink("img_lagu/" . $song['cover']);
        }

        // Simpan cover baru
        move_uploaded_file($cover_tmp, "img_lagu/" . $cover);
    } else {
        $cover = $song['cover'];
    }

    // Proses upload file mp3 baru jika ada
    if (!empty($_FILES['filemp3']['name'])) {
        $filemp3 = $_FILES['filemp3']['name'];
        $filemp3_tmp = $_FILES['filemp3']['tmp_name'];

        // Hapus file mp3 lama jika ada
        if ($song['filemp3'] && file_exists("mp3_lagu/" . $song['filemp3'])) {
            unlink("mp3_lagu/" . $song['filemp3']);
        }

        // Simpan file mp3 baru
        move_uploaded_file($filemp3_tmp, "mp3_lagu/" . $filemp3);
    } else {
        $filemp3 = $song['filemp3']; // Jika tidak ada file baru, gunakan file mp3 lama
    }

    // Update data lagu di database
    $sql = "UPDATE lagu SET judul='$judul', penyanyi='$penyanyi', cover='$cover', filemp3='$filemp3' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Song Edited Successfully');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    } else {
        echo "<script>
        alert('Failed to edit song');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    }
}
