<?php

require_once "vendor/autoload.php";

$funcion = $_POST['function'];

$obj = "App\\Request\\".$_POST['model']."Request";
$obj = new $obj();
return call_user_func(array($obj, $funcion));
