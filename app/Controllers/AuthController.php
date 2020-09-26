<?php

namespace App\Controllers;

use App\Auth\Auth;

class AuthController {
    protected $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function index() {
  		if(isset($_GET['msg'])) {
  			return view('index.twig', ['msg' => $_GET['msg']]);
  		}elseif(!isset($_SESSION['Username'])) {
  			return view('index.twig');
  		}else {
  			redirect('home');
  		}
    }

    public function login() {
        $user = input('user');
        $pass = input('pass');
        $auth = $this->auth->auth($user, $pass);
        if($auth != null) {
            session_start();
            $_SESSION['Username'] = $user;
    	      $_SESSION['Nombre']  = $auth->Nombres;
    		    $_SESSION['IdUser']    = $auth->IdUser;
            $_SESSION['type']  = $auth->Tipo;
			 redirect('home');
        } else {
            redirect('login?msg=error402');
        }
    }

    public function logout() {
        $this->auth->logout();
    }
}
