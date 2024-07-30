<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari session
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['address'];
    $email = $_POST['email_baru'];
    $telepon = $_POST['telepon'];
    $kata_sandi_baru = $_POST['kata_sandi_baru'];
    $konfirmasi_kata_sandi = $_POST['konfirmasi_kata_sandi'];
    
    if ($kata_sandi_baru == $konfirmasi_kata_sandi) {
        $sql_utama = "SELECT * FROM pengguna WHERE email = ?;";
        $stmt = $database->prepare($sql_utama);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $hasil = $stmt->get_result();
        if ($hasil->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Alamat Email Sudah Terdaftar.</label>';
        } else {

            // Menyimpan data ke tabel pengguna
            $stmt_insert = $database->prepare("INSERT INTO pengguna (nama_lengkap, alamat, email, nomor_telepon, kata_sandi) VALUES (?, ?, ?, ?, ?);");
            $kata_sandi_hash = password_hash($kata_sandi_baru, PASSWORD_BCRYPT); // Hash password
            $stmt_insert->bind_param("sssss", $nama_lengkap, $alamat, $email, $telepon, $kata_sandi_hash);
            $stmt_insert->execute();

            $_SESSION["pengguna"] = $email;
            $_SESSION["jenis_pengguna"] = "p";
            $_SESSION["nama_pengguna"] = $nama_lengkap;

            header('Location: pengguna/index.php');
            exit(); 
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Terjadi Kesalahan Konfirmasi Kata Sandi! Mohon Konfirmasi Ulang Kata Sandi Anda.</label>';
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
<center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">REGISTER</p>
                </td>
            </tr>
            <form action="" method="POST">
            <tr>
                    <td class="label-td" colspan="2">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="nama_lengkap" class="input-text" placeholder="Nama Lengkap" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="address" class="form-label">Alamat: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="address" class="input-text" placeholder="Alamat" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="email_baru" class="form-label">Email: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="email" name="email_baru" class="input-text" placeholder="Alamat Email" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="telepon" class="form-label">Nomor Telepon: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="tel" name="telepon" class="input-text" placeholder="contoh: 081356935056" pattern="[0-9]{12}" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="kata_sandi_baru" class="form-label">Buat Password Baru: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="kata_sandi_baru" class="input-text" placeholder="Password Baru" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="konfirmasi_kata_sandi" class="form-label">Konfirmasi Password: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="konfirmasi_kata_sandi" class="input-text" placeholder="Konfirmasi Password" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo $error ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                    </td>
                    <td>
                        <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Sudah Memiliki Akun? </label>
                        <a href="login.php" class="hover-link1 non-style-link">Login</a>
                        <br><br><br>
                    </td>
                </tr>
            </form>
        </table>
    </div>
</center>
</body>
</html>
