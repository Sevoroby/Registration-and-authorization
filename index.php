<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
session_start();
$CSRFtoken = bin2hex(random_bytes(32)); // Генерация CSRF-токена
$_SESSION['csrf'] = $CSRFtoken;
?>
<form align="center" method="POST" action="reg.php">
    <button type="submit">Регистрация</button>
</form>
<form align="center" method="POST" action="auth.php">
    <button type="submit">Авторизация</button>
    <input type="hidden" name="csrf" value="<?php echo $CSRFtoken; ?>"></button>
</form>
</body>
</html>
