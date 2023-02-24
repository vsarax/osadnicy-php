<?php 
    session_start();

    if (!isset($_SESSION['newaccount']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['newaccount']);
    }

        //Usuwanie zmiennych pamiętających wartości wpisane do formularza
        if (isset($_SESSION['form_login'])) unset($_SESSION['form_login']);
        if (isset($_SESSION['form_email'])) unset($_SESSION['form_email']);
        if (isset($_SESSION['form_rules'])) unset($_SESSION['form_rules']);
         
        //Usuwanie błędów rejestracji
        if (isset($_SESSION['e_logpassword'])) unset($_SESSION['e_logpassword']);
        if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
        if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
        if (isset($_SESSION['e_rules'])) unset($_SESSION['e_rules']);
        if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
         
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
    <p>Dziękujemy za rejestrację w serwisie, zaloguj się na swoje konto<br></p>
    <a href="index.php">Zaloguj się na swoje konto</a><br>

    <?php
    if(isset($_SESSION['error']))
        {
            echo $_SESSION['error'];
        }
    unset($_SESSION['error']);
?>
</body>
</html>