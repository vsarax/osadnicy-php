<?php
    session_start();

    if(isset($_POST['email'])) {
        $success = true;
        $login = $_POST['login'];

        if((strlen($login)<3) || (strlen($login)>20)) {
            $success = false;
            $_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków";
        }

        if(ctype_alnum($login) == false) {
            $success = false;
            $_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
        }

        $email = $_POST['email'];
        $safeemail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($safeemail, FILTER_VALIDATE_EMAIL) == false) || ($email != $safeemail)) {
            $success = false;
            $_SESSION['e_email']="Podaj poprawny adres email";
        } 
    
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8) || (strlen($password1)>20)) {
            $success = false;
            $_SESSION['e_password'] = "Haslo musi posiadać od 8 do 20 znaków";
        }

        if ($password1 != $password2) {
            $success = false;
            $_SESSION['e_password'] = "Hasła muszą być takie same";
        }

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        if(!isset($_POST['rules']))
        {
            $success = false;
            $_SESSION['e_rules']="Potwierdź akceptację regulaminu";
        }

        $secret = "6LdxDKkkAAAAANrChceVWUqTM6pnYrKy1efucGk5";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $answer = json_decode($check);

        if($answer->success == false)
        {
            $success = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem";
        }

        $_SESSION['form_login'] = $login;
        $_SESSION['form_email'] = $email;
        if(isset($_POST['rules']))
        {
            $_SESSION['form_rules'] = true;
        }
        require_once "connect.php";

        try
        {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno != 0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else 
            {
                $result = $connection->query("SELECT id FROM uzytkownicy WHERE email = '$email'");
                if(!$result) throw new Exception($connection->error);
                $mails_num = $result->num_rows;
                if($mails_num>0)
                {
                    $success = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }

                $result = $connection->query("SELECT id FROM uzytkownicy WHERE user = '$login'");
                if(!$result) throw new Exception($connection->error);
                $logins_num = $result->num_rows;
                if($logins_num>0)
                {
                    $success = false;
                    $_SESSION['e_login']="Podany login już istnieje";
                }

                if($success == true)
                {
                    if ($connection->query("INSERT INTO uzytkownicy 
                    VALUES (NULL, '$login', '$password_hash', '$email', 100, 100, 100, now()+INTERVAL 14 DAY)"))
                    {
                        $_SESSION['newaccount'] = true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }

                $connection->close();
            }
        }
        catch(Exception $e)
        {
            echo '<p class="error">Błąd serwera, przepraszamy!</p>';
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - załóż darmowe konto</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
    <form method="post">
        Login: <br><input type = "text" value = "<?php
        if(isset($_SESSION['form_login']))
        {
            echo $_SESSION['form_login'];
            unset($_SESSION['form_login']);
        }
        ?>" name = "login"><br>
        <?php
            if(isset($_SESSION['e_login'])) {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }
        ?>
        E-mail: <br><input type = "text" value = "<?php
        if(isset($_SESSION['form_email']))
        {
            echo $_SESSION['form_email'];
            unset($_SESSION['form_email']);
        }
        ?>"name = "email"><br>
        <?php
            if(isset($_SESSION['e_email'])) {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>
        Hasło: <br><input type = "password" name = "password1"><br>
        <?php
            if(isset($_SESSION['e_password'])) {
                echo '<div class="error">'.$_SESSION['e_password'].'</div>';
                unset($_SESSION['e_password']);
            }
        ?>
        Powtórz hasło: <br><input type = "password" name = "password2"><br><br>
        <label>
           <input type = "checkbox" name = "rules" <?php
           if(isset($_SESSION['form_rules']))
           {
            echo "checked";
            unset($_SESSION['form_rules']);
           }
           ?>> Akceptuję regulamin<br>
        </label>
        <?php
            if(isset($_SESSION['e_rules'])) {
                echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
                unset($_SESSION['e_rules']);
            }
        ?>
        <div class = "g-recaptcha" data-sitekey = "6LdxDKkkAAAAAIlnWb5lzFopt1O9G18DvhMXM68L"></div>
        <?php
            if(isset($_SESSION['e_bot'])) {
                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                unset($_SESSION['e_bot']);
            }
        ?>
        <input type = "submit" value = "Załóż konto">
    </form> 

</body>
</html>