<?php
header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if ($login == '') {
        unset($login);
    }
}
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
//извлекаем из базы все данные о пользователе с введенным логином
$res = mysqli_query($dbcon, "SELECT * FROM Results WHERE login='$login'");

if (mysqli_num_rows($res)==0) {
    echo '<div class="close-btn" title="Закрыть" href="#" onclick = "hideHistory()"></div>';
    echo "<p class='empty-history'> Вы еще не играли!</p>";
} else {
    echo '<div class="close-btn" title="Закрыть" href="#" onclick = "hideHistory()"></div>';
    echo "<h2>Ваша история</h2>";
    echo "<table width='100%' id=results-table>";
    echo "<tr><td>Дата</td><td>Ставка</td><td>Результат</td></tr>";
    while ($row=mysqli_fetch_array($res)){
        $date=$row[2];
        $bet=$row[3];
        $result=$row[4];
        echo "<tr><td>$date</td><td>$bet</td><td>$result</td></tr>";
    }
    echo "</table>";
}
mysqli_close($dbcon);

?>