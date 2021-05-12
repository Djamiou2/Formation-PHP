<?php
require_once 'includes/session_functions.php';
require_once 'includes/functions.php';

if (!logged_in()) redirect_to('login.php');

if (session_status() === PHP_SESSION_ACTIVE) {
    unset($_SESSION);
    session_destroy();

    redirect_to('login.php');
}
