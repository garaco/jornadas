<?php

namespace App\Request;

use App\Models\EmpleadosModel;
use App\Models\HorariosModel;

class HorariosRequest {
    function Agregar(){
        $horario = new HorariosModel();
        if ($_POST['id'] != 0)
            $horario = $horario->getById($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">

              <div class="col-md-6">
                  <label for="Apellidos" class="control-label">Empleado</label>
                  <select class="form-control" name="empleado" id="empleado">
                    <?php $emp = new EmpleadosModel();
                     $emp = $emp->getAll('id');
                      foreach ($emp as $g ){ ?>
                      <option value="<?= $g->id; ?>"<?= ($horario->id_empleado == $g->id) ? ' selected' : '' ?>><?= $g->nombre; ?> <?= $g->apellidos; ?></option>
                    <?php } ?>
                  </select>
              </div>

                <div class="col-md-6 ">
                    <label for="name" class="control-label">dia</label>
                    <select class="form-control" name="dia" id="dia">
                      <option value="Lunes" <?= ($horario->dia == 'Lunes') ? ' selected' : '' ?>>Lunes</option>
                      <option value="Martes" <?= ($horario->dia == 'Martes') ? ' selected' : '' ?>>Martes</option>
                      <option value="Miercoles" <?= ($horario->dia == 'Miercoles') ? ' selected' : '' ?>>Miercoles</option>
                      <option value="Jueves" <?= ($horario->dia == 'Jueves') ? ' selected' : '' ?>>Jueves</option>
                      <option value="Viernes" <?= ($horario->dia == 'Viernes') ? ' selected' : '' ?>>Viernes</option>
                      <option value="Sabado" <?= ($horario->dia == 'Sabado') ? ' selected' : '' ?>>Sabado</option>
                      <option value="Domingo" <?= ($horario->dia == 'Domingo') ? ' selected' : '' ?>>Domingo</option>
                      <option value="Festivo" <?= ($horario->dia == 'Festivo') ? ' selected' : '' ?>>Festivo</option>
                    </select>
                </div>
                <div class="col-md-6 ">
                    <label for="surname" class="control-label">Entrada</label>
                    <input type="time" name="entrada" id="enrada" value="<?= $horario->entrada; ?>" class="form-control" required autocomplete="off">
                </div>

                <div class="col-md-6 ">
                    <label for="surname" class="control-label">Salida</label>
                    <input type="time" name="salida" id="salida" value="<?= $horario->salida; ?>" class="form-control" required autocomplete="off">
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
        $horario = new HorariosModel();
        $horario = $horario->getById($_POST['id'],'id'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $horario->id; ?>">
            <h5>Desea eliminar el dia
                '<?= $horario->dia; ?>
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
        $can = new HorariosModel();
        $horario = $can->getAllHorarios();
        foreach ($horario as $c) { ?>
            <tr>
              <td><?= $c->empleado ?></td>
              <td><?= $c->dia; ?></td>
              <td><?= date('h:i a', strtotime($c->entrada)); ?></td>
              <td><?= date('h:i a', strtotime($c->salida)); ?></td>
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
