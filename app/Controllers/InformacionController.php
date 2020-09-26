<?php

namespace App\Controllers;

use App\Models\VentaModel;

class InformacionController{
    public function index() {
    	return view('Catalogos/informe.twig',['user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function informe() {
      $vent = new VentaModel();
      $venta = $vent->estatadisticas($_SESSION['IdEmpresa']);
      $data;
      foreach ($venta as $a) {
        $data = "$a->enero ,  $a->febrero ,  $a->marzo , $a->abril ,  $a->mayo ,  $a->junio ,  $a->julio , $a->agosto , $a->septiembre , $a->octubre , $a->noviembre , $a->diciembre ,";
      }
        	return view('Catalogos/grafico.twig',["grafica"=>$data,'nameEmpresa'=>$_SESSION['Empresa'],
          'user'=>$_SESSION['Username'],'logo'=>$_SESSION['Logo'], 'modelo'=>"informe",'type'=>$_SESSION['type'] ] );
    }
}
