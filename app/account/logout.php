<?php
include 'app/config.php';
include 'app/functions.php';
session_destroy();
redirect($site_url);
?>
