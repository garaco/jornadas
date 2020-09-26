<?php

namespace App\Config;

use mysqli;

class DB {
	public static $db;
	public static $con;

	function __construct(){
		$this->user="root";
		$this->pass="";
		$this->host="localhost";
		$this->ddbb="jornadas";
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb) or die("Error en la conexión");
		return $con;
	}

    public static function getCon(){
        if(self::$con==null && self::$db==null){
            self::$db = new DB();
            self::$con = self::$db->connect();
			self::$con;
        }
        return self::$con;
    }
}
