<?php
include("config.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai email dan password dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari admin berdasarkan email
    $sql = "SELECT password FROM admin WHERE email = ?";

    // Memastikan $conn adalah objek mysqli yang valid
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Mengambil hash password dari database
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Memverifikasi password
            if (password_verify($password, $hashed_password)) {
                // Redirect ke halaman admin jika login berhasil
                header("Location: admin/index.php");
                exit();
            } else {
                // Jika password salah
                $error = "Email atau password salah. Silakan coba lagi.";
            }
        } else {
            // Jika email tidak ditemukan
            $error = "Email atau password salah. Silakan coba lagi.";
        }
        $stmt->close();
    } else {
        // Menangani kesalahan jika prepare() gagal
        $error = "Terjadi kesalahan dalam query database.";
    }
    $conn->close();
}
?>
