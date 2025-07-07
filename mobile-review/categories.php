<?php
include 'db.php';

$error = '';
$success = '';

// Auto-seed kategori kalau kosong
$check = $conn->query("SELECT COUNT(*) as total FROM categories");
$row = $check->fetch_assoc();
if ($row['total'] == 0) {
    $default = ['Productivity', 'Fitness', 'Entertainment', 'Education', 'Social Media', 'Finance'];
    foreach ($default as $cat) {
        $conn->query("INSERT INTO categories (title, status) VALUES ('$cat', 1)");
    }
}

// ADD or UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

// DELETE
if (isset($_GET["delete_id"])) {
    $id = (int)$_GET["delete_id"];
    $conn->query("DELETE FROM categories WHERE id = $id") ? $success = "Category deleted." : $error = "Failed to delete category.";
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories ORDER BY created DESC");

// Fetch for editing
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = $conn->query("SELECT * FROM categories WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Manage Categories</h3>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">Back</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Form -->
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
            <a href="categories.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Title</th><th>Status</th><th>Created</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php if ($categories->num_rows > 0): ?>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
                    <td><?= date('d M Y, h:i A', strtotime($row['created'])) ?></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Delete this category?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No categories found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

