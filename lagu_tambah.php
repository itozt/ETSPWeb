<?php
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penyanyi = $_POST['penyanyi'];

    // Upload cover
    $cover = $_FILES['cover']['name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];
    move_uploaded_file($cover_tmp, "img_lagu/" . $cover);

    // Upload file mp3
    $filemp3 = $_FILES['filemp3']['name'];
    $filemp3_tmp = $_FILES['filemp3']['tmp_name'];
    move_uploaded_file($filemp3_tmp, "mp3_lagu/" . $filemp3);

    // Insert ke database
    $sql = "INSERT INTO lagu (judul, penyanyi, cover, filemp3) VALUES ('$judul', '$penyanyi', '$cover', '$filemp3')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Song Added Successfully');
        window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('Failed to Add Song');
        window.location.href = 'dashboard.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mood Booster</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f3f3f3;
        }

        /* Sidebar Style */
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: fixed;
            height: 100vh;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            width: 100%;
            text-align: center;
            margin: 10px 0;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar .view-songs {
            background-color: #8D5B5B;
        }

        .sidebar .manage-songs {
            background-color: #2196F3;
        }

        .sidebar .manage-users {
            background-color: #FF5722;
        }

        /* Main Content Style */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            position: relative;
            color:#F9E1D4;
            background-image: url('img/bg1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Logout Button */
        .logout {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .logout a {
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            background-color: #9F3535;
            padding: 8px 12px;
            border-radius: 4px;
            color: white;
            transition:  0.3s;
        }

        .logout a:hover {
            background-color: #ff3333;
        }

        /* Card Style for songs */
        .songs-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .song-card {
            width: 220px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
        }

        .song-card:hover {
            transform: translateY(-5px);
        }

        .song-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .song-card .card-content {
            padding: 15px;
        }

        .song-card h3 {
            font-size: 1.2rem;
            color: #333;
            margin: 10px 0 5px;
        }

        .song-card p {
            font-size: 0.9rem;
            color: #666;
        }

        .download-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #8A2BE2;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .tambah-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: blueviolet;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .tambah-button:hover {
            background-color: purple;
        }

        .download-button:hover {
            background-color: #1b7ec2;
        }

        .main-content form div {
            margin: 20px 0;
            width: 500px;
            display: flex;
            justify-content: space-between;
        }

        .main-content form div label {
            width: 45%;
            color:white;
        }

        .main-content form div p {
            width: 10%;
        }

        .main-content form div input {
            width: 45%;
        }
    </style>
</head>

<body>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>Mood Booster</h2>
        <a href="dashboard.php" class="view-songs">Song List</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <h2>Add New Song</h2>
        <div class="songs-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="judul">Song Tittle</label>
                    <p>:</p>
                    <input type="text" name="judul" id="judul" required>
                </div>

                <div>
                    <label for="penyanyi">Singer</label>
                    <p>:</p>
                    <input type="text" name="penyanyi" id="penyanyi" required>
                </div>

                <div>
                    <label for="cover">Cover/Image</label>
                    <p>:</p>
                    <input type="file" name="cover" id="cover" accept="image/*" required>
                </div>

                <div>
                    <label for="filemp3">Upload MP3 File</label>
                    <p>:</p>
                    <input type="file" name="filemp3" id="filemp3" accept="application/mp3" required>
                </div>

                <input class="download-button" type="submit" value="Add Song">
            </form>
        </div>
    </div>
</body>

</html>