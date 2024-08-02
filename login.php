<?php
include("config.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai email dan password dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan email
    $sql_user = "SELECT kata_sandi FROM pengguna WHERE email = ?";
    $sql_admin = "SELECT password FROM admin WHERE email = ?";

    // Memastikan $conn adalah objek mysqli yang valid
    if ($stmt = $conn->prepare($sql_user)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Mengambil hash password dari database
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Memverifikasi password
            if (password_verify($password, $hashed_password)) {
                // Redirect ke halaman pengguna jika login berhasil
                header("Location: dashboard.php");
                exit();
            } else {
                // Jika password salah
                $error = "Email atau password salah. Silakan coba lagi.";
            }
        } else {
            // Jika tidak ditemukan di tabel pengguna, cek tabel admin
            $stmt->close();
            if ($stmt = $conn->prepare($sql_admin)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    // Mengambil hash password dari database admin
                    $stmt->bind_result($hashed_password);
                    $stmt->fetch();

                    // Memverifikasi password
                    if (password_verify($password, $hashed_password)) {
                        // Redirect ke halaman admin jika login berhasil
                        header("Location: admin/paketwisata.php");
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
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php include 'nav/header.php'; ?>
    <div class="login-container">
        <div class="login-box">
            <p class="header-text">Selamat Datang di Aliya Tour</p>
            <p class="sub-text">Login untuk Melanjutkan.</p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Login">
                </div>
                <div class="form-group">
                    <p>Belum Memiliki Akun? <a href="register.php">Daftar Akun</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


