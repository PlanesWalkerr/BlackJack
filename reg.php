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

$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
$password=md5($password);
$result=1;

//Подключаемся к базе данных.
$dbcon = mysqli_connect("localhost", "admin", "mix042");
mysqli_select_db($dbcon, "BlackJack");
if (!$dbcon) {
    echo "<p>Произошла ошибка при подсоединении к MySQL!</p>" . mysqli_connect_error();
    exit();
} else {
    if (!mysqli_select_db($dbcon, "BlackJack")) {
        echo("<p>Выбранной базы данных не существует!</p>");
    }
}
$res = mysqli_query($dbcon,"SELECT * FROM Users WHERE login='$login'");
$myrow = mysqli_fetch_array($res);

if (empty($myrow["password"])) {
    //если пользователя с введенным логином не существует
    $request=mysqli_query($dbcon, "INSERT INTO Users (login,password,balance) VALUES ('$login','$password','1000')");
    if($res = mysqli_affected_rows($dbcon)==-1){
        $result=1;
    }
    else{
        $res = mysqli_query($dbcon, "SELECT MAX(id) FROM Users");
        $count = mysqli_fetch_row($res);
        $nextUserId=$count[0]++;
        $_SESSION['login'] = $login;
        $_SESSION['id'] = $nextUserId;
        $result=0;
    }
}

 else {
        $result=2;

}
mysqli_close($dbcon);
print $result;

?>