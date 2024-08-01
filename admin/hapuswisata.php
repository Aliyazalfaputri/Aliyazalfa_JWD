<?php
include '../config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ID produk ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk mendapatkan nama file gambar dari database
    $sql = "SELECT gambar FROM paket_wisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gambar = $row['gambar'];

        // Menghapus gambar dari direktori
        if ($gambar) {
            $target_file = "../uploads/" . $gambar;
            if (file_exists($target_file)) {
                unlink($target_file);
            }
        }

        // Query untuk menghapus data dari database
        $sql = "DELETE FROM paket_wisata WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Mengalihkan ke halaman daftar paket wisata
            header("Location: paketwisata.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Data tidak ditemukan.";
    }

    // Menutup statement
    $stmt->close();
} else {
    echo "ID tidak diberikan.";
}

// Menutup koneksi
$conn->close();
?>
