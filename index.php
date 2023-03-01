<?php
    session_start();

    if((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true))
    {
        header('Location: gra.php');
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
    <p>Tylko martwi ujrzeli koniec wojny - Planton<br></p>
    <a href="rejestracja.php">Załóż konto</a><br>
    <form action="zaloguj.php" method="post">
        Login:<br><input type= "text" name = "login"><br>
        Hasło:<br><input type="password" name="password"><br><br>
        <input type="submit" value="Zaloguj się"/>
    </form>

    <?php
    if(isset($_SESSION['error']))
        {
            echo $_SESSION['error'];
        }
    unset($_SESSION['error']);
?>
</body>
</html>