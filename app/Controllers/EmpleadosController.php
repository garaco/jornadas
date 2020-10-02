<?php
namespace App\Controllers;
use App\Models\EmpleadosModel;

class EmpleadosController{
	public function index() {
      $empleado = new EmpleadosModel();
      $empleados = $empleado->getAllEmpleados('id');

			return view('Catalogos/empleados.twig', ['empleados' => $empleados, 'modelo' => 'Empleados','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $save = new EmpleadosModel();
          if($_POST['id'] != 0){
              $save = $save->getById($_POST['id'],'id');
          }

					$save->id = $_POST['id'];
          $save->codigo = $_POST['codigo'];
					$save->rfc = $_POST['rfc'];
          $save->nombre = $_POST['name'];
          $save->apellidos = $_POST['surname'];
					$save->id_categoria = $_POST['categoria'];
          $save->activo = $_POST['active'];

          if($_POST['id'] == 0){
          	$save->add();
          }else{
            $save->update();
          }
  	}

    public function del(){
  	    $del = new EmpleadosModel();
        $del->delById($_POST['id'],'id');

  	}


}
