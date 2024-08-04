<?php
include '../config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ID reservasi ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Mengambil data dari database
    $sql = "SELECT * FROM reservasi WHERE id = ?";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pemesan = $_POST['nama_pemesan'];
    $nomor_tel_hp = $_POST['nomor_tel_hp'];
    $waktu_pelaksanaan = $_POST['waktu_pelaksanaan'];
    $jumlah_peserta = $_POST['jumlah_peserta'];
    $pelayanan_paket = $_POST['pelayanan_paket'];
    $harga_paket = $_POST['harga_paket'];
    $jumlah_tagihan = $_POST['jumlah_tagihan'];

    // Update database
    $sql = "UPDATE reservasi SET nama_pemesan = ?, nomor_tel_hp = ?, waktu_pelaksanaan = ?, jumlah_peserta = ?, pelayanan_paket = ?, harga_paket = ?, jumlah_tagihan = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisisi", $nama_pemesan, $nomor_tel_hp, $waktu_pelaksanaan, $jumlah_peserta, $pelayanan_paket, $harga_paket, $jumlah_tagihan, $id);

    if ($stmt->execute()) {
        header("Location: kelolareservasi.php");
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
    <title>Edit Reservasi</title>
    <link rel="stylesheet" href="../css/tambah.css">
</head>
<body>
    <?php include '../nav/headeradmin.php'; ?>
    <div class="container">
        <?php include '../nav/sidebar.php'; ?>
        <main class="content">
            <h2>Edit Reservasi</h2>
            <form class="add-product-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                <div class="form-group">
                    <label for="nama_pemesan">Nama Pemesan:</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" value="<?php echo htmlspecialchars($row['nama_pemesan']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nomor_tel_hp">Nomor Telp/HP:</label>
                    <input type="text" name="nomor_tel_hp" id="nomor_tel_hp" value="<?php echo htmlspecialchars($row['nomor_tel_hp']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="waktu_pelaksanaan">Waktu Pelaksanaan:</label>
                    <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="<?php echo htmlspecialchars($row['waktu_pelaksanaan']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_peserta">Jumlah Peserta:</label>
                    <input type="number" name="jumlah_peserta" id="jumlah_peserta" value="<?php echo htmlspecialchars($row['jumlah_peserta']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="pelayanan_paket">Pelayanan Paket:</label>
                    <input type="text" name="pelayanan_paket" id="pelayanan_paket" value="<?php echo htmlspecialchars($row['pelayanan_paket']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga_paket">Harga Paket:</label>
                    <input type="number" step="0.01" name="harga_paket" id="harga_paket" value="<?php echo htmlspecialchars($row['harga_paket']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_tagihan">Jumlah Tagihan:</label>
                    <input type="number" step="0.01" name="jumlah_tagihan" id="jumlah_tagihan" value="<?php echo htmlspecialchars($row['jumlah_tagihan']); ?>" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Update">
                </div>
            </form>
        </main>
    </div>
</body>
</html>
