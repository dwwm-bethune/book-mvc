<?php

require 'data.php';

unset($_SESSION['user']);
setcookie('remember'); // Efface le cookie
$_SESSION['message'] = 'Vous avez été déconnecté';
header('Location: ./livres.php');
