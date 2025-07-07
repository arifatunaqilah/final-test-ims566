<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>App Reviews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Mobile Application Reviews</h2>
  <a href="create.php" class="btn btn-success mb-3">Add Review</a>

  <?php
  $sql = "SELECT ar.*, c.name AS category FROM application_reviews ar 
          JOIN categories c ON ar.category_id = c.id";
  $result = $conn->query($sql);
  ?>

  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card mb-4">
        <img src="uploads/<?= $row['image_path'] ?>" class="card-img-top" style="height:200px;object-fit:cover;">
        <div class="card-body">
          <h5><?= $row['app_name'] ?></h5>
          <p><?= $row['review'] ?></p>
          <p><strong>Category:</strong> <?= $row['category'] ?></p>
          <p><strong>Status:</strong> <?= $row['is_active'] ? 'Active' : 'Inactive' ?></p>
          <p><small><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></small></p>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">Delete</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>