<?php 
global $url

// vérifier si un utilisateur est premium ou non
function premium($userId){
      global $connect;
      
      if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {

            $stmt = $connect->prepare('SELECT * FROM orders WHERE user_id = :id');
            $stmt->execute(array(
            ':id' => $userId
            ));

      // on verifie si il y a eu un payment
            $there_is_payment = $stmt->fetch(PDO::FETCH_ASSOC);
            if($there_is_payment == false){
            return false;
            }elseif($there_is_payment == true){ 

            // verification que l'utilisateur a paye le mois dernier
                  $last_user_payment = $there_is_payment['bdate'];
                  $today_date = date('Ymd');
                  $next_user_payment = date('Ymd',strtotime('+1 month',strtotime($last_user_payment)));

                  if (intval($today_date) >= intval($next_user_payment)) {
                        return false;
                  }else{
                        return true;
                  }
            }
      }
}

// restrictions d'accès à certaines pages
function restrict_access($status) {
      global $user_email;

      if ($status == "login") {
            if (!isset($user_email) && empty($user_email)) {
            header('Location: '.$url.'/account/login');
            exit();
            }
      }

      if ($status == "not_login") {
            if (isset($user_email) && !empty($user_email)) {
            header('Location: '.$url);
            exit();
            }
      }
}

// envoyer des mails
function sendmail($destinataire, $object, $message){
      ini_set("SMTP","" ); 
      $expediteur = 'example@mail.fr';
      $objet = $object;
      $headers  = 'MIME-Version: 1.0' . "\n";
      $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n";
      $headers .= 'Reply-To: '.$expediteur."\n";
      $headers .= 'From: "Exemple name"<'.$expediteur.'>'."\n";
      $headers .= 'Delivered-to: '.$destinataire."\n";    
      mail($destinataire, $objet, $message, $headers);
}

// rediriger
function redirect($url){
      header('Location: '.$url);
      exit("Redirecting...");
}

?>