<?php
include 'app/config.php';
include 'app/simplify.php';
include 'app/functions.php';

restrict_access('not_login');

if (isset($_POST['register']))
{
    $errMsg = '';
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $password_confirm = $_POST['confirm'];

    if ($email == '') $errMsg = 'Il manque votre email';
    if ($firstname == '') $errMsg = 'Il manque votre prénom';
    if ($lastname == '') $errMsg = 'Il manque votre nom';
    if ($password != $password_confirm) $errMsg = 'Les mots de passes ne sont pas identiques';

    //on verifie si personne n'a cet email
    $verify = $connect->prepare('SELECT id FROM users WHERE email = :email');
    $verify->execute(array(
        ':email' => $email
    ));
    $data = $verify->fetch(PDO::FETCH_ASSOC);
    if ($data == true)
    {
        $errMsg = "Un utilisateur avec cet email existe déjà";
    }

    //récupération de l'ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'] . "\r\n";
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . "\r\n";
    else $ip = $_SERVER['REMOTE_ADDR'] . "\r\n";
    $lastconnexionip = $ip;
    $registerip = $ip;

    //création du compte
    if ($errMsg == '')
    {
        try
        {
            $stmt = $connect->prepare('INSERT INTO users (email, lastname, firstname, password, lastconnexionip, registerip, registerdate) VALUES (:email, :lastname, :firstname, :password, :lastconnexionip, :registerip, :registerdate)');
            $stmt->execute(array(
                ':email' => $email,
                ':lastname' => $lastname,
                ':firstname' => $firstname,
                ':password' => $password,
                ':lastconnexionip' => $lastconnexionip,
                ':registerip' => $registerip,
                ':registerdate' => $registerdate
            ));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

        // envoie du mail
        $obj = "Création de votre compte";
        $msg = "Votre compte à bien été créer";
        sendmail($email, $obj, $msg);
        redirect('/');
    }
}

?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register - Everest</title>
</head>
<body>
	<? if ($errMsg != "")
{ ?>
	<p><? echo $errMsg; ?></p>
	<?
} ?>
	<form method="POST" name="register">
		<input type="" name="">
		<input type="" name="">
	</form>
</body>
</html>
