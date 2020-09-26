<?php

namespace App\Middleware;

use App\Auth\Auth;

class Middle{

	protected $auth;
	protected $is_auth;
	public function __construct() {
		$this->auth 	= new Auth();
		$this->is_auth	= $this->auth->isAuth();
	}
	public function register() {
		return array(
			'guest'	=> 'guest',
			'admin'	=> 'admin',
			'vendedor'	=> 'vendedor'
		);
	}
	public function isAuth($val, $dir) {
		$type = $this->register();
		if ($val == 'guest') {
			return;
		} else if($this->auth->isAuth()) {

			$flag=false;
		  $valor = explode(',',$val);
		  foreach ($valor as $v) {
		    if(type()==$v){
		      $flag=true;
		      break;
		    }
		  }
			if($flag){
				return;
			} else
				redirect('403');
				
		} else {
			if($dir == '/')
				redirect('login');
			else
				redirect('403');
		}
	}

}
