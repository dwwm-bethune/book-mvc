<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Model\User;

class AuthController extends Controller
{
    public function login()
    {
        $errors = [];

        if (isSubmitted()) {
            $user = User::findEmail(request('email'));

            if (! $user || ! password_verify(request('password'), $user->password)) {
                $errors['email'] = 'Identifiants invalides.';
            }

            if (empty($errors)) {
                $_SESSION['user'] = $user;

                redirect(route('/'));
            }
        }

        return $this->render('auth/login', [
            'email' => request('email'),
            'errors' => $errors,
        ]);
    }

    public function register()
    {
        $user = new User();
        $errors = [];
        $success = false;

        if (isSubmitted()) {
            $user->email = request('email');
            $user->password = password_hash(request('password'), PASSWORD_DEFAULT);

            if (! filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email est invalide.';
            }

            if (empty(request('password')) || request('password') !== request('confirm_password')) {
                $errors['password'] = 'Le mot de passe est invalide.';
            }

            if (User::findEmail($user->email)) {
                $errors['email'] = 'L\'email est déjà utilisé.';
            }

            if (empty($errors)) {
                $success = $user->save();

                $_SESSION['user'] = $user;

                redirect(route('/'));
            }
        }

        return $this->render('auth/register', [
            'user' => $user,
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);

        return redirect(route('/'));
    }
}
