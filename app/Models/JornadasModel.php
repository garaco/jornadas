<?php

namespace App\Models;

use App\Config\Executor;

class JornadasModel extends Model {
	public $id;
	public $fecha;
	public $dia;
	public $entrada;
	public $salida;
	public $horas_extras;
	public $inicio_extra;
	public $final_extra;
	public $id_empleado;
	public $empleado;
	public $tipo;

	function __construct(){
		self::$tablename= 'dias_laborados';
		$this->id = 0;
		$this->fecha = date("Y-m-d");
		$this->dia = '';
		$this->entrada = '';
		$this->salida = '';
		$this->horas_extras = '';
		$this->inicio_extra = '';
		$this->final_extra = '';
		$this->id_empleado = '';
		$this->empleado = '';
		$this->tipo = '';

	}

	public function add(){
		$query = "INSERT INTO ".self::$tablename." (id, dia, entrada, salida, id_empleado) VALUES (0, '{$this->dia}', '{$this->entrada}', '{$this->salida}', {$this->id_empleado});";
		$sql = Executor::doit($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET dia = '{$this->dia}', entrada = '{$this->entrada}', salida = '{$this->salida}', id_empleado = {$this->id_empleado} WHERE id = {$this->id};";
		Executor::doit($sql);
	}

	public function getAllHorarios(){
		$sql = "select j.*, (select concat(nombre,' ',apellidos) from empleados where id = j.id_empleado ) as empleado from jornadas_empleados as j order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getByEmpleado($id){
		$sql = "select j.* from jornadas_empleados as j where id_empleado = {$id} order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getcalculo($salida,$dia,$id_empleado){
		$sql=" select if ('{$salida}'>salida,DATE_FORMAT(TIMEDIFF('$salida',salida), '%H:%i') ,0) as horas_extras,
			 if ('{$salida}'>salida, DATE_FORMAT(salida, '%H:%i'), 0) as inicio_extra,
			 if ('{$salida}'>salida,'{$salida}' ,0) as final_extra
			 from jornadas_empleados where dia = '{$dia}' and id_empleado = {$id_empleado}";

			 $query = Executor::doit($sql);

			 return self::many($query[0]);
	}

}
