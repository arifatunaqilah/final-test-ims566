<?php
include ('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $status = isset($_POST['status']) ? 1 : 0;

  if ($id == '') {
    $sql = "INSERT INTO categories (title, status) VALUES ('$title', $status)";
  } else {
    $sql = "UPDATE categories SET title='$title', status=$status, modified=NOW() WHERE id=$id";
  }

  $conn->query($sql);
  header("Location: categories.php");
  exit;
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM categories WHERE id=$id");
  header("Location: categories.php");
  exit;
}
?>