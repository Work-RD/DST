<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deac Servicii Tehnice</title>
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../css/mobile.css" media="screen and (max-width : 568px)">
    <style>
    body {
        text-align: center;
        font-family: Arial Black;
        font-size: 15px;
    }
    </style>
</head>

<body>
    <div id="header">
    	<a href="../../index.php" class="logo">
            <img src="../../images/logo.png" alt="">
    	</a>
        <img src="../../images/border.png" alt="">
    </div>
    <br>
    <br>
<?php

require_once "Mail.php";

if(isset($_POST['email'])) {

    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $email_from = $_POST['email'];
    $telefon = $_POST['telefon'];
    $mesaj = $_POST['mesaj'];
    
    $email_subject = "Mesaj " . $nume;
 
    function died($error) {
        echo "Ne pare foarte rău, dar am găsit următoarele greșeli în formularul trimis:<br /><br />";
        echo $error."<br /><br />";
        echo "Vă rugăm întoarceți-vă și remediați greșelile.<br /><br />";
        die();
    }
 
 
    if (!isset($_POST['nume']) ||
        !isset($_POST['prenume']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telefon']) ||
        !isset($_POST['mesaj'])) {
        died('Ne pare foarte rău, dar am găsit următoarele greșeli în formularul trimis:');       
    }
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
    if(!preg_match($email_exp,$email_from)) {
      $error_message .= '- adresa de email nu este valabilă (trebuie sa fie o adresă de email valabilă)<br />';
    }
  
      $string_exp = "/^[A-Za-z .'-]+$/";
  
    if(!preg_match($string_exp,$nume)) {
      $error_message .= '- numele introdus nu este valid (trebuie să conțină doar litere sau spații)<br />';
    }
  
    if(!preg_match($string_exp,$prenume)) {
      $error_message .= '- prenumele introdus nu este valid (trebuie să conțină doar litere sau spații)<br />';
    }
  
    if(strlen($mesaj) < 2) {
      $error_message .= '- mesajul introdus nu este valid (trebuie să conțină minim 2 caractere)<br />';
    }
  
    if(strlen($error_message) > 0) {
      died($error_message);
    }
 
    $email_message = "Mesajul lui " . $nume .":\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Nume: ".clean_string($nume)."\n";
    $email_message .= "Prenume: ".clean_string($prenume)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telefon: ".clean_string($telefon)."\n";
    $email_message .= clean_string($mesaj)."\n";

    $host = "aega.hosterion.net";
    $username = "test@test.ro";
    $password = "Asd@Qaz!";

    $to = "DST <test@test.ro>, DST <test@test.ro>";

    $headers = array ('From' => $email_from,
                  'To' => $to,
                  'Subject' => $email_subject);
    $smtp = Mail::factory('smtp',
                  array ('host' => $host,
                 'auth' => true,  
                 'username' => $username,
                 'password' => $password));

    $mail = $smtp->send($to, $headers, $email_message);
    
    echo "Mulțumim pentru mesaj. Veți primi un răspuns cât mai rapid posibil.";
    header( "refresh:4;url=../../index.php");
    }
    ?>
</body>
</html>