<?php
//Стартуем сессии
session_start();
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blackjack</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body onload="set()">
<div id="menu">
    <div id="logo">
        <a href="index.html"><img src="img/2.png" alt="logo"></a>
    </div>
    <ul>
        <li><a href="javascript:void(0)" onclick = "getHistory()">История</a></li>
        <?php
        if (empty($_SESSION['login']) or empty($_SESSION['id']))
        {
        ?>
        <li><a class="show-btn" id="login" href = "javascript:void(0)" onclick = "document.getElementById('auth-form').style.display='block';
        document.getElementById('fade').style.display='block'">Вход</a></li>
        <?php
    }
    else
        {
        $login = $_SESSION['login'];
        echo " <li id='name'>$login</li>";
        echo " <li id='exit'><a href='exit.php'>Выйти</a></li>";
        //Подключаемся к базе данных.
        $dbcon = mysqli_connect("localhost", "admin", "mix042");
        mysqli_select_db($dbcon, "BlackJack");
        if (!$dbcon) {
            echo "<p>Произошла ошибка при подсоединении к MySQL!</p>" . mysql_error();
            exit();
        } else {
            if (!mysqli_select_db($dbcon, "BlackJack")) {
                echo("<p>Выбранной базы данных не существует!</p>");
            }
        }
        $sqlCart = mysqli_query($dbcon,"SELECT balance FROM Users WHERE login = '$login'");
 while($row = mysqli_fetch_array($sqlCart))
 {
$balance = $row["balance"];
  }
    }
	?>
    </ul>
</div>
<script>
    var slogin="<?php echo $_SESSION['login']; ?>";
</script>
<div id="history" >
<div class="close-btn" title="Закрыть" href="#" onclick = "hideHistory()"></div>    
    <p>Авторизируйтесь, чтобы просмотреть вашу историю</p>
</div>
<div id="auth-form">
    <div class="close-btn" title="Закрыть" href="#" onclick = "document.getElementById('auth-form').style.display='none';document.getElementById('fade').style.display='none'"></div>
    <div class="title">Добро пожаловать!</div>
    <ul class="cd-switcher" onclick="switch_tab()">
                <li><a href="#0" class="log-tab selected">Вход</a></li>
                <li><a href="#0" class="reg-tab">Регистрация</a></li>
    </ul>
    <form  action="" method="post" id="login-form" class="is-selected">
        <input type="text" name="login" placeholder="Ваше имя" class="your-name" onfocus="hideError()" />
        <input type="password" name="password" placeholder="Ваш пароль" class="your-password" onfocus="hideError()"/>
        <span class="cd-error-message" id="err1"> </span>
        <input type="submit" value="Войти" id="login-button" onclick="auth()">
    </form>
    <form  action="" method="post" id="reg-form">
        <input type="text" name="login" placeholder="Ваше имя" class="your-name" onfocus="hideError()"/>
        <input type="password" name="password" placeholder="Ваш пароль" class="your-password" onfocus="hideError()"/>
        <input type="password" name="password" placeholder="Повторите пароль" class="your-password" onfocus="hideError()"/>
        <span class="cd-error-message" id="err2"> </span>
        <input type="submit" value="Зарегистрироваться" id="reg-button" onclick="reg()">
    </form>
</div>
<div id="fade" class="black-overlay"></div>
<div id="content">
    <div id="account-wrapper">
        <div id="account">
            <div id="acclogo"><img src="img/dollar.png" alt="dollar"></div>
            <?php
            echo "<div id='sum'>Ваш баланс<br><span id='balance'>$balance</span></div>";
            ?>
        </div>
        <div id="bet-wrapper">

            <div id="bet-logo"><img src="img/bet.png" alt="bet"></div>
            <div id="bet">
                <p>Ваша ставка</p>
                <input type="text" name="" id="bet-input" value="" placeholder="" onkeydown="if ((event.keyCode>47 && event.keyCode<58) || (event.keyCode>95 && event.keyCode<106) || event.keyCode==8) {} else {return false;}">
            </div>
        </div>
    </div>
    <div id="gameboard">
        <div id="board1">
            <div class="card" id="card1D"></div>
            <div class="card" id="card2D"></div>
            <div class="card" id="card3D"></div>
            <div class="card" id="card4D"></div>
            <div class="card" id="card5D"></div>
        </div>
        <div id="dealer-score" class="score"></div>
        <div id="result"> </div>
        <div id="board2">
            <div class="card" id="card1P"></div>
            <div class="card" id="card2P"></div>
            <div class="card" id="card3P"></div>
            <div class="card" id="card4P"></div>
            <div class="card" id="card5P"></div>
        </div>
        <div id="player-score" class="score"></div>
    </div>
    <div id="promt"></div>
    <div id="control">
        <input type="submit" id="start" value="Раздать" onclick="start()">
        <input type="submit" id="hit" value="Взять карту" onclick="hit()">
        <input type="submit" id="stay" value="Хватит"  onclick="stay()">
    </div>
</div>
</body>
</html>