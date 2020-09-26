<?php

namespace App\Config;

class Executor {
	public static function doit($sql){
		$con = DB::getCon();
		return array($con->query($sql), $con->insert_id);
	}
}