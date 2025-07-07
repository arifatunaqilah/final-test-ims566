<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Review</title>
</head>
<body>
<h2>Create Application Review</h2>
<form method="POST" action="store.php" enctype="multipart/form-data">
  <input type="text" name="app_name" placeholder="App Name" required><br>
  <textarea name="review" placeholder="Review"></textarea><br>
  <select name="category_id">
    <?php
    $cat = $conn->query("SELECT * FROM categories");
    while($row = $cat->fetch_assoc()) {
      echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    ?>
  </select><br>
  <input type="file" name="image"><br>
  <label><input type="checkbox" name="is_active" value="1" checked> Active</label><br>
  <button type="submit">Save</button>
</form>
</body>
</html>