<?php

namespace App\Controllers;
use App\Models\EmpleadosModel;

class ReportesController{

	public function index() {

		$empleado = new EmpleadosModel();
		$empleados = $empleado->getAllEmpleados('id');
		$semana = array();

		 return view('Catalogos/reportes.twig', ['empleados' => $empleados, 'year'=>date('Y'),
		 'modelo' => 'reporte','type'=>$_SESSION['type'],'user'=>$_SESSION['Username']]);
    }
}
