<?php
include 'db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM application_reviews WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Review</title>
</head>
<body>
<h2>Edit Application Review</h2>
<form method="POST" action="update.php" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <input type="text" name="app_name" value="<?= $row['app_name'] ?>"><br>
  <textarea name="review"><?= $row['review'] ?></textarea><br>
  <select name="category_id">
    <?php
    $cat = $conn->query("SELECT * FROM categories");
    while($c = $cat->fetch_assoc()) {
      $selected = ($c['id'] == $row['category_id']) ? "selected" : "";
      echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
    }
    ?>
  </select><br>
  <input type="file" name="image"><br>
  <label><input type="checkbox" name="is_active" value="1" <?= $row['is_active'] ? "checked" : "" ?>> Active</label><br>
  <button type="submit">Update</button>
</form>
</body>
</html>