<?php 
define('DIRECTACCESS', TRUE);
require "core/config.php";
require "core/functions.php";

   if (premium($user_id) == true) {

      include "include/catalogconnected.php";

   }

   elseif (isset($user_id) and !empty($user_id)) {

      include "include/connected.php";

   }

   else{

      include "include/home.php";
      
   }
   
   include "include/footer.php";

?>