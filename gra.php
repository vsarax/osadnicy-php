<?php
    session_start();

    if(!isset($_SESSION['loggedin']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
<?php
    echo "<p>Witaj ".$_SESSION['user'].'![<a href="logout.php">Wyloguj się</a>]</p>';
    echo "<p><strong>Drewno</strong>:".$_SESSION['drewno'];
    echo "| <strong>Kamień</strong>: ".$_SESSION['kamien'];
    echo "| <strong>Zboze</strong>: ".$_SESSION['zboze']."</p>";
    echo "<p><strong>E-mail</strong>: ".$_SESSION['email'];
    echo "br><strong>Dni premium</strong>: ".$_SESSION['dnipremium'];
?>
</body>
</html>