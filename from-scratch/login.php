<?php
require 'data.php';

// Récupérer l'email et le mot de passe (sanitize)
$email = sanitize($_POST['email'] ?? null);
$password = sanitize($_POST['password'] ?? null);
$remember = (bool) ($_POST['remember'] ?? false);
$error = false;

// Vérifier que le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Faire une requête pour aller chercher l'utilisateur en BDD
    $query = database()->prepare('SELECT * FROM users WHERE email = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Si l'utilisateur existe et que son hash correspond au mot de passe saisi
        // => tout va bien et on connecte l'utilisateur (Session)
        $_SESSION['user'] = $user['email'];

        // S'il a coché la case...
        if ($remember) {
            // On génére un token
            $token = bin2hex(random_bytes(64));
            $email = $user['email'];
            database()->query("UPDATE users SET token = '$token' WHERE email = '$email'");

            setcookie('remember', $token, time() + 60 * 60 * 24 * 365);
        }

        header('Location: ./livres.php');
    } else {
        // Sinon on a une erreur
        $error = true;
    }
}

require 'header.php'; ?>

    <div class="max-w-5xl mx-auto px-3">
        <h1 class="text-center text-2xl">Connexion</h1>

        <?php if ($error) { ?>
            <p class="text-red-500 text-center my-4">Identifiants invalides.</p>
        <?php } ?>

        <form action="" method="post" class="w-1/2 mx-auto">
            <div class="mb-4">
                <label for="email" class="block">Email</label>
                <input type="text" name="email" id="email" class="border-0 border-b focus:ring-0 w-full" value="<?= $email; ?>">
            </div>
            <div class="mb-4">
                <label for="password" class="block">Mot de passe</label>
                <input type="password" name="password" id="password" class="border-0 border-b focus:ring-0 w-full">
            </div>
            <div class="mt-10 mb-4 flex items-center gap-3">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se rappeller de moi</label>
            </div>

            <div class="text-center">
                <a class="mr-3" href="register.php">Pas de compte ?</a>
                <button class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200">Connexion</button>
            </div>
        </form>
    </div>

<?php require 'footer.php'; ?>
