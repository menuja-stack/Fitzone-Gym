<?php
session_start();
session_destroy();
header("Location: ac1.php");
exit();
?>