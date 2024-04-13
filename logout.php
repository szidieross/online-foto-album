<?php
session_start();
echo "hello logout";
unset($_SESSION["username"]);
session_destroy();
header("Location: index.php");
exit;