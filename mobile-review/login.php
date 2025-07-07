<?php
// ✅ login.php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "❌ Wrong password.";
        }
    } else {
        $error = "❌ User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to bottom right, #FFEEE5, #F9D9D9);
            font-family: 'Comic Sans MS', cursive, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border: 3px dashed #FFB6B6;
            border-radius: 20px;
            padding: 40px 30px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 25px rgba(255, 165, 165, 0.2);
        }

        h2 {
            color: #FF6B81;
            font-size: 28px;
            margin-bottom: 20px;
        }

        input {
            width: 80%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 10px;
            border: 2px solid #FF8A8A;
            background-color: #FFF5F5;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #FF6B81;
            background-color: #FFF0F0;
        }

        button {
            background-color: #FF8A8A;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.3s ease;
        }

        button:hover {
            background-color: #FF6B81;
            transform: scale(1.05);
        }

        .error {
            background-color: #FFE6E6;
            color: #D94A6B;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #72390D;
        }

        p a {
            color: #FF6B81;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .bubble1, .bubble2 {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            z-index: -1;
        }

        .bubble1 {
            width: 150px;
            height: 150px;
            background: #FFD6D6;
            top: 10%;
            left: 5%;
        }

        .bubble2 {
            width: 100px;
            height: 100px;
            background: #FFE5E5;
            bottom: 8%;
            right: 10%;
        }
    </style>
</head>
<body>

<div class="bubble1"></div>
<div class="bubble2"></div>

<div class="container">
    <h2>🔐 Log In</h2>

    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="👤 Username" required><br>
        <input type="password" name="password" placeholder="🔑 Password" required><br>
        <button type="submit">✨ Login</button>
    </form>

    <p>New here? <a href="register.php">Create an account</a></p>
</div>

</body>
</html>
