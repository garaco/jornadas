<?php

namespace App\Models;

use App\Config\Executor;

class HorariosModel extends Model {
	public $id;
	public $dia;
	public $entrada;
	public $salida;
	public $id_empleado;
	public $dia_fin;
	public $empleado;


	function __construct(){
		self::$tablename= 'jornadas_empleados';
		$this->id = 0;
		$this->dia = '';
		$this->entrada = '';
		$this->salida = '';
		$this->id_empleado = '';
		$this->dia_fin = '';
		$this->empleado = '';

	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (id, dia, entrada, salida, id_empleado, dia_fin) VALUES (0, '{$this->dia}', '{$this->entrada}', '{$this->salida}', {$this->id_empleado}, '{$this->dia_fin}');";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET dia = '{$this->dia}', entrada = '{$this->entrada}', salida = '{$this->salida}', id_empleado = {$this->id_empleado}, dia_fin='{$this->dia_fin}' WHERE id = {$this->id};";
		var_dump($sql);
		Executor::doit($sql);
	}

	public function getAllHorarios(){
		$sql = "select j.*, (select concat(nombre,' ',apellidos) from empleados where id = j.id_empleado ) as empleado from jornadas_empleados as j order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getByEmpleado($id){
		$sql = "(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Lunes')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Martes')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Miercoles')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Jueves')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Viernes')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Sabados')
				UNION
				(select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = 'Domingos')";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getByEmpleadoHoras($id,$dia){
		$sql = "select j.* from jornadas_empleados as j where id_empleado = {$id} and j.dia = '{$dia}'";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

}
