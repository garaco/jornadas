<?php

namespace App\Controllers;
use App\Models\PagoModel;

class ReportesController{

	public function index() {
			 return view('Catalogos/reportes.twig', ['modelo' => 'reporte','type'=>$_SESSION['type'],'user'=>$_SESSION['Username']]);
    }
}
