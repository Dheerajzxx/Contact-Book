<?php
session_start();
unset($_SESSION['idkey']);
session_destroy();
header("Location: index.php");
?>