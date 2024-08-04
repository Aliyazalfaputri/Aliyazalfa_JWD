<?php
include '../config.php';
include '../nav/header1.php'; 

// Membuka koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $nomer_telp = $_POST['nomer_telp'];
    $waktu_pelaksanaan = $_POST['waktu_pelaksanaan'];
    $jumlah_peserta = $_POST['jumlah_peserta'];
    $jenis_tour = $_POST['jenis_tour'];
    $pelayanan_paket = implode(', ', $_POST['pelayanan']);
    
    $harga_paket = preg_replace('/\D/', '', $_POST['harga_paket']);
    $jumlah_tagihan = preg_replace('/\D/', '', $_POST['jumlah_tagihan']);

    $query = "INSERT INTO reservasi (nama_pemesan, nomor_tel_hp, waktu_pelaksanaan, jumlah_peserta, jenis_tour, pelayanan_paket, harga_paket, jumlah_tagihan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssss', $nama_pemesan, $nomer_telp, $waktu_pelaksanaan, $jumlah_peserta, $jenis_tour, $pelayanan_paket, $harga_paket, $jumlah_tagihan);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }


    $stmt->close();
    $conn->close(); // Tutup koneksi database
} 

else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nama_pemesan = isset($_GET['nama_pemesan']) ? htmlspecialchars($_GET['nama_pemesan']) : '';
    $nomer_telp = isset($_GET['nomer_telp']) ? htmlspecialchars($_GET['nomer_telp']) : '';
    $waktu_pelaksanaan = isset($_GET['waktu_pelaksanaan']) ? htmlspecialchars($_GET['waktu_pelaksanaan']) : '';
    $jumlah_peserta = isset($_GET['jumlah_peserta']) ? intval($_GET['jumlah_peserta']) : 0;
    

    $pelayanan = isset($_GET['pelayanan']) ? (is_array($_GET['pelayanan']) ? $_GET['pelayanan'] : explode(',', $_GET['pelayanan'])) : [];
    
    $harga_paket = isset($_GET['harga_paket']) ? htmlspecialchars($_GET['harga_paket']) : '';
    $jumlah_tagihan = isset($_GET['jumlah_tagihan']) ? htmlspecialchars($_GET['jumlah_tagihan']) : '';


    $pelayanan_paket = implode(', ', $pelayanan);
    $jenis_tour = isset($_GET['jenis_tour']) ? htmlspecialchars($_GET['jenis_tour']) : '';

    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Review Pesanan</title>
        <link rel="stylesheet" href="../css/reservasi.css">
    </head>
    <body>
        <div class="form-containernew">
            <h2>Review Pesanan</h2>
            <p><strong>Nama:</strong> <?php echo $nama_pemesan; ?></p>
            <p><strong>Jumlah Peserta:</strong> <?php echo $jumlah_peserta; ?></p>
            <p><strong>Waktu Perjalanan:</strong> <?php echo $waktu_pelaksanaan; ?></p>
            <p><strong>Jenis Tour:</strong> <?php echo $jenis_tour; ?></p>
            <p><strong>Layanan Paket:</strong> <?php echo $pelayanan_paket; ?></p>
            <p><strong>Harga Paket:</strong> <?php echo $harga_paket; ?></p>
            <p><strong>Jumlah Tagihan:</strong> <?php echo $jumlah_tagihan; ?></p>

            <div class="button-container">
            <form action="reservasi.php" method="post">
                <input type="hidden" name="nama_pemesan" value="<?php echo htmlspecialchars($nama_pemesan); ?>">
                <input type="hidden" name="nomer_telp" value="<?php echo htmlspecialchars($nomer_telp); ?>">
                <input type="hidden" name="waktu_pelaksanaan" value="<?php echo htmlspecialchars($waktu_pelaksanaan); ?>">
                <input type="hidden" name="jumlah_peserta" value="<?php echo intval($jumlah_peserta); ?>">
                <input type="hidden" name="jenis_tour" value="<?php echo htmlspecialchars($jenis_tour); ?>">
                <input type="hidden" name="pelayanan[]" value="<?php echo htmlspecialchars(implode(', ', $pelayanan)); ?>">
                <input type="hidden" name="harga_paket" value="<?php echo htmlspecialchars($harga_paket); ?>">
                <input type="hidden" name="jumlah_tagihan" value="<?php echo htmlspecialchars($jumlah_tagihan); ?>">
                <button type="submit" class="simpan">Simpan</button>
            </form>
            <a href="dashboard.php" class="batal">Batal</a>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
