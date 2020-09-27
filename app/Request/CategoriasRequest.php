<?php

namespace App\Request;

use App\Models\CategoriasModel;

class CategoriasRequest {
    function Agregar(){
        $categoria = new CategoriasModel();
        if ($_POST['id'] != 0)
            $categoria = $categoria->getById($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">
                <div class="col-md-4 ">
                    <label for="name" class="control-label">Identificador</label>
                    <input type="text" name="code" id="code" value="<?= $categoria->codigo; ?>"
                           class="form-control" required autocomplete="off">
                </div>
                <div class="col-md-8 ">
                    <label for="surname" class="control-label">Categoria</label>
                    <input type="text" name="cat" id="cat" value="<?= $categoria->categoria; ?>" class="form-control" required autocomplete="off">
                </div>

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
        $categoria = new CategoriasModel();
        $categoria = $categoria->getById($_POST['id'],'id'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $categoria->id; ?>">
            <h5>Desea eliminar la categoria
                '<?= $categoria->categoria; ?>
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
        $can = new CategoriasModel();
        $categoria = $can->getAll('id');
        foreach ($categoria as $c) { ?>
            <tr>
              <td><?= $c->codigo ?></td>
              <td><?= $c->categoria; ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button type="button" class="btn btn-sm btn-primary" id="option1" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->id; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Editar">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="option2" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->id; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
            </tr>
            <?php
        }
    }
}
