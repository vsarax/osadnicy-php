<?php
    session_start();

    if(isset($_POST['submit']))
    {
        $url='https://www.google.com/recaptcha/api/siteverify';
        $secret='6Le7k6QkAAAAAPkCXirmOz-j71u8vhzf70zjo-WR';
        $response=$_POST['token_generate'];
        $remoteip=$_SERVER['REMOTE_ADDR'];

        $request=file_get_contents($url.'?secret'.$secret.'response='.$response);
        $result=json_decode($request);

        if($response->success){
                /* Kontynuj działanie skryptu */
            } else {
                die("Nieprawidłowa odpowiedź CAPTCHA");
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
    <script src="https://www.google.com/recaptcha/api.js?render=6Le7k6QkAAAAAIcWGgBOdifqW7rZnEVGy0Aeef1Z"></script>
</head>
<body>
    <form method="post">
    Nick: <br><input type="text" name="nick"><br>
        E-mail: <br><input type="text" name="email"><br>
        Hasło: <br><input type="password" name="password1"><br>
        Powtórz hasło: <br><input type="password" name="password2"><br><br>
        <label>
            <input type="checkbox" name="rules"> Akceptuję regulamin<br><br>
        </label>
        <input type="hidden" name="token_generate" id="token_generate">
        <input type="submit" value="Załóż konto"/>
    </form>
</body>
</html>
<script>
        grecaptcha.ready(function() {
          grecaptcha.execute('6Le7k6QkAAAAAIcWGgBOdifqW7rZnEVGy0Aeef1Z', {action: 'submit'}).then(function(token) {
              var response=document.getElementById("token_generate)");
              response.value=token;
          });
        });
  </script>