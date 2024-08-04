<?php
include '../config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $hari = $_POST['hari'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Memeriksa apakah format file diperbolehkan
    $allowed_types = array('jpg', 'jpeg', 'png');
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {

            $gambar_path = basename($_FILES["gambar"]["name"]); 

            $sql = "INSERT INTO paket_wisata (judul, hari, harga, keterangan, gambar, tanggal_mulai, tanggal_akhir) 
                    VALUES ('$judul', $hari, $harga, '$keterangan', '$gambar_path', '$tanggal_mulai', '$tanggal_akhir')";

            if ($conn->query($sql) === TRUE) {
                header("Location: paketwisata.php"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "Maaf, hanya file dengan format JPG, JPEG, & PNG yang diperbolehkan.";
    }
    $conn->close();  // Menutup koneksi database
}
?>

<?php include '../nav/headeradmin.php'; ?>

<link rel="stylesheet" href="../css/tambah.css">

<div class="container">
    <?php include '../nav/sidebar.php'; ?>
    <main class="content">
        <h2 style="text-align: center; margin-bottom: 20px; color: #ff2994;">Tambah Paket Wisata</h2>

        <form class="add-product-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gambar">Upload Gambar (JPG, JPEG, PNG):</label>
                <input type="file" name="gambar" id="gambar" accept=".jpg, .jpeg, .png" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" id="judul" required>
            </div>
            <div class="form-group">
                <label for="hari">Hari:</label>
                <input type="number" name="hari" id="hari" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" step="0.01" name="harga" id="harga" required>
            </div>
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required>
            </div>
            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir:</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" required>
            </div>
            <div class="form-group keterangan-group">
                <label for="keterangan">Keterangan:</label>
                <textarea name="keterangan" id="keterangan" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>

    </main>
</div>
