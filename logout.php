<?php
session_start();
unset($_SESSION['channel']);
unset($_SESSION['auth']);
header("Location: /");
?>