<?php
namespace App\Controllers;
use App\Models\HorariosModel;

class HorariosController{
	public function index() {
      $horario = new HorariosModel();
      $horarios = $horario->getAllHorarios();

			return view('Catalogos/horarios.twig', ['horario' => $horarios, 'modelo' => 'Horarios','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $save = new HorariosModel();
          if($_POST['id'] != 0){
              $save = $save->getById($_POST['id'],'id');
          }

					$save->id = $_POST['id'];
          $save->id_empleado = $_POST['empleado'];
					$save->dia = $_POST['dia'];
          $save->entrada = $_POST['entrada'];
          $save->salida = $_POST['salida'];
					$save->dia_fin = $_POST['dia'];

          if($_POST['id'] == 0){
          	$save->add();
          }else{
            $save->update();
          }
  	}

    public function del(){
  	    $del = new HorariosModel();
        $del->delById($_POST['id'],'id');

  	}

}
