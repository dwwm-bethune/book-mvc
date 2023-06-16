<?php
    require 'data.php';

    // Si on est pas connecté, on redirige vers le login
    if (!user()) {
        header('Location: ./login.php');
    }

    // Récupérer l'id du livre que l'on veut supprimer
    $id = $_GET['id'] ?? null;

    // On va supprimer le livre
    $query = database()->prepare('DELETE FROM books WHERE id = :id');
    $query->execute(['id' => $id]);

    // Ajout du message flash
    $_SESSION['message'] = 'Votre livre a bien été supprimé.';

    // Rediriger l'utilisateur vers la liste
    header('Location: ./livres.php');
