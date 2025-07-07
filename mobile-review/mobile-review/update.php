<?php
include 'db.php';
$id = $_POST['id'];
$app_name = $_POST['app_name'];
$review = $_POST['review'];
$category_id = $_POST['category_id'];
$is_active = isset($_POST['is_active']) ? 1 : 0;

$image = $_FILES['image']['name'];
if ($image) {
  $tmp = $_FILES['image']['tmp_name'];
  move_uploaded_file($tmp, "uploads/$image");
  $image_sql = ", image_path='$image'";
} else {
  $image_sql = "";
}

$sql = "UPDATE application_reviews SET
        app_name='$app_name', review='$review', category_id=$category_id,
        is_active=$is_active $image_sql WHERE id=$id";
$conn->query($sql);
header("Location: index.php");