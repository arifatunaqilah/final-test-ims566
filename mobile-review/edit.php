<?php
include 'db.php';
session_start();

// Only logged in user can access
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["username"];
    $new_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE user_id = ?");
    $update->bind_param("ssi", $new_username, $new_password, $user_id);
    if ($update->execute()) {
        $_SESSION['username'] = $new_username;
        header("Location: profile.php");
        exit();
    } else {
        $error = "Update failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
    <style>
        body {
            background-color: #F3E5DB;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container-box {
            background-color: #fff;
            border: 2px solid #AD876D;
            border-radius: 10px;
            padding: 30px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #72390D;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 85%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #936341;
        }

        button {
            padding: 10px 20px;
            background-color: #72390D;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        button:hover {
            transform: scale(1.05);
        }

        p a {
            color: #72390D;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container-box">
    <h2>Edit Login Info</h2>

    <form method="POST">
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
        <input type="password" name="password" placeholder="New Password" required><br>
        <button type="submit">Update</button>
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</div>

</body>
</html>
