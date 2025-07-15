<?php
require_once("../includes/db.php"); // Veritabanı bağlantısını dahil et

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);

    // Şifreyi güvenli hale getir
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO amazon_login (username, email, password, address, phone) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $hashedPassword, $address, $phone]);

        // Kayıt başarılı → login sayfasına yönlendir
        header("Location: login.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "Hata oluştu: " . $e->getMessage();
    }
}
?>

<!-- Basit HTML form -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="../assets/css/login/register.css">

</head>

<body>
    <h2>Kayıt Ol</h2>
    <form method="POST" action="register.php">
        <label>Kullanıcı Adı:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Şifre:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Adres:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label>Telefon:</label><br>
        <input type="text" name="phone" required><br><br>

        <button type="submit">Kayıt Ol</button>
        <p> <a href="login.php">giris yap</a></p>

    </form>
</body>

</html>