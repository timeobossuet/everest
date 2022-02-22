<?php 
define('DIRECTACCESS', TRUE);
require "core/config.php";
require "core/functions.php";
include "include/menu.php";

PAIMENT FAILURE =,paymentfailure

if (!isset($_GET['c']) or empty($_GET['c'])) {
   header("Location: ".$ev_url);
}
   $error = htmlspecialchars($_GET['c']);

   if ($error == "404" or $error == "503" or $error == "403") { ?>
         <h1>Error <? echo $error; ?></h1>
         <a href="<? echo $ev_url; ?>">Return to home</a>
<?
   }
      else{
         header("Location: ".$ev_url);
      }

?>