<?php
session_start();
session_destroy();
unset($_SESSION['SES_LEVEL_LER']);
unset($_SESSION['SES_USER_LER']);
header("Location: index.php ");	
?>