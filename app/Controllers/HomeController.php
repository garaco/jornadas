<?php

namespace App\Controllers;
use App\Models\PagoModel;

class HomeController{

	public function index() {
			 return view('Catalogos/inicio.twig', ['modelo' => 'home','type'=>$_SESSION['type'],'user'=>$_SESSION['Username']]);
    }

		public function save(){
					$reg = new PagoModel();
					if($_POST['id'] != 0){
							$reg = $reg->getById($_POST['id'],'IdPago');
					}
					$reg->Concepto=$_POST['Concepto'];
					$reg->IdCliente=$_POST['Cliente'];
					$reg->IdPrestamo=$_POST['IdPrestamo'];
					$reg->Total=$_POST['Importe'];
					$reg->Fecha=$_POST['Fecha'];
					$reg->Folio=$_POST['Folio'];
					$reg->IdPago=$_POST['id'];

					if($_POST['id'] == 0){
							$reg->add();
					} else{
							$reg->update();
					}

					redirect('cpanel/home');
		}

		public function del(){
				$concepto = new PagoModel();
					$concepto->delById($_POST['id'],'IdPago');

					redirect('cpanel/home');
		}
}
