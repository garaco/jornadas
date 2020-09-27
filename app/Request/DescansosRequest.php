<?php

namespace App\Request;

use App\Models\EmpleadosModel;
use App\Models\DescansosModel;

class DescansosRequest {
    function Agregar(){
        $descanso = new DescansosModel();
        if ($_POST['id'] != 0)
            $descanso = $descanso->getById($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">

              <div class="col-md-6">
                  <label for="empleado" class="control-label">Empleado</label>
                  <select class="form-control" name="empleado" id="empleado">
                    <?php $emp = new EmpleadosModel();
                     $emp = $emp->getAll('id');
                      foreach ($emp as $g ){ ?>
                      <option value="<?= $g->id; ?>"<?= ($descanso->id_empleado == $g->id) ? ' selected' : '' ?>><?= $g->nombre; ?> <?= $g->apellidos; ?></option>
                    <?php } ?>
                  </select>
              </div>

                <div class="col-md-6 ">
                    <label for="dias" class="control-label">Dias de Descanso</label>
                    <input type="number" name="dias" id="dias" value="<?= $descanso->dias; ?>" class="form-control" required autocomplete="off">
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
        $descanso = new DescansosModel();
        $descanso = $descanso->getById($_POST['id'],'id'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $descanso->id; ?>">
            <h5>Desea eliminar el descanso de
                '<?= $descanso->dias; ?> dias
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
        $can = new DescansosModel();
        $descanso = $can->getAllDescansos();
        foreach ($descanso as $c) { ?>
            <tr>
              <td><?= $c->empleado ?></td>
              <td><?= $c->dias; ?></td>
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
