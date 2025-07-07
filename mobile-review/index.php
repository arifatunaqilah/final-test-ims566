<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>App Reviews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #F3E5DB;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 40px;
    }

    .container-box {
      max-width: 1000px;
      margin: auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      border: 2px solid #AD876D;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #72390D;
      font-family: 'Georgia', serif;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
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

    tr:hover {
      background-color: #F3E5DB;
      transition: 0.3s;
    }

    .btn-success {
      background-color: #72390D;
      border: none;
    }

    .btn-success:hover {
      background-color: #936341;
    }

    .btn-warning, .btn-danger {
      font-size: 0.9rem;
    }

    .btn-back {
      background-color: #AD876D;
      border: none;
      color: white;
    }

    .btn-back:hover {
      background-color: #936341;
    }

    .button-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container-box">
  <h2>Mobile Application Reviews</h2>

  <div class="button-row">
    <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
    <a href="create.php" class="btn btn-success">+ Add New Review</a>
  </div>

  <?php
  $sql = "SELECT ar.*, c.title AS category FROM application_reviews ar 
          JOIN categories c ON ar.category_id = c.id
          ORDER BY ar.created_at DESC";
  $result = $conn->query($sql);
  ?>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>App Name</th>
          <th>Review</th>
          <th>Category</th>
          <th>Status</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['app_name']) ?></td>
            <td><?= htmlspecialchars($row['review']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= $row['is_active'] ? 'Active' : 'Inactive' ?></td>
            <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
            <td>
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete review?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning text-center">No reviews found.</div>
  <?php endif; ?>
</div>

</body>
</html>
