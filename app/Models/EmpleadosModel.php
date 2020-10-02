<?php

namespace App\Models;

use App\Config\Executor;

class EmpleadosModel extends Model {
	public $id;
	public $codigo;
	public $rfc;
	public $nombre;
	public $apellidos;
	public $id_categoria;
	public $categoria;
	public $activo;

	function __construct(){
		self::$tablename= 'empleados';
		$this->id = 0;
		$this->codigo = '';
		$this->rfc = '';
		$this->nombre = '';
		$this->apellidos='';
		$this->id_categoria = 0;
		$this->categoria = '';
		$this->activo = '';
	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (id, codigo, rfc, nombre, apellidos, id_categoria, Activo) VALUES (0, '{$this->codigo}', '{$this->rfc}', '{$this->nombre}', '{$this->apellidos}', {$this->id_categoria}, '{$this->activo}')";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET codigo = '{$this->codigo}', rfc = '{$this->rfc}', nombre = '{$this->nombre}', apellidos = '{$this->apellidos}', id_categoria = {$this->id_categoria}, activo = '{$this->activo}' WHERE id = {$this->id};";
		Executor::doit($sql);
	}

	public function getAllEmpleados(){
		$sql="select e.*, (select categoria from categorias where id = e.id_categoria) as categoria from empleados as e order by codigo asc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

}
