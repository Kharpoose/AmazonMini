<?php
require_once("../includes/db.php"); // データベース接続

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);

    // パスワードをハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO amazon_login (username, email, password, address, phone) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $hashedPassword, $address, $phone]);

        // 登録成功 → ログインページへリダイレクト
        header("Location: login.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "エラーが発生しました: " . $e->getMessage();
    }
}
?>

<!-- シンプルな登録フォーム -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <link rel="stylesheet" href="../assets/css/login/register.css">
</head>

<body>
    <h2>新規登録</h2>
    <form method="POST" action="register.php">
        <label>ユーザー名:</label><br>
        <input type="text" name="username" required><br><br>

        <label>メールアドレス:</label><br>
        <input type="email" name="email" required><br><br>

        <label>パスワード:</label><br>
        <input type="password" name="password" required><br><br>

        <label>住所:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label>電話番号:</label><br>
        <input type="text" name="phone" required><br><br>

        <button type="submit">登録する</button>
        <p><a href="login.php">ログインはこちら</a></p>
    </form>
</body>

</html>