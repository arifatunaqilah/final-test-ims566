<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_name = trim($_POST["app_name"]);
    $review = trim($_POST["review"]);
    $is_active = isset($_POST["is_active"]) ? 1 : 0;
    $category_id = $_POST["category_id"];
    $image_path = '';
    $user_id = $_SESSION['user_id'];

    if (empty($app_name) || empty($review) || empty($category_id)) {
        $error = "❌ Please fill in all fields.";
    } else {
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $file_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $error = "❌ Image upload failed.";
            }
        }

        if (empty($error)) {
            $stmt = $conn->prepare("INSERT INTO application_reviews (app_name, review, image_path, category_id, is_active, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiii", $app_name, $review, $image_path, $category_id, $is_active, $user_id);
            if ($stmt->execute()) {
                $success = "✅ App review added successfully!";
            } else {
                $error = "❌ Database error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add App Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F3E5DB;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            padding: 40px 10px;
        }

        .container-box {
            background-color: #fff;
            border: 2px solid #AD876D;
            border-radius: 15px;
            padding: 30px 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        h3 {
            text-align: center;
            color: #72390D;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            color: #72390D;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #C5A28A;
        }

        .form-check-label {
            color: #72390D;
        }

        .btn-primary {
            background-color: #72390D;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #936341;
        }

        .alert {
            border-radius: 10px;
        }

        a.back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #936341;
            text-decoration: none;
            font-weight: bold;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container-box">
    <h3>📱 Add App Review</h3>

    <a href="index.php" class="back-link">← Back to Reviews</a>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>App Name</label>
            <input type="text" name="app_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Review</label>
            <textarea name="review" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php
                $categories = $conn->query("SELECT id, title FROM categories WHERE status = 1 ORDER BY title ASC");
                while ($cat = $categories->fetch_assoc()) {
                    echo "<option value='{$cat['id']}'>{$cat['title']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="is_active" class="form-check-input" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">🎉 Submit Review</button>
    </form>
</div>

</body>
</html>


