<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body {
            background-color: #F3E5DB;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-box {
            background-color: #fff;
            border: 2px solid #AD876D;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px;
            margin: 60px auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #72390D;
            margin-bottom: 20px;
        }

        .profile-info {
            text-align: left;
            margin: 20px 0;
        }

        .profile-info td {
            padding: 10px;
        }

        .profile-info td:first-child {
            font-weight: bold;
            color: #72390D;
        }

        .menu a {
            margin: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #72390D;
            padding: 8px 15px;
            border-radius: 8px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .menu a:hover {
            transform: scale(1.05);
            background-color: #936341;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <h2>My Profile</h2>
    <table class="profile-info" align="center">
        <tr><td>Username:</td><td><?= htmlspecialchars($row['username']) ?></td></tr>
        <tr><td>Role:</td><td><?= htmlspecialchars($row['role']) ?></td></tr>
    </table>
    <div class="menu">
        <a href="edit.php">✏️ Edit Profile</a>
        <a href="dashboard.php">🏠 Back</a>
        <a href="logout.php" onclick="return confirm('Logout?')">🚪 Logout</a>
    </div>
</div>

</body>
</html>
