<?php

namespace App\Request;

use App\Models\UsuariosModel;

class UsuariosRequest {
    function Agregar(){
        $user = new UsuariosModel();
        if ($_POST['id'] != 0)
            $user = $user->getUser($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">
                <div class="col-md-4 ">
                    <label for="Usuario" class="control-label">Usuario</label>
                    <input type="text" name="Usuario" id="Usuario" value="<?= $user->NombreUser; ?>"
                           class="form-control" required autocomplete="off">
                </div>
                <div class="col-md-4 ">
                    <label for="password" class="control-label">Contraseña</label>
                    <input type="password" name="password" id="password" value="<?= $user->password; ?>" class="form-control" required autocomplete="off">
                </div>

                <div class="col-md-4">
                    <label for="Nombre" class="control-label">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="<?= $user->Nombres; ?>" class="form-control"
                           required autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label for="Apellidos" class="control-label">Apellidos</label>
                    <input type="text" name="Apellidos" id="Apellidos" value="<?= $user->Apellidos; ?>" class="form-control"
                           required autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label for="email" class="control-label">E-mail</label>
                    <input type="email" name="email" id="email" value="<?= $user->email; ?>" class="form-control"
                           required autocomplete="off">
                </div>

                <input type="hidden" name="id_tipo_usuario" value="admin">
            </div>


            <div class="clearfix"></div><hr>
            <div class="form-group">
                <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </form>
        <?php
    }

    function Eliminar(){
        $user = new UsuariosModel();
        $user = $user->getById($_POST['id'],'IdUser'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $user->IdUser; ?>">
            <h5>Desea eliminar el Usuario
                '<?= $user->NombreUser; ?>
                '?</h5>

            <div class="form-group">
              <div class="col-sm-12 text-right">
                  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-remove"></i>
                      Cancelar
                  </button>
                  <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
              </div>
            </div>
        </form>
        <?php
    }

    function Refresh(){
        $can = new UsuariosModel();
        $user = $can->getAll('NombreUser');
        foreach ($user as $c) { ?>
            <tr>
              <td><?= $c->NombreUser; ?></td>
              <td><?= $c->Nombres.' '.$c->Apellidos; ?></td>
              <td class="text-center"><?= ($c->Tipo == 'admin')?'administrador':'vendedor'; ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button type="button" class="btn btn-sm btn-primary" id="option1" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->IdUser; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Editar">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="option2" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->IdUser; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
            </tr>
            <?php
        }
    }
}
