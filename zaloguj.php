<?php
    session_start();

    if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $connection=@new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    else
    {
        $login=$_POST['login'];
        $password=$_POST['password'];
        
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

        if ($result=@$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",
        mysqli_real_escape_string($connection,$login),
        mysqli_real_escape_string($connection,$password))))
        {
            $users_num=$result->num_rows;
            if($users_num>0)
            {
                $_SESSION['loggedin']=true;

                $row=$result->fetch_assoc();
                $_SESSION['id']=$row['id'];
                $_SESSION['user']=$row['user'];
                $_SESSION['drewno']=$row['drewno'];
                $_SESSION['kamien']=$row['kamien'];
                $_SESSION['zboze']=$row['zboze'];
                $_SESSION['email']=$row['email'];
                $_SESSION['dnipremium']=$row['dnipremium'];

                unset($_SESSION['error']);
                $result->free_result();
                header('Location: gra.php');

            } 
            else {
                $SESSION['error']='<span style="color:red">
                Nieprawidłowy login lub haslo</span>';
                header('Location: index.php');
            }
        }

        $connection->close();
    }
?>