<?php
include 'app/config.php';
   include 'app/simplify.php';
   include 'app/functions.php';

restrict_access('login');

// verifi quand l'user a payer
$stmt = $connect->prepare('SELECT * FROM orders WHERE user_id = :id');
            $stmt->execute(array(
            ':id' => $user_id
            ));
$myorder = $stmt->fetch(PDO::FETCH_ASSOC);
$last_payment = $myorder['bdate'];

// si le formulaire est envoyer
if(isset($_POST['update'])) {
        $errMsg = '';

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if($password != $confirm)
            $errMsg = 'Les mots de passe ne sont pas identiques';

        if($firstname == '')
            $errMsg = 'Merci de mettre un prénom';

        if($lastname == '')
            $errMsg = 'Merci de mettre un nom';

        if($errMsg == '') {
            try {
              $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, password = :password WHERE email = :email";
              $stmt = $connect->prepare($sql);                                  
              $stmt->execute(array(
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $user_email,
                ':password' => $password
              ));
                header('Location: refresh.php');
                exit();
            }
            catch(PDOException $e) {
                $errMsg = $e->getMessage();
            }
        }
    }

?>