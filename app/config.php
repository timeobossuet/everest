<?php
session_start();

// Affichage des erreurs
ini_set('display_errors', 1);
// Url sans / final
$site_url = 'http://localhost';

// Code Analytics (sans G-)
$analytics = "EXEMPLE";

// Stripe
$stripe_public_key = "EXEMPLE-STRIPE-PUBLIC-KEY";
$stripe_secret_key = "EXEMPLE-STRIPE-SECRET-KEY";
$stripe_price_subscription = "EXEMPLE-STRIPE-PRICE";

// Base de donnée
define('dbhost', 'localhost');
define('dbuser', '');
define('dbpass', '');
define('dbname', 'template');

// connection à la base de donnée
try
{
    $connect = new PDO("mysql:host=" . dbhost . "; dbname=" . dbname, dbuser, dbpass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

?>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-<?php echo $analytics; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-<?php echo $analytics; ?>');
</script>
