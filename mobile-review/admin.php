<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// User list
$users = $conn->query("SELECT * FROM users ORDER BY role, username");

// Review list
$reviews = $conn->query("
    SELECT ar.id, ar.app_name, ar.review, ar.image_path, c.title AS category,
           ar.is_active, ar.created_at, u.username
    FROM application_reviews ar
    LEFT JOIN categories c ON ar.category_id = c.id
    LEFT JOIN users u ON ar.user_id = u.user_id
    ORDER BY ar.created_at DESC
");

// Auto-seed categories if empty
$check = $conn->query("SELECT COUNT(*) as total FROM categories");
$row = $check->fetch_assoc();
if ($row['total'] == 0) {
    $default = ['Productivity', 'Fitness', 'Entertainment', 'Education', 'Social Media', 'Finance'];
    foreach ($default as $cat) {
        $conn->query("INSERT INTO categories (title, status) VALUES ('$cat', 1)");
    }
}

// Add/Update/Delete categories
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"])) {
    $id = $_POST["id"];
    $title = trim($_POST["title"]);
    $status = isset($_POST["status"]) ? 1 : 0;

    if (!empty($title)) {
        if ($id == '') {
            $stmt = $conn->prepare("INSERT INTO categories (title, status) VALUES (?, ?)");
            $stmt->bind_param("si", $title, $status);
            $stmt->execute() ? $success = "Category added." : $error = "Failed to add.";
            $stmt->close();
        } else {
            $stmt = $conn->prepare("UPDATE categories SET title=?, status=?, modified=NOW() WHERE id=?");
            $stmt->bind_param("sii", $title, $status, $id);
            $stmt->execute() ? $success = "Category updated." : $error = "Failed to update.";
            $stmt->close();
        }
    } else {
        $error = "Category title required.";
    }
}

if (isset($_GET["delete_id"])) {
    $id = (int)$_GET["delete_id"];
    $conn->query("DELETE FROM categories WHERE id = $id") ? $success = "Category deleted." : $error = "Failed to delete category.";
}

$categories = $conn->query("SELECT * FROM categories ORDER BY created DESC");

$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = $conn->query("SELECT * FROM categories WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F3E5DB;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2, h3 {
            color: #72390D;
        }
        .section {
            background: #fff;
            border: 2px solid #AD876D;
            border-radius: 12px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #CBAE9A;
            text-align: center;
        }
        th {
            background-color: #AD876D;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #F9F2EE;
        }
        .btn-sm {
            font-size: 0.8rem;
        }
        img {
            height: 50px;
            border-radius: 5px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>
<a href="dashboard.php" class="btn btn-outline-secondary mb-3">← Back to Dashboard</a>

<!-- USERS SECTION -->
<div class="section">
    <h3>Registered Users</h3>
    <table>
        <thead>
            <tr><th>#</th><th>Username</th><th>Role</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php $i=1; while($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['role'] ?></td>
                <td>
                    <a href="editadmin.php?id=<?= $row['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="deleteadmin.php?id=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- REVIEWS SECTION -->
<div class="section">
    <h3>Application Reviews</h3>
    <table>
        <thead>
            <tr><th>#</th><th>App Name</th><th>User</th><th>Category</th><th>Review</th><th>Image</th><th>Status</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php $j=1; while($rev = $reviews->fetch_assoc()): ?>
            <tr>
                <td><?= $j++ ?></td>
                <td><?= htmlspecialchars($rev['app_name']) ?></td>
                <td><?= htmlspecialchars($rev['username']) ?></td>
                <td><?= htmlspecialchars($rev['category']) ?></td>
                <td><?= htmlspecialchars($rev['review']) ?></td>
                <td>
                    <?php if ($rev['image_path']): ?>
                        <img src="<?= $rev['image_path'] ?>" alt="Review Image">
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td><?= $rev['is_active'] ? 'Active' : 'Inactive' ?></td>
                <td><?= date('d M Y, h:i A', strtotime($rev['created_at'])) ?></td>
                <td>
                    <a href="view.php?id=<?= $rev['id'] ?>" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- CATEGORIES SECTION -->
<div class="section">
    <h3>Manage Categories</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="mb-3">
            <label>Category Title</label>
            <input type="text" name="title" class="form-control" required value="<?= $edit['title'] ?? '' ?>">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="status" value="1"
                <?= (isset($edit) && $edit['status']) ? 'checked' : (!isset($edit) ? 'checked' : '') ?>>
            <label class="form-check-label">Active</label>
        </div>
        <button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Update' : 'Add' ?></button>
        <?php if ($edit): ?>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr><th>ID</th><th>Title</th><th>Status</th><th>Created</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php if ($categories->num_rows > 0): ?>
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['title']) ?></td>
                    <td><?= $cat['status'] ? 'Active' : 'Inactive' ?></td>
                    <td><?= date('d M Y, h:i A', strtotime($cat['created'])) ?></td>
                    <td>
                        <a href="admin.php?edit=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin.php?delete_id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No categories found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

