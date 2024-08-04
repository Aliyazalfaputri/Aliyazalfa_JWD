<?php
include '../config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ID pengguna ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk menghapus data pengguna dari database
    $sql = "DELETE FROM pengguna WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: bukutamu.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    echo "ID tidak diberikan.";
}

// Menutup koneksi
$conn->close();
?>
