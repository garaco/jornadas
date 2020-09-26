<?php

namespace App\Models;

use App\Config\Executor;

class UsuarioModel {
	public static $tablename = 'usuarios';
	public $IdUser;
	public $NombreUser;
	public $password;
	public $Nombres;
	public $Apellidos;
	public $email;
	public $Tipo;

	function __construct(){
		$this->IdUser = '';
		$this->$NombreUser = '';
		$this->$password = '';
		$this->Nombres = '';
		$this->Apellidos='';
		$this->email = '';
		$this->Tipo = '';
	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (IdUser, NombreUser, password, Nombres, Apellidos, email , id_tipo_usuario) VALUES ('0', '{$this->NombreUser}', '{$this->password}', '{$this->Nombres}', '{$this->Apellidos}', '{$this->email}', '{$this->id_tipo_usuario}')";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public static function delById($id){
		$sql = "DELETE FROM ".self::$tablename." WHERE id = {$id}";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "DELETE FROM ".self::$tablename." WHERE id = {$this->id}";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET NombreUser='{$this->NombreUser}', contrasena='{$this->contrasena}', Nombres='{$this->Nombres}',
		Apellidos='{$this->Apellidos}', email='{$this->email}', id_tipo_usuario='{$this->id_tipo_usuario}' WHERE IdUser = {$this->IdUser}";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id = {$id}";
		$query = Executor::doit($sql);

		return Model::one($query[0], new UsuarioModel());
	}

	public static function getByUser($name,$pass){
		$sql = "SELECT * FROM ".self::$tablename." WHERE NombreUser = '{$name}' and aes_decrypt(password,'Quetzalcoatl') = '{$pass}'";
		$query = Executor::doit($sql);

		return Model::one($query[0], new UsuarioModel());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename;
		$query = Executor::doit($sql);

		return Model::many($query[0], new UsuarioModel());
	}
}
