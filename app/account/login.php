<?php
	define('DIRECTACCESS', TRUE);
	require '../core/config.php';
	require '../include/mail.php';
	require '../core/functions.php';

	restrict_access('not_login');

	if(isset($_POST['login'])) {
		$errMsg = '';

		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);

		if($email == '')
			$errMsg = "Il manque votre email";
		if($password == '')
			$errMsg = "Il manque votre mot de passe";

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT id, email, firstname, lastname, password FROM users WHERE email = :email');
				$stmt->execute(array(
					':email' => $email
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "Cet utilisateur n'existe pas <a href='./register'>Créer un compte</a>";
				}
				elseif($password == $data['password']) {
					$_SESSION['email'] = $data['email'];
					$_SESSION['password'] = $data['password'];
					$_SESSION['lastname'] = $data['lastname'];
					$_SESSION['firstname'] = $data['firstname'];
					$_SESSION['id'] = $data['id'];
					header("Location: ".$ev_url);
				}
				else{
					$errMsg = 'Mauvais mot de passe <a href="./forgot">Mot de passe oublié ?</a>';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" href="../images/icon.ico"/>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Echo Video - Connexion</title>
    <link rel="stylesheet" href="../css/ev.css" media="screen">
    <link rel="stylesheet" href="../css/login.css" media="screen">
    <script class="u-script" type="text/javascript" src="../js/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="../js/ev.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
  </head>
  <body class="u-body">
    <section class="u-clearfix u-hidden-lg u-hidden-md u-hidden-xl u-section-1" id="sec-ac81">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-xl u-sheet-1">
        <div class="u-align-center u-container-style u-expanded-width-xs u-group u-radius-30 u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <h3 class="u-custom-font u-text u-text-custom-color-1 u-text-default u-text-font u-text-1">Connexion</h3>
            <div class="u-form u-login-control u-form-1">
              <form action="" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-35 u-form-vertical u-inner-form" source="custom" name="form-2" style="padding: 10px;">
                <div class="u-form-group u-form-name">
                  <input type="email" placeholder="Votre email" id="username-708d" name="email" class="u-grey-5 u-input u-input-rectangle" required="">
                </div>
                <div class="u-form-group u-form-password">
                  <input type="password" placeholder="Votre mot de passe" id="password-708d" name="password" class="u-grey-5 u-input u-input-rectangle" required="">
                </div>
                
                <div class="u-form-checkbox u-form-group">
                  <a class="u-label" href="./forgot">Mot de passe oublié</a>
                </div>
                <div class="u-align-center u-form-group u-form-submit">
                  <input type="submit" value="Connexion" name="login" class="u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-1 u-hover-custom-color-2 u-radius-17 u-btn-1">
                </div> 
              </form>
            </div>
            <div class="u-container-style u-group u-group-2">
              <div class="u-container-layout">
                <a href="" class="u-border-1 u-border-active-custom-color-2 u-border-hover-custom-color-1 u-btn u-button-style u-login-control u-login-forgot-password u-none u-text-custom-color-2 u-text-hover-custom-color-1 u-btn-3">S'inscrire</a>
                <p class="u-text u-text-default u-text-grey-50 u-text-2"> Nouveau sur Echo Video?</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-align-center u-clearfix u-hidden-sm u-hidden-xs u-image u-shading u-section-2" id="sec-b731" data-image-width="1600" data-image-height="1200">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-group u-radius-30 u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <h3 class="u-align-center u-custom-font u-text u-text-custom-color-1 u-text-default u-text-font u-text-1">Connexion</h3>
            <div class="u-form u-login-control u-form-1">
              <form action="" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-35 u-form-vertical u-inner-form" source="custom" name="form-2" style="padding: 10px;">
                <div class="u-form-group u-form-name">
                  <input type="email" placeholder="Votre email" id="username-708d" name="email" class="u-grey-5 u-input u-input-rectangle" required="">
                </div>
                <div class="u-form-group u-form-password">
                  <input type="password" placeholder="Votre mot de passe" id="password-708d" name="password" class="u-grey-5 u-input u-input-rectangle" required="">
                </div>
                
                <div class="u-form-checkbox u-form-group">
                  <a class="u-label" href="./forgot">Mot de passe oublié</a>
                </div>
                <div class="u-align-center u-form-group u-form-submit">
                  <input type="submit" value="Connexion" name="login" class="u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-1 u-hover-custom-color-2 u-radius-17 u-btn-1">
                </div>
              </form>
            </div>
          </div>
        </div>
        <p class="u-text u-text-custom-color-2 u-text-default u-text-3">Illustration de Mila Spasova</p>
      </div>
    </section>
<?php 
include "../include/footer.php";
?>