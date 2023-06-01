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

    public function logout()
    {
        unset($_SESSION['user']);

        return redirect(route('/'));
    }
}
