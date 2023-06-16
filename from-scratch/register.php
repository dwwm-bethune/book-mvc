<?php

require 'data.php';

// Récupérer les champs
$email = post('email');
$password = post('password');
$confirmPassword = post('confirm_password');
$errors = [];

if (isSubmitted()) {
    // Vérifier l'email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'L\'email est invalide';
    }

    $user = select('SELECT * FROM users WHERE email = :email', ['email' => $email]);
    if ($user) {
        $errors['email'] = 'Email déjà utilisé';
    }

    if (strlen($password) < 8 || $password !== $confirmPassword) {
        $errors['password'] = 'Mot de passe trop court ou non correspondant';
    }

    if (empty($errors)) {
        insert('INSERT INTO users (email, password) VALUES (:email, :password)', [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['user'] = $email; // Connexion
        $_SESSION['message'] = 'Merci pour votre inscription';

        header('Location: ./livres.php');
    }
}

require 'header.php'; ?>

    <div class="max-w-5xl mx-auto px-3">
        <h1 class="text-center text-2xl">Inscription</h1>

        <?php if (!empty($errors)) { ?>
        <div class="bg-red-300 p-5 rounded border border-red-800 text-red-800 my-4">
            <?php foreach ($errors as $error) { ?>
                <p><?= $error; ?></p>
            <?php } ?>
        </div>
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
            <div class="mb-4">
                <label for="confirm_password" class="block">Confirmer mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="border-0 border-b focus:ring-0 w-full">
            </div>

            <div class="text-center">
                <button class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200">Inscription</button>
            </div>
        </form>
    </div>

<?php require 'footer.php'; ?>
