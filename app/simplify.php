<?php

// url du site
$site_url = "localhost";

// variables de l'utilisateur
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
	$user_id = $_SESSION['id'];
	$user_email = $_SESSION['email'];
	$user_password = $_SESSION['password'];
	$user_premium = $_SESSION['premium'];
	$user_lastname = $_SESSION['lastname'];
	$user_firstname = $_SESSION['firstname'];	
}

?>