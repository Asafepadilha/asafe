<div class="container">
<link rel="stylesheet" href="assets/css/style.css"><?php
session_start();
session_destroy();
header("Location: login.php");
exit;
