<?php
include 'koneksi.php';
session_start();

// Di bagian atas file, sebelum form login untuk cookie dan session jika usdah ada
if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['peran'] = $_COOKIE['peran'];
    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['peran'] = $user['peran'];

            // Mengecek apakah checkbox "Remember Me" dicentang
            if (isset($_POST['remember_me'])) {
                // Mengatur cookie untuk 30 hari
                setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");    // 30 hari
                setcookie('peran',  $user['peran'], time() + (30 * 24 * 60 * 60), "/"); // 30 hari
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Wrong Password!";
        }
    } else {
        $error = "Username not found!";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mood Booster</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('img/bg-home.jpg');
            background-size: cover;
            background-position: center;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 10px 65px 50px 50px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
            position: relative;
        }

        .form-container p {
            font-size: 3rem;
            font-family: Arial, sans-serif;
            font-weight: bold;
            margin-bottom: 20px;
            color: #FFF;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: rgba(176, 176, 176, 0.3);
            color: #FFF7E5;
        }

        label {
            color: grey;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(100deg, #A57331, #DEB887);;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color:black;
        }

        .btn:hover {
            background-color: brown;
        }

        .link {
            margin-top: 15px;
            display: block;
            color: #CECE18;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
            color: #27FD06;
        }
        .form-container h2 {
            font-size: 3rem;
            font-family: Arial, sans-serif;
            font-weight: bold;
            margin-bottom: 20px;
            color: #FFF;
        }
        .form-container p {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="background"></div>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <label>
                <input type="checkbox" name="remember_me"> Remember me
            </label><br><br>
            <button type="submit" class="btn">Login</button>
        </form>
        <a class="link" href="register.php">Don't have an account yet? Register here</a>
    </div>
</body>

</html>