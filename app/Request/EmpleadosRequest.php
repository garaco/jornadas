<?php

namespace App\Request;

use App\Models\EmpleadosModel;
use App\Models\CategoriasModel;
use App\Models\HorariosModel;
use App\Models\DescansosModel;

class EmpleadosRequest {
    function Agregar(){
        $empleado = new EmpleadosModel();
        if ($_POST['id'] != 0)
            $empleado = $empleado->getById($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">
                <div class="col-md-4 ">
                    <label for="surname" class="control-label">R.F.C.</label>
                    <input type="text" name="rfc" id="rfc" value="<?= $empleado->rfc; ?>" class="form-control" required autocomplete="off">
                </div>

                <div class="col-md-4">
                    <label for="surname" class="control-label">Nombre(s)</label>
                    <input type="text" name="name" id="name" value="<?= $empleado->nombre; ?>" class="form-control" required autocomplete="off">
                </div>

                <div class="col-md-4">
                    <label for="Nombre" class="control-label">Apellidos</label>
                    <input type="text" name="surname" id="surname" value="<?= $empleado->apellidos; ?>" class="form-control"
                           required autocomplete="off">
                </div>

                <div class="col-md-8">
                    <label for="Apellidos" class="control-label">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria">
                      <?php
                      $categoria = new CategoriasModel();
                       $categoria = $categoria->getAll('id');
                        foreach ($categoria as $g ){ ?>
                        <option value="<?= $g->id; ?>"<?= ($empleado->id_categoria == $g->id) ? ' selected' : '' ?>><?= $g->categoria; ?></option>
                      <?php } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="Apellidos" class="control-label">Activo</label>
                    <select class="form-control" name="active" id="active">
                      <option value="Si"<?= ($empleado->activo == 'Si') ? ' selected' : '' ?>>Si</option>
                      <option value="No"<?= ($empleado->activo == 'No') ? ' selected' : '' ?>>No</option>
                    </select>
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
        $empleado = new EmpleadosModel();
        $empleado = $empleado->getById($_POST['id'],'id'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $empleado->id; ?>">
            <h5>Desea eliminar el empleado
                '<?= $empleado->nombre; ?>
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
        $can = new EmpleadosModel();
        $empleado = $can->getAllEmpleados('NombreUser');
        foreach ($empleado as $c) { ?>
            <tr>
              <td><?= $c->rfc; ?></td>
              <td><?= $c->nombre; ?></td>
              <td><?= $c->apellidos ?></td>
              <td><?= $c->categoria ?></td>
              <td><?= $c->activo ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button type="button" class="btn btn-sm btn-success" id="option1" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->id; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Horario">
                        <i class="fa fa-calendar"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="option2" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->id; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Editar">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="option3" data-toggle="modal" data-target="#operationModal" data-id="<?= $c->id; ?>" data-model="<?=$_POST['model']; ?>" data-operation="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
            </tr>
            <?php
        }
    }

    function Horario(){
        $hor = new HorariosModel();
        $horarios = $hor->getByEmpleado($_POST['id']);
        ?>
        <div>
            <h4 style="text-align:center;">Horario del Empleado </h4>
        </div>

        <table  class="table thead-light table-bordered table-condensed table-hover">
            <thead>
            <tr>
                <th>Dia</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
            </thead>
            <tbody id="table-content">
            <!-- Contenido de la tabla -->
            <?php
            foreach ($horarios as $c) { ?>
                <tr>
                  <td><?= $c->dia ?></td>
                  <td><?= date('h:i a', strtotime($c->entrada)); ?></td>
                  <td><?= date('h:i a', strtotime($c->salida)); ?></td>
                </tr>
                <?php
            }
            $des = new DescansosModel();
            $descansos = $des->getByEmpleado($_POST['id']);

            foreach ($descansos as $c) { ?>
                <tr>
                  <td colspan="2">Dias de descando</td>
                  <td><?= $c->dias ?></td>
                </tr>
                <?php
            }
            ?>

          </tbody>
      </table>
            <?php


    }
}
