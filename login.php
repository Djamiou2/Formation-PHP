<?php
require_once 'includes/session_functions.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$title = 'Se connecter';

require_once 'partials/_header.php';

if (logged_in()) redirect_to('profile.php?id=' . $_SESSION['id']);


$errors = [];
if (isset($_POST['login'])) {
    $submit = array_pop($_POST);
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    if (!not_empty($_POST)) {
        $errors['global'] = "Remplissez convenablement le formulaire";
        $_SESSION['warning'] = $errors['global'];
    }

    if (!not_empty($username)) {
        $errors['username'] = 'Champ Obligatoire';
    }

    if (!not_empty($password)) {
        $errors['password'] = 'Champ Obligatoire';
    }

    if (empty($errors)) {
        $q = $db->prepare("SELECT * FROM user WHERE email = :username AND active = '1'");
        $q->execute(['username' => $username]);

        $user = $q->fetch(PDO::FETCH_OBJ);
        if (!$user || $password !== $user->password) {
            $_SESSION['warning'] = "Identifiant ou mot de passe invalide.";
        } else {
            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->name;
            $_SESSION['firstname'] = $user->firstname;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $user->role;
            $_SESSION['success'] = "Bienvenue {$_SESSION['name']} {$_SESSION['firstname']}.";
            redirect_to('profile.php?id=' . $user->id);
        }
    }
}



?>

<?php require_once 'views/_login.php' ?>

<?php require_once 'partials/_footer.php'?>