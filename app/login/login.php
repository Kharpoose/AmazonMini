<?php
session_start();
require_once '../includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM amazon_login WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Oturum değişkenlerini tutarlı şekilde ayarla
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'address' => $user['address'],
                'phone' => $user['phone']
            ];
            $_SESSION['kullanici_id'] = $user['id']; // index.php için
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Geçersiz e-posta veya şifre.";
        }
    } else {
        $error = "Lütfen e-posta ve şifre girin.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="../assets/css/login/login.css">

</head>
<body>
    <h2>Giriş Yap</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Şifre:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Giriş Yap</button>
    </form>

    <p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
</body>
</html>
