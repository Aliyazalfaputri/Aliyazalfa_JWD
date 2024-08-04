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
        $tanggal_mulai = new DateTime($row['tanggal_mulai']);
        $tanggal_akhir = new DateTime($row['tanggal_akhir']);
        $tanggal_mulai_formatted = $tanggal_mulai->format('j M Y');
        $tanggal_akhir_formatted = $tanggal_akhir->format('j M Y');
        $durasi = $row['hari'];
    } else {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak diberikan.");
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jumlah_orang = intval($_POST['jumlah_orang']);
    $pelayanan = isset($_POST['pelayanan']) ? $_POST['pelayanan'] : [];

    if (empty($jumlah_orang)) {
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
        $harga_per_orang = $row['harga'] * $jumlah_orang;
        $harga_paket_per_orang = $harga_paket;

        // Hitung total harga
        $total_harga = (($harga_per_orang) + ($harga_paket_per_orang * $jumlah_orang *$durasi));

        $message = "Harga Paket Per Orang: Rp. " . number_format($harga_paket_per_orang, 0, ',', '.') . "<br>" .
                   "Jumlah Tagihan: Rp. " . number_format($total_harga, 0, ',', '.');

        $show_button = true; 
    }
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
    <?php include '../nav/header1.php'; ?>
    <div class="container">
        <div class="details">
            <h1><?php echo htmlspecialchars($row['judul']); ?></h1>
            <div class="image">
                <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" style="width: 100%; height: auto;">
            </div>
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
                <tr>
                    <th>Tanggal Keberangkatan</th>
                    <td><?php echo "$tanggal_mulai_formatted s.d $tanggal_akhir_formatted"; ?></td>
                </tr>
            </table>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                <div class="form-group">
                    <label for="jumlah_orang">Jumlah Orang:</label>
                    <input type="number" name="jumlah_orang" id="jumlah_orang" min="1" required>
                </div>
                <div class="form-group">
                    <label>Pilih Pelayanan:</label><br>
                    <div class="checkbox-label">
                        <input type="checkbox" name="pelayanan[]" value="penginapan"> Penginapan (Rp. 1.000.000)
                    </div>
                    <div class="checkbox-label">
                        <input type="checkbox" name="pelayanan[]" value="transportasi"> Transportasi (Rp. 1.200.000)
                    </div>
                    <div class="checkbox-label">
                        <input type="checkbox" name="pelayanan[]" value="makanan"> Makanan (Rp. 500.000)
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Hitung Harga">
                </div>
            </form>
            <?php
            if ($message) {
                echo "<div class='price-info'><h2>Informasi Harga</h2><p>Harga Paket Per Orang: <span class='price'>Rp. " . number_format($harga_paket_per_orang, 0, ',', '.') . "</span></p><p>Jumlah Tagihan: <span class='price'>Rp. " . number_format($total_harga, 0, ',', '.') . "</span></p>";
                if ($show_button) {
                    $pelayanan_query = http_build_query(array('pelayanan' => $pelayanan));
                    echo '<a href="form_pemesanan.php?id=' . $id . '&jumlah_orang=' . $jumlah_orang . '&harga_paket_per_orang=' . $harga_paket_per_orang . '&total_harga=' . $total_harga . '&' . $pelayanan_query . '&tanggal_mulai=' . urlencode($tanggal_mulai_formatted) . '&tanggal_akhir=' . urlencode($tanggal_akhir_formatted) . '" class="btn">Isi Form Pemesanan</a>';
                    }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
