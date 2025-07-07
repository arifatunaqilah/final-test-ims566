<?php
include 'db.php';
session_start();

// ✅ Allow both user & admin (just check login status)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$logged_in_user = $_SESSION['username'];
$is_admin = ($_SESSION['role'] === 'admin');

// ✅ Show only the user's reviews if not admin
if ($is_admin) {
    $sql = "SELECT ar.*, u.username, c.title AS category 
            FROM application_reviews ar
            JOIN users u ON ar.user_id = u.user_id
            JOIN categories c ON ar.category_id = c.id
            ORDER BY ar.created_at DESC";
} else {
    $sql = "SELECT ar.*, u.username, c.title AS category 
            FROM application_reviews ar
            JOIN users u ON ar.user_id = u.user_id
            JOIN categories c ON ar.category_id = c.id
            WHERE u.username = ?
            ORDER BY ar.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $logged_in_user);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($is_admin) {
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F3E5DB;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border: 2px solid #AD876D;
            border-radius: 12px;
            padding: 30px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #72390D;
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #CBAE9A;
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
            transition: 0.3s ease;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        a {
            text-decoration: none;
        }

        img {
            height: 50px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?= $is_admin ? "All User Reviews" : "My Submitted Reviews" ?></h2>
    <a href="<?= $is_admin ? 'admin.php' : 'dashboard.php' ?>" class="btn btn-secondary mb-3">← Back</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <?php if ($is_admin): ?><th>User</th><?php endif; ?>
                    <th>App</th>
                    <th>Review</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <?php if ($is_admin): ?><td><?= htmlspecialchars($row['username']) ?></td><?php endif; ?>
                        <td><?= htmlspecialchars($row['app_name']) ?></td>
                        <td><?= htmlspecialchars($row['review']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= $row['is_active'] ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <?php if ($row['image_path']): ?>
                                <img src="<?= $row['image_path'] ?>" alt="App Image">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete review?')" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">No reviews submitted yet.</div>
    <?php endif; ?>
</div>

</body>
</html>
