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
    echo "<br><br><strong>Data wygaśnięcia premium</strong>: ".$_SESSION['dnipremium'];

    echo time()."<br>";
    $datetime = new DateTime();
    
    $premiumend = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
    $difference = $datetime->diff($premiumend);

    if ($datetime < $premiumend)
    echo "<br>Pozostało premium ".$difference->format('%d dni, %h godz, %i min');
    else
    echo "<br>Premium nieaktywne od ".$difference->format('%d dni, %h godz, %i min');
?>
</body>
</html>