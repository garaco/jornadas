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
	public $semana;
	public $categoria;
	public $rfc;
	public $sexo;

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
		$this->semana = '';
		$this->categoria = '';
		$this->rfc = '';
		$this->sexo = '';

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

	public function getByExtras($semana=''){
		// $sqlAlt="(select d.*,WEEK(d.fecha,1) as semana,
		// 	(select rfc from empleados where id = d.id_empleado ) as rfc,
		// 	(select sexo from empleados where id = d.id_empleado ) as sexo,
		// 	(select concat(nombre,' ',apellidos) from empleados where id = d.id_empleado ) as empleado
		// 	from dias_laborados as d  where WEEK(d.fecha,1) = {$semana} and dia <> 'Domingos' order by id_empleado)
		// 	union
		// (select d.*,WEEK(d.fecha,1) as semana,
		// 			(select rfc from empleados where id = d.id_empleado ) as rfc,
		// 			(select sexo from empleados where id = d.id_empleado ) as sexo,
		// 			(select concat(nombre,' ',apellidos) from empleados where id = d.id_empleado ) as empleado
		// 			from dias_laborados as d  where WEEK(d.fecha,0) = ({$semana}) and dia = 'Domingos' order by id_empleado) 	";

		$sql="select d.*,WEEK(d.fecha,1) as semana,
		(select rfc from empleados where id = d.id_empleado ) as rfc,
		(select sexo from empleados where id = d.id_empleado ) as sexo,
		(select concat(nombre,' ',apellidos) from empleados where id = d.id_empleado ) as empleado
		from dias_laborados as d  where WEEK(d.fecha,0) = ({$semana})  order by id_empleado";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getByExtrasxEmpleados($semana='',$id=''){
		$sql="select d.*,WEEK(d.fecha,1) as semana,
			(select rfc from empleados where id = d.id_empleado ) as rfc,
			(select categoria from categorias where id = (select id_categoria from empleados where id = d.id_empleado )) as categoria,
			(select concat(nombre,' ',apellidos) from empleados where id = d.id_empleado ) as empleado
			from dias_laborados as d  where WEEK(d.fecha,0) = {$semana} and id_empleado = {$id} order by id_empleado";
		$query = Executor::doit($sql);

		return self::many($query[0]);
	}

	public function getSumHours($semana,$id,$tipo){
		$sql="select  TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(d.horas_extras))), '%H:%i')  as horas_extras
		from dias_laborados as d  where WEEK(d.fecha,0) = {$semana} and FIND_IN_SET(tipo, '{$tipo}')";
		$query = Executor::doit($sql);

		return self::one($query[0]);
	}

	public function getcalculo($inicio,$salida,$id_empleado){
		$sql="select DATE_FORMAT(TIMEDIFF('$salida','$inicio'), '%H:%i') as horas_extras";

			 $query = Executor::doit($sql);

			 return self::many($query[0]);
	}

	public function resatar($hora){
		$sql="select DATE_FORMAT(TIMEDIFF('{$hora}','02:00'), '%H:%i') as horas_extras";

		$query = Executor::doit($sql);

			 return self::one($query[0]);
	}

	public function getSumHoursh($body){
		$sql="select  TIME_FORMAT(SEC_TO_TIME(SUM({$body})), '%H:%i')  as horas_extras";
		$query = Executor::doit($sql);
		return self::one($query[0]);
	}

}
