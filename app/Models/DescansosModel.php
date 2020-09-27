<?php

namespace App\Models;

use App\Config\Executor;

class DescansosModel extends Model {
	public $id;
	public $dias;
	public $id_empleado;
	public $empleado;

	function __construct(){
		self::$tablename= 'descansos';
		$this->id = 0;
		$this->dias = 0;
		$this->id_empleado = '';
		$this->empleado = '';

	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (id, dias, id_empleado) VALUES (0, '{$this->dias}', {$this->id_empleado});";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET dias = '{$this->dias}', id_empleado = {$this->id_empleado} WHERE id = {$this->id};";
		Executor::doit($sql);
	}

	public function getAllDescansos(){
		$sql = "select j.*, (select concat(nombre,' ',apellidos) from empleados where id = j.id_empleado ) as empleado from descansos as j order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getByEmpleado($id){
		$sql = "select j.* from descansos as j where id_empleado = {$id} order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}


}
