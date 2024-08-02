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
    // Mengambil data dari database
    $sql = "SELECT * FROM paket_wisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak diberikan.");
}

// Memproses formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $hari = $_POST['hari'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    // Penanganan unggahan file gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png');

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Update database dengan nama gambar baru
                $gambar = basename($_FILES["gambar"]["name"]);
                $sql = "UPDATE paket_wisata SET judul = ?, hari = ?, harga = ?, keterangan = ?, gambar = ?, tanggal_mulai = ?, tanggal_akhir = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sidsisi", $judul, $hari, $harga, $keterangan, $gambar, $tanggal_mulai, $tanggal_akhir, $id);
                
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
                $gambar = $row['gambar']; // Gunakan gambar lama jika gagal unggah
            }
        } else {
            echo "Maaf, hanya file dengan format JPG, JPEG, & PNG yang diperbolehkan.";
            $gambar = $row['gambar']; // Gunakan gambar lama jika format tidak sesuai
        }
    } else {
        $gambar = $row['gambar']; // Gunakan gambar lama jika tidak ada file baru yang diunggah
        // Update database tanpa mengubah gambar
        $sql = "UPDATE paket_wisata SET judul = ?, hari = ?, harga = ?, keterangan = ?, tanggal_mulai = ?, tanggal_akhir = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidsisi", $judul, $hari, $harga, $keterangan, $tanggal_mulai, $tanggal_akhir, $id);
    }

    if ($stmt->execute()) {
        header("Location: paketwisata.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup koneksi database
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Wisata</title>
    <link rel="stylesheet" href="../css/tambah.css">
</head>
<body>
    <?php include '../nav/headeradmin.php'; ?>
    <div class="container">
        <?php include '../nav/sidebar.php'; ?>
        <main class="content">
            <h2>Edit Paket Wisata</h2>
            <form class="add-product-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="gambar">Gambar Saat Ini:</label>
                    <?php if (!empty($row['gambar'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Paket Wisata" width="200">
                    <?php else: ?>
                        <p>Tidak ada gambar saat ini.</p>
                    <?php endif; ?>
                    <label for="gambar">Upload Gambar Baru (JPG, JPEG, PNG):</label>
                    <input type="file" name="gambar" id="gambar" accept=".jpg, .jpeg, .png">
                </div>
                <div class="form-group">
                    <label for="judul">Judul:</label>
                    <input type="text" name="judul" id="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="hari">Hari:</label>
                    <input type="number" name="hari" id="hari" value="<?php echo htmlspecialchars($row['hari']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" step="0.01" name="harga" id="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Awal:</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="<?php echo htmlspecialchars($row['tanggal_mulai']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo htmlspecialchars($row['tanggal_akhir']); ?>" required>
                </div>
                <div class="form-group keterangan-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea name="keterangan" id="keterangan" required><?php echo htmlspecialchars($row['keterangan']); ?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Update">
                </div>
            </form>
        </main>
    </div>
</body>
</html>
