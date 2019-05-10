<?php

session_start();
session_destroy(); // a éviter pour pouvoir par exemple garder les paniers
header('location: ..\index.php');
exit;

?>