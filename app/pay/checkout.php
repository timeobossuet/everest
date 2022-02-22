<?php
include 'app/config.php';
include 'app/simplify.php';
include 'app/functions.php';

restrict_access("login");
if (premium($user_id) == true)
{
    redirect($site_url);
}

require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create(['success_url' => $site_url . '/app/account/auto-login?u=' . base64_encode($user_email) . '&p=' . base64_encode($user_password) . '', 'cancel_url' => $site_url . '/error?n=paymentfailure', 'customer_email' => $user_email, 'payment_method_types' => ['card'], 'locale' => 'fr', 'mode' => 'subscription', 'line_items' => [['price' => $stripe_price_subscription,
// For metered billing, do not pass quantity
'quantity' => 1, ]], ]);

?>
<head>
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
  <script type="text/javascript">
     var stripe = Stripe('<? echo $stripe_public_key; ?>');
     var session = "<?php echo $checkout_session['id']; ?>";
          stripe.redirectToCheckout({ sessionId: session })
                  .then(function(result) {
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error('Erreur:', error);
        });          
  </script>
</body>
