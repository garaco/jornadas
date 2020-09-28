<?php
namespace App\Controllers;
use App\Models\JornadasModel;
use App\Models\HorariosModel;

class JornadasController{
	public function index() {
      $horario = new JornadasModel();
      $horarios = $horario->getAllHorarios();

			return view('Catalogos/jornadas.twig', ['horario' => $horarios, 'modelo' => 'Jornadas','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $save = new JornadasModel();
          if($_POST['id'] != 0){
              $save = $save->getById($_POST['id'],'id');
          }

					$save->id = $_POST['id'];
          $save->id_empleado = $_POST['empleado'];
					$save->dia = $_POST['dia'];
          $save->entrada = $_POST['entrada'];
          $save->salida = $_POST['salida'];

          if($_POST['id'] == 0){
          	$save->add();
          }else{
            $save->update();
          }
  	}

    public function del(){
  	    $del = new JornadasModel();
        $del->delById($_POST['id'],'id');

  	}

		public function dias(){
			$horario = new HorariosModel();
      $horarios = $horario->getByEmpleado($_POST['id']);
			$option = '';
			foreach ($horarios as $h) {
				$option.='<option value="'.$h->dia.'"> '.$h->dia.' de '.date('h:i a', strtotime($h->entrada)).' a '.date('h:i a', strtotime($h->salida)).'</option>';
			}
			 echo $option;
		}

		public function extras(){
			$jor = new JornadasModel();
			$jornadas = $jor->getcalculo($_POST['salida'],$_POST['dia'],$_POST['id']);
			$option = '';
			foreach ($jornadas as $j) {
				$option.="$j->horas_extras|$j->inicio_extra|$j->final_extra";
			}
			 echo $option;
		}

}
