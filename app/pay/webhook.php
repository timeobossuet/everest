<?php
define('DIRECTACCESS', TRUE);
require 'app/config.php';
require 'app/functions.php';
$error = "";

// recuperation des donnees de stripe
http_response_code(200);
$input = file_get_contents('php://input');
$event = json_decode($input);

$payment_id = "null";
$payment_amount = $event->data->object->amount_paid;
$customer_id = $event->data->object->customer;
$user_email = $event->data->object->customer_email;
$bdate = date('Ymd');
$subscription_id = $event->data->object->subscription;


// on cherche l'id de l'utilisateur qui vient de payer
$babare = $connect->prepare('SELECT id FROM users WHERE email = :user_email');
      $babare->execute(array(
      ':user_email' => $user_email
      ));
$search_user_id = $babare->fetch(PDO::FETCH_ASSOC);
$user_id = $search_user_id['id'];


// on cherche si l'orders existe deja
$verify = $connect->prepare('SELECT id FROM orders WHERE user_email = :user_email');
$verify->execute(array(
	':user_email' => $user_email
));
$verify_if_exist = $verify->fetch(PDO::FETCH_ASSOC);

// si l'utilisateur existe
if($verify_if_exist == true){
	try {
		$update_existing_order = $connect->prepare("UPDATE orders SET bdate = '$bdate' WHERE user_email = '$user_email'");
		$update_existing_order->execute();
		}
		catch(PDOException $e) {
		$error = $e->getMessage();
		}
}

// si l'utilisateur existe pas
if ($verify_if_exist == false) {
	try {
		$creat_new_order = $connect->prepare('INSERT INTO orders (user_id, subscription_id, payment_id, payment_amount, customer_id, user_email, bdate) VALUES (:user_id, :subscription_id, :payment_id, :payment_amount, :customer_id, :user_email, :bdate)');
		$creat_new_order->execute(array(
					':payment_id' => $payment_id,
					':payment_amount' => $payment_amount,
					':customer_id' => $customer_id,
					':user_email' => $user_email,
					':user_id' => $user_id,
					':subscription_id' => $subscription_id,
					':bdate' => $bdate
					));
		}
		catch(PDOException $e) {
		$error = $e->getMessage();
		}
}

// envoie du mail
$obj = "Paiement Validé";
$msg = "Nous avons bien reçus votre paiement, votre compte est bien activé!";
sendmail($user_email, $obj, $msg);

if ($error == "") {
	echo 'STRIPE Webhook Success by Everest';
}else{
	echo $error;
}