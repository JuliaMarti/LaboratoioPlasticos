<?php

session_start();
if (!isset($_SESSION['usuario_logueado'])) {
    header('Location: login.php');
    die;
}


include_once('includes/header.html');

include_once('includes/correct_log_nav.html');

include_once('includes/footer.html');