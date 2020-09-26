<?php

namespace App\Auth;

use App\Models\UsuarioModel;

class Auth{
    public function isAuth() {
      return (user() != null);
    }

    public function auth($user, $pass){
        $user = UsuarioModel::getByUser($user, $pass);

		return $user;
    }

    public function logout() {
        session_unset();
        session_destroy();
        redirect('login');
    }

}
