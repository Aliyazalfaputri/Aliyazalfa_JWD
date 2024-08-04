<?php
session_start();
include '../config.php';


$sql = "SELECT id, judul, hari, harga, gambar FROM paket_wisata";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Wisata</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../nav/headeradmin.php'; ?>
    <div class="container">
        <?php include '../nav/sidebar.php'; ?>
        <main class="content">
            <h2>Daftar Paket Wisata</h2>
            <button class="mod-btn"><a href="tambahwisata.php">Tambah Data</a></button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Judul Paket Wisata</th>
                        <th>Lama Perjalanan (Hari)</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $gambar = $row["gambar"] ? '../uploads/' . $row["gambar"] : 'path/to/default-image.jpg';
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td><img src='" . $gambar . "' alt='Gambar Paket' style='width: 100px; height: auto;'></td>";
                            echo "<td>" . $row["judul"] . "</td>";
                            echo "<td>" . $row["hari"] . "</td>";
                            echo "<td>" . $row["harga"] . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<button class='mod-btn'><a href='editwisata.php?id=" . $row["id"] . "'>Edit</a></button>";
                            echo "<button class='mod-btn'><a href='hapuswisata.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus paket wisata ini?\")'>Hapus</a></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
