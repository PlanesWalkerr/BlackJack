<?php

if (isset($_POST['login'])) { 
	$login = $_POST['login'];
	}
if (isset($_POST['balance'])) { 
	$balance = $_POST['balance'];
	}
$dbcon = mysqli_connect("localhost", "admin", "mix042");
    mysqli_select_db($dbcon,"BlackJack");
	if (!$dbcon)
	{
    echo "<p>Произошла ошибка при подсоединении к MySQL!</p>".mysqli_connect_error(); exit();
    } else {
    if (!mysqli_select_db($dbcon,"BlackJack"))
    {
    echo("<p>Выбранной базы данных не существует!</p>");
    }
	}
	mysqli_query($dbcon,"UPDATE Users SET balance=$balance WHERE login='$login'");
	mysqli_close($dbcon);

?>