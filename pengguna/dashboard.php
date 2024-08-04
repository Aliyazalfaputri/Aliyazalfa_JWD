<?php
// Menghubungkan ke database
include '../config.php';

// Mengambil data dari tabel paket_wisata
$query = "SELECT * FROM paket_wisata";
$result = mysqli_query($conn, $query);
mysqli_close($conn);

include '../nav/header1.php'; 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css"> 
    <title>Dashboard - Paket Wisata</title>
</head>
<body>
    <div class="container">
        <div class="cards">
            <?php
            // Menampilkan data dari database
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="card">
                <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                    <div class="card-content">
                        <h2><?php echo $row['judul']; ?></h2>
                        <p><?php echo $row['hari']; ?> hari</p>
                        <p>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?> / orang</p>
                        <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn">Lihat Detail</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>



