<?php
include '../config.php'; // Menghubungkan ke database

// Query untuk mengambil data dari tabel reservasi
$sql = "SELECT id, nama_pemesan, nomor_tel_hp, waktu_pelaksanaan, jumlah_peserta, pelayanan_paket, harga_paket, jumlah_tagihan FROM reservasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Reservasi</title>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <?php include '../nav/headeradmin.php'; ?> 
    <div class="container">
        <?php include '../nav/sidebar.php'; ?> 
        <main class="content">
            <h2>Daftar Reservasi</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemesan</th>
                        <th>Nomor Telp/HP</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Jumlah Peserta</th>
                        <th>Pelayanan Paket</th>
                        <th>Harga Paket</th>
                        <th>Jumlah Tagihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["nama_pemesan"] . "</td>";
                            echo "<td>" . $row["nomor_tel_hp"] . "</td>";
                            echo "<td>" . $row["waktu_pelaksanaan"] . "</td>";
                            echo "<td>" . $row["jumlah_peserta"] . "</td>";
                            echo "<td>" . $row["pelayanan_paket"] . "</td>";
                            echo "<td>" . $row["harga_paket"] . "</td>";
                            echo "<td>" . $row["jumlah_tagihan"] . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<button class='mod-btn'><a href='editkelolareservasi.php?id=" . $row["id"] . "'>Edit</a></button>";
                            echo "<button class='mod-btn'><a href='kelolareservasi.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus reservasi ini?\")'>Hapus</a></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
