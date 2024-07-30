<?php
session_start();

$_SESSION["pengguna"] = "";
$_SESSION["jenis_pengguna"] = "";

// Atur zona waktu baru
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');

$_SESSION["tanggal"] = $tanggal;

include("config.php");

$error = ''; // Variabel untuk menyimpan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $_SESSION["pribadi"] = array(
        'nama_lengkap' => $_POST['nama_lengkap'],
        'alamat' => $_POST['address']
    );

    // Ambil data untuk registrasi
    $email = $_POST['email_baru'];
    $telepon = $_POST['telepon'];
    $kata_sandi_baru = $_POST['kata_sandi_baru'];
    $konfirmasi_kata_sandi = $_POST['konfirmasi_kata_sandi'];
    
    if ($kata_sandi_baru == $konfirmasi_kata_sandi) {
        $sql_utama = "SELECT * FROM pengguna WHERE email = ?;";
        $stmt = $conn->prepare($sql_utama); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $hasil = $stmt->get_result();
        if ($hasil->num_rows == 1) {
            $error = '<label class="form-error">Alamat Email Sudah Terdaftar.</label>';
        } else {
            // Menyimpan data ke tabel pengguna
            $stmt_insert = $conn->prepare("INSERT INTO pengguna (nama_lengkap, alamat, email, nomor_telepon, kata_sandi) VALUES (?, ?, ?, ?, ?);");
            $kata_sandi_hash = password_hash($kata_sandi_baru, PASSWORD_BCRYPT); // Hash password
            $stmt_insert->bind_param("sssss", $_SESSION['pribadi']['nama_lengkap'], $_SESSION['pribadi']['alamat'], $email, $telepon, $kata_sandi_hash);
            $stmt_insert->execute();

            $_SESSION["pengguna"] = $email;
            $_SESSION["jenis_pengguna"] = "p";
            $_SESSION["nama_pengguna"] = $_SESSION['pribadi']['nama_lengkap'];

            header('Location: pengguna/index.php');
            exit(); 
        }
    } else {
        $error = '<label class="form-error">Terjadi Kesalahan Konfirmasi Kata Sandi! Mohon Konfirmasi Ulang Kata Sandi Anda.</label>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">  
    <title>Buat Akun</title>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
                <td colspan="2">
                    <p class="header-text">Mari Bergabung Bersama Aliya Tour</p>
                    <p class="sub-text">Masukkan Detail Pribadi Anda untuk Melanjutkan.</p>
                </td>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat:</label>
                    <input type="text" name="address" id="address" placeholder="Alamat" required>
                </div>
                <div class="form-group form-group-inline">
                    <div class="form-group-inline-item">
                        <label for="email_baru">Email:</label>
                        <input type="email" name="email_baru" id="email_baru" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group-inline-item">
                        <label for="telepon">Nomor Telepon:</label>
                        <input type="tel" name="telepon" id="telepon" placeholder="contoh: 081356935056" pattern="[0-9]{12}" required>
                    </div>
                </div>
                <div class="form-group form-group-inline">
                    <div class="form-group-inline-item">
                        <label for="kata_sandi_baru">Buat Password Baru:</label>
                        <input type="password" name="kata_sandi_baru" id="kata_sandi_baru" placeholder="Password Baru" required>
                    </div>
                    <div class="form-group-inline-item">
                        <label for="konfirmasi_kata_sandi">Konfirmasi Password:</label>
                        <input type="password" name="konfirmasi_kata_sandi" id="konfirmasi_kata_sandi" placeholder="Konfirmasi Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $error ?>
                </div>
                <div class="form-group">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Daftar">
                </div>
                <div class="form-group">
                    <p>Sudah Memiliki Akun? <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
