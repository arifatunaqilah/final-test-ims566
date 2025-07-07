<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #FFEEE5, #F9D9D9);
            font-family: 'Comic Sans MS', cursive, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #FFF5F0;
            border-bottom: 3px dotted #FF8A8A;
            box-shadow: 0 4px 10px rgba(255, 165, 165, 0.2);
        }

        .logo {
            font-size: 28px;
            color: #E2626B;
            font-weight: bold;
        }

        .menu-btn {
            font-size: 28px;
            background: none;
            border: none;
            cursor: pointer;
            color: #E2626B;
        }

        .dropdown {
            display: none;
            position: absolute;
            right: 40px;
            background-color: #fff;
            border: 2px dashed #FFB6B6;
            border-radius: 12px;
            min-width: 180px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            z-index: 99;
        }

        .dropdown a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            color: #E2626B;
            border-bottom: 1px dotted #FFD6D6;
        }

        .dropdown a:hover {
            background-color: #FFF0F0;
            color: #D94A6B;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
            border-radius: 25px;
            border: 4px double #FFB6B6;
            box-shadow: 0 10px 20px rgba(255, 182, 193, 0.3);
            text-align: center;
        }

        h2 {
            color: #FF6B81;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 16px;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            opacity: 0.2;
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
            background: #FFF0F0;
            bottom: 5%;
            right: 10%;
        }

        .container img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .fun-btn {
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #FF8A8A;
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            transition: transform 0.2s ease;
        }

        .fun-btn:hover {
            background-color: #FF6B81;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">🌸 AppReviewLand</div>
    <div style="position: relative;">
        <button class="menu-btn" id="menuBtn">☰</button>
        <div class="dropdown" id="dropdownMenu">
            <a href="profile.php">My Profile</a>
            <a href="create.php">Add Review</a>
            <a href="view.php">View Review</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<div class="container">
    <h2>Hi, <?= htmlspecialchars($user['username']) ?>! 🎉</h2>
    <p>Welcome! Feel free to submit your review here 💬</p>
    <a href="create.php" class="fun-btn">+ Add New Review</a>
</div>

<div class="bubble bubble1"></div>
<div class="bubble bubble2"></div>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const dropdown = document.getElementById('dropdownMenu');
    menuBtn.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.onclick = function(event) {
        if (!event.target.matches('#menuBtn')) {
            dropdown.style.display = 'none';
        }
    }
</script>

</body>
</html>
