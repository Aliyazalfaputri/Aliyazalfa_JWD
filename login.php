<?php
session_start();
include('config.php');

// Debugging: Cek status sesi
var_dump($_SESSION);

$error = '';

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    $redirect_url = $_SESSION['user_role'] === 'admin' ? 'admin/paketwisata.php' : 'pengguna/dashboard.php';
    header("Location: $redirect_url");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_user = "SELECT kata_sandi FROM pengguna WHERE email = ?";
    $sql_admin = "SELECT password FROM admin WHERE email = ?";

    if ($stmt = $conn->prepare($sql_user)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_role'] = 'user'; // Peran pengguna
                $_SESSION['user_email'] = $email;

                header("Location: pengguna/dashboard.php");
                exit();
            } else {
                $error = "Email atau password salah. Silakan coba lagi.";
            }
        } else {
            $stmt->close();
            if ($stmt = $conn->prepare($sql_admin)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($hashed_password);
                    $stmt->fetch();

                    if (password_verify($password, $hashed_password)) {
                        $_SESSION['user_logged_in'] = true;
                        $_SESSION['user_role'] = 'admin'; // Peran admin
                        $_SESSION['user_email'] = $email;

                        header("Location: admin/paketwisata.php");
                        exit();
                    } else {
                        $error = "Email atau password salah. Silakan coba lagi.";
                    }
                } else {
                    $error = "Email atau password salah. Silakan coba lagi.";
                }
                $stmt->close();
            } else {
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
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
