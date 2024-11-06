<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM lagu WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Song Deleted Successfully');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    } else {
        echo "<script>
        alert('Failed to Delete Song');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    }
}
