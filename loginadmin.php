//PASSWORD ADMIN : 123

<?php
include 'config.php';

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Username dan password admin
$username = 'admintravel';
$password = password_hash('123', PASSWORD_DEFAULT);

// Cek apakah username sudah ada
$sql_check = "SELECT * FROM admin WHERE username = '$username'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows == 0) {
    // Query untuk memasukkan data admin ke tabel admin
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        echo "Data admin berhasil dimasukkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();

// Redirect to admin/index.php
header("Location: admin/index.php");
exit();
?>
