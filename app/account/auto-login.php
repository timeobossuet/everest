<?php
include 'app/config.php';
include 'app/functions.php';

$email = htmlspecialchars($_GET['u']);
$password = htmlspecialchars($_GET['p']);

//connexion automatique
try
{
    $recuperation = $connect->prepare('SELECT id, email, lastname, firstname, password FROM users WHERE email = :email');
    $recuperation->execute(array(
        ':email' => $email
    ));
    $data = $recuperation->fetch(PDO::FETCH_ASSOC);

    if ($data == false)
    {
        redirect($site_url . '/login');
    }
    else
    {
        if ($password == $data['password'])
        {
            $_SESSION['email'] = $data['email'];
            $_SESSION['lastname'] = $data['lastname'];
            $_SESSION['firstname'] = $data['firstname'];
            $_SESSION['password'] = $data['password'];
            $_SESSION['id'] = $data['id'];
            redirect($site_url);
        }
        else
        {
            redirect($site_url . '/login');
        }
    }
}
catch(PDOException $e)
{
    $errMsg = $e->getMessage();
}

?>
