<?php
include 'app/config.php';
include 'app/simplify.php';
include 'app/functions.php';

restrict_access("login");

// recherche du subscribtion_id
$sdb = $connect->prepare('SELECT * FROM orders WHERE user_email = :user_email');
$sdb->execute(array(
    ':user_email' => $user_email
));
$susearch = $sdb->fetch(PDO::FETCH_ASSOC);
$subscribtion_id = $susearch['subscribtion_id'];

// sur stripe
require '../vendor/autoload.php';
\Stripe\Stripe::setApiKey($stripe_secret_key);
$subscription = \Stripe\Subscription::retrieve("$subscribtion_id");
$subscription->cancel();

// sur le site
$dbdeletequery = $connect->prepare("DELETE FROM orders WHERE user_email = '$user_email'");
$dbdeletequery->execute();

$object = "Suppression de votre compte";
$message = "Votre abonnement n'est plus actif, vous ne serait plus débiter tous les mois."sendmail($user_email, $object, $message);

session_destroy();
redirect($site_url);
?>
