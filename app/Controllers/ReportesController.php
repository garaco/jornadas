<?php

namespace App\Controllers;
use App\Models\EmpleadosModel;

class ReportesController{

	public function index() {

		$empleado = new EmpleadosModel();
		$empleados = $empleado->getAllEmpleados('id');

			 return view('Catalogos/reportes.twig', ['empleados' => $empleados, 'modelo' => 'reporte','type'=>$_SESSION['type'],'user'=>$_SESSION['Username']]);
    }
}
