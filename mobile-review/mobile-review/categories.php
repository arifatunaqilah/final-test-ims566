<?php
include ('db.php');

// Fetch all categories
$categories = $conn->query("SELECT * FROM categories ORDER BY created DESC");

// If editing
$edit = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $edit = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();
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
  <h2>Manage Categories</h2>

  <form method="POST" action="store.php" class="mb-4">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required value="<?= $edit['title'] ?? '' ?>">
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="status" value="1"
        <?= (isset($edit) && $edit['status']) ? 'checked' : (!isset($edit) ? 'checked' : '') ?>>
      <label class="form-check-label">Active</label>
    </div>
    <button class="btn btn-primary" type="submit"><?= isset($edit) ? 'Update' : 'Add' ?></button>
    <?php if ($edit): ?>
      <a href="categories.php" class="btn btn-secondary">Cancel</a>
    <?php endif; ?>
  </form>

  <table class="table table-bordered">
    <thead><tr>
      <th>ID</th><th>Title</th><th>Status</th><th>Created</th><th>Actions</th>
    </tr></thead>
    <tbody>
      <?php while ($row = $categories->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
        <td><?= date('d M Y, h:i A', strtotime($row['created'])) ?></td>
        <td>
          <a href="categories.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="store.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this?')" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html><?php
include '../db.php';

// Fetch all categories
$categories = $conn->query("SELECT * FROM categories ORDER BY created DESC");

// If editing
$edit = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $edit = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();
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
  <h2>Manage Categories</h2>

  <form method="POST" action="store.php" class="mb-4">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required value="<?= $edit['title'] ?? '' ?>">
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="status" value="1"
        <?= (isset($edit) && $edit['status']) ? 'checked' : (!isset($edit) ? 'checked' : '') ?>>
      <label class="form-check-label">Active</label>
    </div>
    <button class="btn btn-primary" type="submit"><?= isset($edit) ? 'Update' : 'Add' ?></button>
    <?php if ($edit): ?>
      <a href="categories.php" class="btn btn-secondary">Cancel</a>
    <?php endif; ?>
  </form>

  <table class="table table-bordered">
    <thead><tr>
      <th>ID</th><th>Title</th><th>Status</th><th>Created</th><th>Actions</th>
    </tr></thead>
    <tbody>
      <?php while ($row = $categories->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
        <td><?= date('d M Y, h:i A', strtotime($row['created'])) ?></td>
        <td>
          <a href="categories.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="store.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this?')" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
