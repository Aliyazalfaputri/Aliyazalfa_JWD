<?php
include '../config.php';
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aliya Tour</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>
        <div class="container-header">
            <h1 class="brand">Aliya Tour</h1>
            <div class="profile">
                <a href="index.php">
                    <i class="fas fa-user-circle"></i>
                    <div class="profile-text">
                        <strong>Admin</strong>
                    </div>
                </a>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>
</body>

</html>

