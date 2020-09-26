<?php

namespace App\Models;

use App\Config\Executor;

abstract class Model {
    public $id;
    public static $tablename;

    abstract function add();
    abstract function update();

    public static function delById($id,$field='id'){
        $sql = "DELETE FROM ".self::$tablename." WHERE $field = '{$id}'";
        Executor::doit($sql);
    }

    public function del(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id = '{$this->id}'";
        Executor::doit($sql);
    }

    public static function getById($id,$field='id'){
        $sql = "SELECT * FROM ".self::$tablename." WHERE $field = '{$id}'";
        $query = Executor::doit($sql);
        return self::one($query[0]);
    }

    public static function getAll($ord = 'id'){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY {$ord}";
        $query = Executor::doit($sql);

        return self::many($query[0]);
    }

    public static function getAllforEm($id=0, $ord='id'){
        $sql = "SELECT * FROM ".self::$tablename." where id_empresa = {$id} ORDER BY {$ord} DESC ";
        $query = Executor::doit($sql);

        return self::many($query[0]);
    }

    public static function getRange($i, $q, $ord = 'id'){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY {$ord} LIMIT {$i}, {$q}";
        $query = Executor::doit($sql);

        return self::many($query[0]);
    }

    public static function getSearch($field, $key, $ord = 'id'){
        $sql = "SELECT * FROM ".self::$tablename." WHERE {$field} LIKE '%{$key}%' ORDER BY {$ord} LIMIT 0, 25";
        $query = Executor::doit($sql);

        return self::many($query[0]);
    }

    public static function getClassName(){
        return get_called_class();
    }

	public static function many($query, $aclass = ''){
        if($aclass == '')
            $aclass = self::getClassName();

		$cnt = 0;
		$array = array();

		while($r = $query->fetch_array()){
			$array[$cnt] = new $aclass;
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0 && $cnt2%2==0){
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}

	public static function one($query, $aclass = ''){
        if($aclass == '')
            $aclass = self::getClassName();

        $found = null;
		$data = new $aclass;
		while($r = $query->fetch_array()){
			$cnt=1;
			foreach ($r as $key => $v) {
				if($cnt>0 && $cnt%2==0){
					$data->$key = $v;
				}
				$cnt++;
			}

			$found = $data;
			break;
		}
		return $found;
	}
}
