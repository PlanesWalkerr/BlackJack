<?php

if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
if (isset($_POST['bet'])) {
    $bet = $_POST['bet'];
}
if (isset($_POST['result'])) {
    $result = $_POST['result'];
}
$date = date("Y-m-d H:i:s");
$dbcon = mysqli_connect("localhost", "root", "");
mysqli_select_db($dbcon, "BlackJack");
if (!$dbcon) {
    echo "<p>Произошла ошибка при подсоединении к MySQL!</p>" . mysqli_connect_error();
    exit();
} else {
    if (!mysqli_select_db($dbcon, "BlackJack")) {
        echo("<p>Выбранной базы данных не существует!</p>");
    }
}
$res = mysqli_query($dbcon, "SELECT id FROM Users WHERE login='$login'");
while ($row = mysqli_fetch_array($res)) {
    $id = $row["id"];
}
mysqli_query($dbcon, "INSERT INTO Results VALUES ('$id', '$login', '$date', '$bet', '$result')");
mysqli_close($dbcon);

?>