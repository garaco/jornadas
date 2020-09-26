<?php

namespace App\Request;

use App\Models\VentaModel;
use App\Models\ProductosModel;

class VentaRequest {
    function Agregar(){
        if ($_POST['id'] != 0)
            ?>
        <form id="form" action="<?= route($_POST['model'] . '/save'); ?>" method="POST">
            <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
            <div class="form-group row">
              <div class="col-sm-1">
                <br>
                <button type="button" class="btn btn-success btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal"data-target="#productoModal" data-model="venta" data-operation="Producto">
                  <i class="fa fa-plus-square" aria-hidden="true"> </i>
                </button>
              </div>
              <div class="col-sm-3">
                <label for="nombre" class="col-sm-12 control-label">Codigo de barras</label>
                  <input type="text" name="barras" id="barras" onkeyup="code_bar();" value="" class="form-control">
              </div>
                <div class="col-sm-2">
                  <label for="nombre" class="col-sm-1 control-label">Referencia</label>
                    <input type="text" name="Codigo" id="Codigo" value="<?= date("dmY").time(); ?>"
                    readonly class="form-control">
                </div>
                <?php date_default_timezone_set('America/Monterrey') ?>
                <div class="col-sm-2">
                  <label for="siglas" class="col-sm-1 control-label">Fecha</label>
                    <input type="hidden" name="date" id="date" value="<?= date("Y-m-d H:i:s"); ?>"
                    readonly class="form-control">
                    <input type="datetime" name="date_a" id="date_a" value="<?= date("d/m/Y H:i:s"); ?>"
                    readonly class="form-control">
                </div>

                <div class="col-sm-4">
                  <label for="siglas" class="col-sm-1 control-label">Notas</label>
                    <textarea class="form-control" rows="1" name="notas"></textarea>
                </div>
            </div>

            <div class="clearfix"></div><hr>
            <div class="row">
              <div class="col-sm-8">
                <div style="height:260px;overflow-x:hidden;overflow-y:scroll;">
                  <table class="table table-sm thead-light table-bordered table-condensed table-hover">
                      <thead class="thead-light">
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>P.U.</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody id="tableProducto-content">

                      </tbody>
                  </table>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="row form-group">
                  <div class="col-sm-12">
                    <label for="siglas" class="control-label">Metodo de pago</label>
                      <select class="form-control" name="pago" id="pago">
                          <option value="Efectivo"> Efectivo </option>
                          <option value="Tarjeta"> Tarjeta </option>
                      </select>
                  </div>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                          <label for="siglas" class="control-label">Total a Pagar</label>
                          <input type="hidden" name="total" id="total" value="0">
                          <input type="text" name="tf" id="tf" class="form-control" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="siglas" class="control-label">Pagar con</label>
                          <input type="number" name="ingreso" id="ingreso" onkeyup="Devolucion()" class="form-control" required>
                        </div>
                    </div>

                  </div>
                  <div class="col-sm-12">
                    <label for="siglas" class="control-label">Cambio</label>
                      <input type="text" name="cambio" id="cambio" class="form-control" value="0" readonly>
                  </div>
                    <div class="col-sm-12">
                      <br>
                        <button type="button" class="btn btn-danger btn-small" onclick="Refresh('venta');"><i class="fa fa-remove"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success btn-small"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
              </div>
            </div>

        </form>

        <?php
    }

    function Producto(){
          session_start();
          $pruc = new ProductosModel();
          $Producto = $pruc->getAllProducto($_SESSION['IdEmpresa'],'IdProducto');
          ?>
          <div style="height:380px;overflow-x:hidden;overflow-y:scroll;">
            <table id="table" class="table table-sm thead-light table-bordered table-condensed table-hover">
                <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>Cantidad</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                </tr>
                </thead>
                <tbody id="table-content">
                <!-- Contenido de la tabla -->
                <?php $x=0; foreach ($Producto as $c) { ?>
                        <tr>
                          <td>
                            <input type="hidden" name="id" id="id<?= $x; ?>" value="<?= $c->IdProducto; ?>">
                            <input type="hidden" name="dataProc" id="dataProc<?= $x; ?>" value="<?= $c->IdProducto.'|'.$c->Codigo.'|'.$c->Nombre.'|'.$c->Precio_ven; ?>">
                            <?php if($c->existencias != 0) {?> <input type="checkbox" id="select<?= $x; ?>" class="form-control" onclick="proc(<?= $x; ?>);" value="true"> <?php } ?>

                          </td>
                <td width="10">  <input type="number" class="form-control" id="cantidad<?= $x; ?>" value="0"> </td>

                          <td><?= $c->Nombre; ?></td>
                          <td><?= '$'.$c->Precio_ven; ?></td>
                          <td><?= $c->existencias; ?></td>
                        </tr> <?php $x++;
                    }?>
                </tbody>
            </table>
          </div>
          <div class="clearfix"></div><hr>
          <div class="form-group">
              <div class="col-sm-12 text-right">
                  <button type="button" class="btn btn-danger btn-sm" onclick="prod_cancel();"><i class="fa fa-remove"></i>
                      Cancelar
                  </button>
                  <button type="submit" class="btn btn-success btn-sm" onclick="save();"><i class="fa fa-save"></i> Agregar</button>
              </div>
          </div>
          <?php
    }

    function Cancelar(){
        $venta = new VentaModel();
        $ventas = $venta->getById($_POST['id'],'id'); ?>
        <form  action="<?= route($_POST['model'] . '/del'); ?>" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
            <h5>Seguro de cancelar la venta con referencia <?= $ventas->referencia; ?> ?</h5>

            <div class="form-group">
              <div class="col-sm-12 text-right">
                  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-remove"></i>
                      No
                  </button>
                  <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Si</button>
              </div>
            </div>
        </form>
        <?php
    }

    function Venta(){
        $venta = new VentaModel();
        $ventas = $venta->getVentaDetail($_POST['id'],'id'); ?>
        <div class="container">
          <table class="table table-sm">
            <thead class="thead-light">
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
              <?php foreach ($ventas as $c) { ?>
              <tr>
                <td><?= $c->Codigo; ?></td>
                <td><?= $c->Producto; ?></td>
                <td><?= $c->Cantidad; ?></td>
                <td><?= '$'.$c->Precio; ?></td>
                <td><?= '$'.$c->Total; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php
    }

    function Ticket(){
        $venta = new VentaModel();
        $ventas = $venta->getById($_POST['id'],'id'); ?>

            <div class="container">
              <div class="row">
                <div class="col-sm-6 col-md-6" style="width: 25%;">

                    <div class="card">
                      <img src="<?= folder().'ticket.png'; ?>" class="card-img-top" alt="...">
                      <div class="card-body text-center">
                        <form  action="Visualiza" method="POST" target="_blank">
                          <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
                          <input type="hidden" name="type" value="Ticket">
                          <button type="submit" class="btn btn-primary" name="button">Ticket</button>
                        </form>
                      </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6" style="width: 25%;">

                    <div class="card">
                      <img src="<?= folder().'factura.png'; ?>" class="card-img-top" alt="...">
                      <div class="card-body text-center">
                        <form  action="Visualiza" method="POST" target="_blank">
                          <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
                          <input type="hidden" name="type" value="Factura">
                          <button type="submit" class="btn btn-primary" name="button">Factura</button>
                        </form>
                      </div>
                    </div>

                </div>
              </div>
            </div>

        <?php
    }

}
