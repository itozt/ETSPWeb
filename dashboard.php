<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM lagu";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            background: linear-gradient(100deg, #1B1B1B, #212121);
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
            color: yellow;
            font-size: 1.5rem;
            font-family: Helvetica;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            width: 100%;
            text-align: center;
            margin: 10px 0;
            border-radius: 4px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #575757;
        }

        .sidebar .view-songs {
            background: linear-gradient(100deg, #5A2D00, #C66300);
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
            background-color: #181818;
            color: #F9E1D4;
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
            background: linear-gradient(100deg, #7F0404, #E80000);
            padding: 8px 12px;
            border-radius: 4px;
            color: white;
            transition: background-color 0.3s;
        }

        .logout a:hover {
            background: linear-gradient(100deg, #1B1B1B, #818181);
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
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
            margin-bottom: 10px;
            background: linear-gradient(100deg, #291500, #5C3A20);
            box-shadow: 0 4px 20px rgba(110, 110, 110, 0.6);
        }

        .song-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(100deg, #292929, #838383);
        }

        .song-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .song-card .card-content {
            padding: 15px;
        }

        .song-card h4 {
            font-size: 1.2rem;
            color: #FFFFFF;
            margin: 10px 0 5px;
        }

        .song-card p {
            font-size: 0.9rem;
            color: #FFE5CA;
        }

        .download-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: linear-gradient(1000deg, #D78431, #FFB347);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .download-button:hover {
            background: linear-gradient(1000deg, #006210, #23AE00);
        }

        .tambah-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: linear-gradient(1000deg, blueviolet, #57129C);
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
            background-color: #000066;
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
        <h2>Song List</h2>
        <?php if ($_SESSION['peran'] == 'admin') : ?>
            <a href="lagu_tambah.php" class="tambah-button">Add Song</a>
        <?php endif; ?>
        <div class="songs-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="song-card">
                    <img src="img_lagu/<?php echo $row['cover']; ?>" alt="Cover lagu">
                    <div class="card-content">
                        <h4><?php echo $row['judul']; ?></h4>
                        <p>by <?php echo $row['penyanyi']; ?></p>
                        <a href="mp3_lagu/<?php echo $row['filemp3']; ?>" download="<?php echo $row['filemp3']; ?>" class=" download-button">Download</a>
                        <?php if ($_SESSION['peran'] == 'admin') : ?>
                            <hr style="margin: 10px;">
                            <a href="lagu_edit.php?id=<?= $row['id'] ?>" class="download-button">Edit</a>
                            <a href="lagu_hapus.php?id=<?= $row['id'] ?>" class="download-button">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>