<?php

namespace App\Models;

use App\Config\Executor;

class CategoriasModel extends Model {
	public $id;
	public $codigo;
	public $categoria;

	function __construct(){
		self::$tablename= 'categorias';
		$this->id = 0;
		$this->codigo = '';
		$this->categoria = '';

	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (id, codigo, categoria) VALUES (0, '{$this->codigo}', '{$this->categoria}');";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET codigo = '{$this->codigo}', categoria = '{$this->categoria}' WHERE id = {$this->id};";
		Executor::doit($sql);
	}


}
