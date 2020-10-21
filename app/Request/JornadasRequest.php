<?php

namespace App\Request;

use App\Models\EmpleadosModel;
use App\Models\JornadasModel;

class JornadasRequest {
    function Agregar(){
        $joradas = new JornadasModel();
        if ($_POST['id'] != 0)
            $joradas = $joradas->getById($_POST['id']);

        ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
            <div class="row form-group">

              <div class="col-md-6">
                  <label for="Apellidos" class="control-label">Empleado</label>
                  <select class="form-control" name="empleado" id="empleado" onchange="dias();">
                    <option value="0">Seleccione un empleado</option>
                    <?php $emp = new EmpleadosModel();
                     $emp = $emp->getAll('id');
                      foreach ($emp as $g ){ ?>
                      <option value="<?= $g->id; ?>"<?= ($joradas->id_empleado == $g->id) ? ' selected' : '' ?>><?= $g->nombre; ?> <?= $g->apellidos; ?></option>
                    <?php } ?>
                  </select>
              </div>

                <div class="col-md-6 " id="select-dia">
                    <label for="name" class="control-label">Dias de la Semana/Horas</label>
                    <select class="form-control" name="dia" id="dia" onchange="horarios();">
                      <option value="<?= $joradas->dia ?>" > <?= $joradas->dia ?></option>
                    </select>
                </div>

            </div>


            <div class="row form-group">
              <div class="col-md-4">
                  <label for="surname" class="control-label">Fecha</label>
                  <input type="date" name="fecha" id="fhcha" value="<?= $joradas->fecha; ?>" class="form-control" required autocomplete="off">
              </div>

              <div class="col-md-4">
                  <label for="surname" class="control-label">Entrada</label>
                  <input type="time" name="entrada" id="enrada" value="<?= $joradas->entrada; ?>" class="form-control" required autocomplete="off">
              </div>

              <div class="col-md-4">
                  <label for="surname" class="control-label">Salida</label>
                  <input type="time" name="salida" id="salida" value="<?= $joradas->salida; ?>" class="form-control" required autocomplete="off">
              </div>

            </div>
            <hr>
            <div>
                <h4 style="text-align:center;">Horas Extras</h4>
            </div>
            <div class="row form-group "  id="panel-horas">

              <div class="col-md-3">
                  <label for="surname" class="control-label">Inicio de Horas Extras</label>
                  <input type="time" name="inicio_extra" id="inicio_extra" value="<?= $joradas->inicio_extra; ?>" class="form-control" required autocomplete="off">
              </div>

              <div class="col-md-4">
                  <label for="surname" class="control-label">Fin de Horas Extras</label>
                  <div class="input-group mb-2">
                    <input type="time" name="final_extra" id="final_extra" value="<?= $joradas->final_extra; ?>" class="form-control" required autocomplete="off">
                    <div class="input-group-prepend">
                      <button class="btn btn-primary" type="button" name="button" onclick="calculo();"><i class="fa fa-clock-o" aria-hidden="true"></i></button>
                    </div>
                  </div>

              </div>

              <div class="col-md-2">
                  <label for="surname" class="control-label">Horas</label>
                  <input type="text" name="horas" id="horas" value="<?= $joradas->horas_extras; ?>" class="form-control" required autocomplete="off">
              </div>

              <div class="col-md-3">
                  <label for="surname" class="control-label">Tipo Horas</label>
                  <select class="form-control" name="tipo" id="tipo">
                    <option value="Horas Extras" <?= ($joradas->tipo == 'Horas Extras') ? ' selected' : '' ?>>Horas Extras</option>
                    <option value="Domingos" <?= ($joradas->tipo == 'Domingos') ? ' selected' : '' ?>>Domingos</option>
                    <option value="Festivos" <?= ($joradas->tipo == 'Festivos') ? ' selected' : '' ?>>Festivos</option>
                    <option value="Prima Dominical" <?= ($joradas->tipo == 'Prima Dominical') ? ' selected' : '' ?> >Prima Dominical</option>
                  </select>
              </div>

            </div>

            <div class="clearfix"></div><hr>
            <div class="form-group">
                <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" id="btn-save" ><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </form>
        <?php
    }

    function Eliminar(){
        $joradas = new JornadasModel();
        $joradas = $joradas->getById($_POST['id'],'id'); ?>
        <form id="form" action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $joradas->id; ?>">
            <h5>Desea eliminar el registro?</h5>

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
        $can = new JornadasModel();
        $joradas = $can->getAllHoras();
        foreach ($joradas as $c) { ?>
            <tr>
              <td><?= $c->empleado ?></td>
              <td><?= $c->dia; ?></td>
              <td><?= date('d/m/Y', strtotime($c->fecha)); ?></td>
              <td><?= date('h:i a', strtotime($c->inicio_extra)); ?></td>
              <td><?= date('h:i a', strtotime($c->final_extra)); ?></td>
              <td><?= $c->tipo; ?></td>
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
