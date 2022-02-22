<?php
define('DIRECTACCESS', TRUE);
require '../core/config.php';

if (isset($_SESSION['email'])) {
		header('Location: https://video.echo-da.fr');
		exit();
	}

if (empty($_SESSION['user_id_reset_pass'])) {
	header('Location: ./forgot');
	exit();
}

$userid = $_SESSION['user_id_reset_pass'];

// on récupère l'email
try {
	$recuperation = $connect->prepare('SELECT id, email, firstname, lastname, password FROM users WHERE id = :userid');
	$recuperation->execute(array(
					':userid' => $userid
					));
	$data = $recuperation->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
	$errMsg = $e->getMessage();
}

if(isset($_POST['submit'])) {
		$errMsg = '';

		$newpassword = $_POST['newpassword'];
		$verifynewpassword = $_POST['verifynewpassword'];

	if ($newpassword == '') {
		$errMsg = 'Merci de mettre votre nouveau mot de passe';
	}
	if ($verifynewpassword != $newpassword) {
		$errMsg = 'Les mots de passes ne sont pas les mêmes !';
	}

	if ($errMsg == '') {
		if($errMsg == ''){

			//on update le mdp
			try {
				$stmt = $connect->prepare('UPDATE users SET password = "'.$newpassword.'" WHERE id = '.$userid);
				$stmt->execute();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			sleep(1);
				//connexion automatique
				try {
				$connexion = $connect->prepare('SELECT id, email, firstname, lastname, password FROM users WHERE id = :id');
				$connexion->execute(array(
					':id' => $userid
					));
				$data = $connexion->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "Erreur, merci de <a href ='./support>contactez notre centre d'aide";
				}
				else {
						$_SESSION['email'] = $data['email'];
						$_SESSION['firstname'] = $data['firstname'];
						$_SESSION['lastname'] = $data['lastname'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['id'] = $data['id'];

						header('Location: https://video.echo-da.fr');
						exit();
					}
				}
				catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
}
?>

<html>
<head>
	<title>Echo Video - Nouveau mot de passe</title>
</head>
<body>
	<?php
		if(isset($errMsg)){
			echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
		}?>
	<h1>Nouveau mot de passe</h1>
	<h2><?php echo $data['email']; ?></h2>
	<form action="" method="post">
		<input type="password" name="newpassword">
		<input type="password" name="verifynewpassword">
		<input type="submit" name='submit' value="Confirmer" class='submit'/>
	</form>
</body>
</html>