<?php
include 'config.php';

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
    $tanggal = $_POST['tanggal'];
    $jumlah_orang = intval($_POST['jumlah_orang']);
    $pelayanan = isset($_POST['pelayanan']) ? $_POST['pelayanan'] : [];

    if (empty($tanggal) || empty($jumlah_orang)) {
        $message = "Data form pemesanan terisi.";
    } else {
        $harga_paket = 0;

        // Hitung harga paket perjalanan berdasarkan pilihan
        if (in_array('penginapan', $pelayanan)) {
            $harga_paket += 1000000;
        }
        if (in_array('transportasi', $pelayanan)) {
            $harga_paket += 1200000;
        }
        if (in_array('makanan', $pelayanan)) {
            $harga_paket += 500000;
        }

        // Hitung jumlah tagihan
        $total_harga = $harga_paket * $jumlah_orang * $row['hari'];

        $message = "Harga Paket Perjalanan: Rp. " . number_format($harga_paket, 0, ',', '.') . "<br>" .
                   "Jumlah Tagihan: Rp. " . number_format($total_harga, 0, ',', '.');
    }

    // Tampilkan pesan
    echo "<p>$message</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Paket Wisata</title>
    <link rel="stylesheet" href="../css/detail.css">
</head>
<body>
    <?php include 'nav/header.php'; ?>
    <div class="container">
        <div class="image">
            <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" style="width: 100%; height: auto;">
        </div>
        <div class="details">
            <h1><?php echo htmlspecialchars($row['judul']); ?></h1>
            <table>
                <tr>
                    <th>Keterangan</th>
                    <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                </tr>
                <tr>
                    <th>Hari</th>
                    <td><?php echo htmlspecialchars($row['hari']); ?> hari</td>
                </tr>
                <tr>
                    <th>Harga per Orang</th>
                    <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                </tr>
            </table>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                <div class="form-group">
                    <label for="tanggal">Tanggal Keberangkatan:</label>
                    <input type="date" name="tanggal" id="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_orang">Jumlah Orang:</label>
                    <input type="number" name="jumlah_orang" id="jumlah_orang" min="1" required>
                </div>
                <div class="form-group">
                    <label>Pilih Pelayanan:</label><br>
                    <input type="checkbox" name="pelayanan[]" value="penginapan"> Penginapan (Rp. 1.000.000)<br>
                    <input type="checkbox" name="pelayanan[]" value="transportasi"> Transportasi (Rp. 1.200.000)<br>
                    <input type="checkbox" name="pelayanan[]" value="makanan"> Makanan (Rp. 500.000)<br>
                </div>
                <div class="form-group">
                    <input type="submit" value="Hitung Harga">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
