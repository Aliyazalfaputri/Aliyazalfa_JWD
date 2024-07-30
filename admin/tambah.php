<?php
include '../config.php'; 

// Memeriksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari formulir
    $judul = $_POST['judul'];
    $hari = $_POST['hari'];
    $harga = $_POST['harga'];

    // Menyimpan data ke database menggunakan koneksi dari config.php
    $sql = "INSERT INTO paket_wisata (judul, hari, harga) VALUES ('$judul', '$hari', '$harga')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: paketwisata.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi database
    $conn->close();
}
?>

<?php include '../nav/headeradmin.php'; ?>

<link rel="stylesheet" href="../css/tambah.css">

<div class="container">
    <?php include '../nav/sidebar.php'; ?>
    <main class="content">
        <h2 style="text-align: center; margin-bottom: 20px; color: #ff2994;">Tambah Paket Wisata</h2>

        <form class="add-product-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                <input type="submit" value="Submit">
            </div>
        </form>
    </main>
</div>

