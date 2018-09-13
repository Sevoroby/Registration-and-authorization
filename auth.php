<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
$data = $_POST;
if (isset($data['auth']))
{ 
  session_start();
  if (!hash_equals($data['csrf'],$_SESSION['csrf'])) die ('<p align="center">CSRF-атака!</p> 
	 <form align="center" action="index.php" method="POST">
	  <button type="submit" >На главную</button>
	  </form>');  //Проверка CSRF-токена
  $conn = mysqli_connect('localhost','root'); 
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error($conn);
  mysqli_select_db($conn,'test'); //Соединение с БД
  $res = array();  //Массив, содержащий ошибки
  if (trim($data['login']) == '') $res[] = 'Введите логин';
  if (trim($data['pass']) == '') $res[] = 'Введите пароль';
  $login = $data['login'];
  $pass = $data['pass'];
  $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT login,password FROM users WHERE login='".$login."'"));
  if ($result['login']==$login) 
	{
	   if ($result['password']!=md5($pass)) $res[] = 'Неверный пароль';
	} 
   else  $res[] = 'Такого пользователя не существует';
   if (empty($res)) //Если список ошибок пуст, то аутентификация проходит успешно
   {
	   die('<p align="center">Приветствуем, '.$login.'!</p>
	 <form align="center" action="index.php" method="POST">
	  <button type="submit" >На главную</button>
	  </form>');
   }
   else echo '<p align="center">'.array_shift($res).'</p>';
  
}
?>
<form align="center" action="auth.php" method="POST">
<p>
<p>Логин</p>
<input type="text" name="login" value="<?php echo @$data['login'];?>">
</p>

<p>
<p>Пароль</p>
<input type="password" name="pass" value="<?php echo @$data['pass'];?>">
</p>
  <button type="submit" name="auth">Войти</button>
  <input type="hidden" name="csrf" value="<?php echo @$data['csrf'];?>">
</p>
</form>
<form align="center" method="POST" action="index.php">
    <button type="submit">Назад</button>
</form>
</body>
</html>