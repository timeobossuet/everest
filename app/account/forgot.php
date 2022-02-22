<?php
define('DIRECTACCESS', TRUE);
require '../core/config.php';
require '../include/mail.php';
require '../core/functions.php'

restrict_access("not_login");

if(isset($_POST['forgot'])) {
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $sql = "SELECT `id`, `email` FROM `users` WHERE `email` = :email";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

    if(empty($userInfo)){

        echo 'Cet email ne correspond à aucun compte, <a href="./login">Créer un compte</a>';
        exit();

    }

    $userEmail = $userInfo['email'];
    $userId = $userInfo['id'];

    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    $insertSql = "INSERT INTO password_reset_request (user_id, date_requested, token) VALUES (:user_id, :date_requested, :token)";

    $statement = $connect->prepare($insertSql);
    $statement->execute(array(
        "user_id" => $userId,
        "date_requested" => date("Y-m-d H:i:s"),
        "token" => $token
    ));

    $passwordRequestId = $connect->lastInsertId();
    $verifyScript = 'https://video.echo-da.fr/account/forgot-verify';

    $linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;
    $object = "Mot de passe oublié";
    $message = '<div style="width: 100%; text-align: center; font-weight: bold">'.$linkToSend.'</div>';

    if (sendmail($userEmail, $object, $message);)) {
        
        echo 'Succes! Maintenant, ouvrez votre boite mail pour confirmer';

    }else{

    echo "Echec";

    }

}
?>
<html>
<head>
	<title>Mot de passe oublié</title>
</head>
<body>
	<h1>Mot de passe oublié</h1>
	<form action="" method="post">
		<input type="text" name="email" placeholder="Votre email">
		<input type="submit" name='forgot' value="Confirmer" class='submit'/><br />
	</form>
</body>
</html>