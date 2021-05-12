<?php
require_once 'includes/db.php';
require_once 'includes/session_functions.php';
require_once 'includes/functions.php';

if (!super()) {
    $_SESSION['info'] = "Accès refusé";
    redirect_to('user_list.php');
}

if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
    redirect_to('user_list.php');
}
$id = (int)$_GET['id'];

//Suppression de la catégorie
$q = $db->prepare("DELETE FROM user WHERE id = :id");
$success = $q->execute(['id' => $id]);

if ($success) {
    $_SESSION['success'] = "Utilisateur #$id supprimé avec succès";
    redirect_to('user_list.php');
} else {
    $_SESSION['warning'] = "Erreur lors de la suppression";
    redirect_to('user_list.php');
}
