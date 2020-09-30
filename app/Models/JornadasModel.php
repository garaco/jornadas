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
		$query = "INSERT INTO ".self::$tablename." (id, fecha, dia, entrada, salida, horas_extras, inicio_extra, final_extra, id_empleado, tipo)
			VALUES (0, '{$this->fecha}', '{$this->dia}', '{$this->entrada}', '{$this->salida}', '{$this->horas_extras}', '{$this->inicio_extra}', '{$this->final_extra}', '{$this->id_empleado}', '{$this->tipo}');";
		$sql = Executor::doit($query);
		var_dump($query);
		return $sql[1];
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET fecha = '{$this->fecha}', dia = '{$this->dia}', entrada = '{$this->entrada}', salida = '{$this->salida}', horas_extras = '{$this->horas_extras}', inicio_extra = '{$this->inicio_extra}',
					final_extra = '{$this->final_extra}', id_empleado = {$this->id_empleado}, tipo = '{$this->tipo}' WHERE id = $this->id;";
		Executor::doit($sql);
	}

	public function getAllHorarios(){
		$sql = "select j.*, (select concat(nombre,' ',apellidos) from empleados where id = j.id_empleado ) as empleado from jornadas_empleados as j order by id desc";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getAllHoras(){
		$sql = "select d.*, (select concat(nombre,' ',apellidos) from empleados where id = d.id_empleado ) as empleado
		from dias_laborados as d order by id desc";
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
