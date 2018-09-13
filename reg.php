<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
$data = $_POST;
if (isset($data['reg'])) 
{
  $conn = mysqli_connect('localhost','root');
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error($conn);
  mysqli_select_db($conn,'test'); //Соединение с БД
  $res = array();  //Массив, содержащий ошибки
  if (trim($data['login']) == '') $res[] = 'Введите логин!';
  if (trim($data['email']) == '') $res[] = 'Введите e-mail!';
  if (trim($data['pass']) == '') $res[] = 'Введите пароль!';
  if (trim($data['passrepeat']) == '') $res[] = 'Введите повторный пароль!'; 
  elseif (trim($data['passrepeat']) != $data['pass']) $res[] = 'Неверно введён повторный пароль!';
  $login = $data['login'];
  $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT login FROM users WHERE login='".$login."'")); 
  if ($result['login']==$login) $res[]= 'Такой пользователь уже существует!';
  $email = $data['email'];
  $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT email FROM users WHERE email='".$email."'"));
  if ($result['email']==$email) $res[]= 'Такой e-mail уже существует!';
  if (empty($res)) //Если список ошибок пуст, то регистрация проходит успешно
  {
	$pass = md5($data['pass']); //Шифрование пароля
	$query = mysqli_query($conn,"INSERT INTO users(login,email,password) VALUES ('$login','$email','$pass')");
	die('<p align="center">Регистрация проведена успешно!</p>
	<form align="center" action="index.php" method="POST">
	<button type="submit" >На главную</button>
	</form>');
  } else echo '<p align="center">'.array_shift($res).'</p>';  
}
?>
<form align="center" action="reg.php" method="POST">
<p>
<p>Логин</p>
<input type="text" name="login" value="<?php echo @$data['login'];?>">
</p>

<p>
<p>e-mail</p>
<input type="text" name="email" value="<?php echo @$data['email'];?>">
</p>

<p>
<p>Пароль</p>
<input type="password" name="pass" value="<?php echo @$data['pass'];?>">
</p>

<p>
<p>Повторите пароль</p>
<input type="password" name="passrepeat">
</p>
<p>
  <button type="submit" name="reg">Зарегистрироваться</button>
</p>
</form>
<form align="center" method="POST" action="index.php">
    <button type="submit">Назад</button>
</form>
</body>
</html>
