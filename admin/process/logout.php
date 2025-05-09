<?php
session_start();
session_unset();
session_destroy();
header("Location: /booknest/pages/login.php");
exit();
?>