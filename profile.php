<?php
require_once 'includes/db.php';
require_once 'includes/session_functions.php';
require_once 'includes/functions.php';

$title = "{$_SESSION['name']} {$_SESSION['firstname']}";

require_once 'partials/_header.php';


if (!logged_in()) redirect_to('login.php');

?>


<?php require_once 'views/_profile.php'; ?>


<?php require_once 'partials/_footer.php';
