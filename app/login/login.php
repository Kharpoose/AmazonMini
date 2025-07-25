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
            // セッション変数を設定
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'address' => $user['address'],
                'phone' => $user['phone']
            ];
            $_SESSION['kullanici_id'] = $user['id']; // index.php用
            header("Location: ../index.php");
            exit;
        } else {
            $error = "メールアドレスまたはパスワードが間違っています。";
        }
    } else {
        $error = "メールアドレスとパスワードを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="../assets/css/login/login.css">
</head>
<body>
    <h2>ログイン</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="email">メールアドレス:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">パスワード:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">ログイン</button>
    </form>

    <p>アカウントをお持ちでない方は <a href="register.php">新規登録</a></p>
</body>
</html>
