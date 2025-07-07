<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM application_reviews WHERE id = $id");
header("Location: index.php");