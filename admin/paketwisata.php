<?php
include '../config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data produk
$sql = "SELECT id, judul, hari, harga FROM paket_wisata";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Wisata</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/produk.css">
</head>

<body>  
    <div class="container">
        <?php include '../nav/sidebar.php'; ?>
        <main class="content">
            <h2>Daftar Paket Wisata</h2>
            <button class="tambah-btn"><a href="tambah.php">Tambah Data</a></button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Paket Wisata</th>
                        <th>Lama Perjalanan (Hari)</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data dari setiap baris
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["judul"] . "</td>";
                            echo "<td>" . $row["hari"] . "</td>";
                            echo "<td>" . $row["harga"] . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<button class='mod-btn'><a href='admin/editpic.php?id=" . $row["id"] . "'>Edit Gambar</a></button>";
                            echo "<button class='mod-btn'><a href='admin/edit.php?id=" . $row["id"] . "'>Edit</a></button>";
                            echo "<button class='mod-btn'><a href='admin/hapus.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\")'>Hapus</a></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
