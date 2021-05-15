<?php
$title = 'Ajouter un administrateur';
require_once 'includes/db.php';
require_once 'includes/session_functions.php';
require_once 'includes/functions.php';
require_once 'partials/_header.php';

if (!super()) redirect_to('login.php');


$errors = [];
$roles = ['modo', 'admin', 'super'];

if (isset($_POST['add_user'])) {
    $submit = array_pop($_POST);


    if (!not_empty($_POST)) {
        $errors['global'] = "Tous les champs sont obligatoire";
        $_SESSION['warning'] = $errors['global'];
    }
    $name = sanitize($_POST['name']);
    $firstname = sanitize($_POST['firstname']);
    $email = sanitize($_POST['email']);
    $role = sanitize($_POST['role']);

    if (!length_validation($name, 3, 245)) {
        $errors['name'] = 'Doit être compris entre 3 et 245 caractères.';

    }
    if (!length_validation($firstname, 3, 245)) {
        $errors['firstname'] = 'Doit être compris entre 3 et 245 caractères.';

    }
    if (!length_validation($email, 3, 245)) {
        $errors['email'] = 'Doit être compris entre 3 et 245 caractères.';

    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email est invalide";
    }

    $usedEmails = [];
    $dbEmail = $db->query('SELECT email from user')->fetchAll(PDO::FETCH_OBJ);
    foreach ($dbEmail as $item) {
        $usedEmails[] = $item->email;
    }
    if (in_array($email, $usedEmails)) {
        $errors['email'] = "Cet email est déjà utilisé.";
    }
    if (!in_array($role, $roles)) {
        $errors['role'] = 'Role invalide.';
    }


    if (empty($errors)) {
        $password = password_hash('1234567890', PASSWORD_ARGON2I);
       //1) Enregistrer l'utilisateur en base de données
        $q = $db->prepare("INSERT INTO user (name, firstname, email, password, role) VALUES (:name, :firstname, :email, :password, :role)");
        $status = $q->execute([
           'name' => $name,
           'firstname' => $firstname,
           'email' => $email,
           'password' => $password,
           'role' => $role
        ]);

        if ($status) {
            //2) Envoyer un mail de confirmation
//            $subject = WEBSITE_NAME. " - Activation de votre compte";
//            $token = sha1($name.$email.'1234567890');
//            ob_start();
//            require 'template/activation.tmpl.php';
//            $content = ob_get_clean();
//            $headers = 'MIME-Version: 1.0' . "\r\n";
//            $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
//            $successMail = mail($email, $subject, $content, $headers);
//            if (!$successMail) {
//                $_SESSION['warning'] = "Le mail a été rejeté pour la livraison.";
//            }

            $_SESSION['success'] = "Utilisateur ajouté avec succès.";
            redirect_to('user_list.php');
        } else {
            $_SESSION['warning'] = "Echec lors de l'enregistrement.";
        }
    } else {
        $_SESSION['warning'] = "remplissez convenablement le formulaire.";
    }
}


?>

<?php require_once 'views/_register.php' ?>

<?php require_once 'partials/_footer.php'?>
