<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $peran = "user";

    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username is already registered!";
    } else {
        $query = "INSERT INTO users (username, password, peran) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $peran);

        if ($stmt->execute()) {
            $success = "Registration successful! Please <a href='login.php'>login here</a>.";
        } else {
            $error = "Registration failed : " . $conn->error;
        }
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            z-index: 0;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 30px 65px 50px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        h2 {
            margin-bottom: 20px;
            color: #FFF7E5;
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

        .btn {
            width: 100%;
            padding: 10px;
            background-color: burlywood;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

        p {
            color: red;
            font-size: 0.9rem;
        }

        .success {
            color: green;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="background"></div>
    <div class="form-container">
        <h2>Register</h2>
        <?php
        if (isset($error)) echo "<p>$error</p>";
        if (isset($success)) echo "<p class='success'>$success</p>";
        ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" class="btn">Register</button>
        </form>
        <a class="link" href="login.php">Already have an account? Login here</a>
    </div>
</body>

</html>