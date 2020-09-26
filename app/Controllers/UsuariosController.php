<?php
namespace App\Controllers;
use App\Models\UsuariosModel;

class UsuariosController{
	public function index() {
      $usuario = new UsuariosModel();
      $usuarios = $usuario->getAll('NombreUser');
		 return view('Catalogos/usuario.twig', ['usuarios' => $usuarios, 'modelo' => 'Usuarios','user'=>$_SESSION['Username'],'type'=>$_SESSION['type']]);
    }

    public function save(){
          $reg = new UsuariosModel();
          if($_POST['id'] != 0){
              $reg = $reg->getById($_POST['id'],'IdUser');
          }

          $reg->NombreUser = $_POST['Usuario'];
          $reg->Nombres = $_POST['Nombre'];
          $reg->IdUser = $_POST['id'];
          $reg->password = $_POST['password'];
          $reg->Apellidos=$_POST['Apellidos'];
          $reg->email = $_POST['email'];
          $reg->tipo = $_POST['id_tipo_usuario'];

          if($_POST['id'] == 0){
          	$reg->add();
          }else{
            $reg->update();
          }
  	}

    public function del(){
  	    $usuario = new UsuariosModel();
        $usuario->delById($_POST['id'],'IdUser');

        redirect('cpanel/usuarios');
  	}


}
