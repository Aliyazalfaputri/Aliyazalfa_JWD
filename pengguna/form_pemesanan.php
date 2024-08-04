<?php
include '../config.php';

// Mengambil data dari tabel paket_wisata berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query pertama
    $query = "SELECT judul FROM paket_wisata WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jenis_tour = $row['judul'];
    } else {
        $jenis_tour = 'Unknown'; 
    }
    $stmt->close();
} else {
    $jenis_tour = 'Unknown'; 
}


$jumlah_orang = isset($_GET['jumlah_orang']) ? intval($_GET['jumlah_orang']) : 0;
$harga_paket_per_orang = isset($_GET['harga_paket_per_orang']) ? intval($_GET['harga_paket_per_orang']) : 0;
$total_harga = isset($_GET['total_harga']) ? intval($_GET['total_harga']) : 0;
$pelayanan = isset($_GET['pelayanan']) ? $_GET['pelayanan'] : [];
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';
$tanggal_perjalanan = $tanggal_mulai . ' - ' . $tanggal_akhir; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Paket Wisata</title>
    <link rel="stylesheet" href="../css/formpemesanan.css">
</head>
<body>
<?php include '../nav/header1.php'; ?>
    <div class="form-container">
        <form id="pemesananForm" action="reservasi.php" method="post">
            <h2>Form Pemesanan Paket Wisata</h2>
            <label>Nama Pemesan:</label>
            <input type="text" name="nama_pemesan" required><br>

            <label>Nomer Telp/HP:</label>
            <input type="text" name="nomer_telp" required><br>

            <label>Jenis Tour:</label>
            <input type="text" name="jenis_tour" value="<?php echo htmlspecialchars($jenis_tour); ?>" readonly><br>

            <label>Waktu Pelaksanaan Perjalanan:</label>
            <input type="text" name="waktu_pelaksanaan" value="<?php echo htmlspecialchars($tanggal_perjalanan); ?>" readonly><br>

            <label>Jumlah Peserta:</label>
            <input type="number" name="jumlah_peserta" value="<?php echo htmlspecialchars($jumlah_orang); ?>" required><br>

            <label>Pelayanan Paket Perjalanan:</label><br>
            <input type="checkbox" name="pelayanan[]" value="Penginapan" <?php if(in_array('penginapan', $pelayanan)) echo 'checked'; ?>> Penginapan<br>
            <input type="checkbox" name="pelayanan[]" value="Transportasi" <?php if(in_array('transportasi', $pelayanan)) echo 'checked'; ?>> Transportasi<br>
            <input type="checkbox" name="pelayanan[]" value="Makanan" <?php if(in_array('makanan', $pelayanan)) echo 'checked'; ?>> Makanan<br>

            <label>Harga Paket Perjalanan:</label>
            <input type="text" name="harga_paket" value="<?php echo 'Rp. ' . number_format($harga_paket_per_orang, 0, ',', '.'); ?>" readonly><br>

            <label>Jumlah Tagihan:</label>
            <input type="text" name="jumlah_tagihan" value="<?php echo 'Rp. ' . number_format($total_harga, 0, ',', '.'); ?>" readonly><br>

            <div class="button-container">
                <button type="button" class="review" onclick="reviewPesanan()">Review Pesanan</button>
                <button type="submit" class="simpan">Simpan</button>
                <button type="button" class="batal" onclick="cancelForm()">Batal</button>
            </div>
        </form>
    </div>

    <script>
        function reviewPesanan() {
            var form = document.getElementById('pemesananForm');
            form.action = 'reservasi.php';
            form.method = 'get'; 
            form.submit();
        }

        function cancelForm() {
            window.location.href = 'dashboard.php';
        }
    </script>
</body>
</html>
