<?php
namespace App\Controllers;
use App\Models\DescansosModel;

class DescansosController{
	public function index() {
      $des = new DescansosModel();
      $descanso = $des->getAllDescansos();

			return view('Catalogos/descansos.twig', ['descanso' => $descanso, 'modelo' => 'Descansos','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $save = new DescansosModel();
          if($_POST['id'] != 0){
              $save = $save->getById($_POST['id'],'id');
          }

					$save->id = $_POST['id'];
          $save->id_empleado = $_POST['empleado'];
					$save->dias = $_POST['dias'];

          if($_POST['id'] == 0){
          	$save->add();
          }else{
            $save->update();
          }
  	}

    public function del(){
  	    $del = new DescansosModel();
        $del->delById($_POST['id'],'id');

  	}


}
