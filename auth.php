<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if ($login == '') {
        unset($login);
    }
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if ($password == '') {
        unset($password);
    }
}

if (empty($login) or empty($password)){
    exit ("<body><div align='center'><br/><br/><br/><h3>Вы ввели не всю информацию, вернитесь назад и заполните все поля!"
            . "<a href='index.php'> <b>Назад</b> </a></h3></div></body>");
}
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
$login = trim($login);
$password = trim($password);

$dbcon = mysqli_connect("localhost", "root", "");
mysqli_select_db($dbcon,"BlackJack");
if (!$dbcon) {
    echo "<p>Произошла ошибка при подсоединении к MySQL!</p>" . mysqli_connect_error();
    exit();
} else {
    if (!mysqli_select_db($dbcon, "BlackJack")) {
        echo("<p>Выбранной базы данных не существует!</p>");
    }
}
$result = mysqli_query($dbcon,"SELECT * FROM Users WHERE login='$login'");
$myrow = mysqli_fetch_array($result);
if (empty($myrow["password"])) {
    exit ("<body><div align='center'><br/><br/><br/>
	<h3>Извините, введённый вами login или пароль неверный." . "<a href='index.php'> <b>Назад</b> </a></h3></div></body>");
} else {
    if ($myrow["password"] == $password) {
        $_SESSION['login'] = $myrow["login"];
        $_SESSION['id'] = $myrow["id"];
        header("Location:index.php");
    } else {
        exit ("<body><div align='center'><br/><br/><br/>
	<h3>Извините, введённый вами login или пароль неверный." . "<a href='index.php'> <b>Назад</b> </a></h3></div></body>");
    }
}
mysqli_close($dbcon);
?>