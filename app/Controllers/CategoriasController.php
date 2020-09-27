<?php
namespace App\Controllers;
use App\Models\CategoriasModel;

class CategoriasController{
	public function index() {
      $categoria = new CategoriasModel();
      $categorias = $categoria->getAll('id');

			return view('Catalogos/categorias.twig', ['categoria' => $categorias, 'modelo' => 'Categorias','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $save = new CategoriasModel();
          if($_POST['id'] != 0){
              $save = $save->getById($_POST['id'],'id');
          }

					$save->id = $_POST['id'];
          $save->codigo = $_POST['code'];
          $save->categoria = $_POST['cat'];

          if($_POST['id'] == 0){
          	$save->add();
          }else{
            $save->update();
          }
  	}

    public function del(){
  	    $del = new CategoriasModel();
        $del->delById($_POST['id'],'id');
  	}


}
