var url_request = window.location.protocol + "//" + window.location.host + "/jornadas/requested.php";
var spinner = '<td colspan="5" class="text-center"> <div class="spinner-border text-dark text-center"><span class="sr-only">Cargando...</span></div> </td>';
var ajaxError = '<i class="fa fa-warning text-warning"></i> Error al cargar los datos!';
var Productos = new Array();
var comprobacion="";
var i=0;
var m=0;
function formulario(modelo,operacion){
  i=0;
  $.ajax({
      url: url_request,
      type: 'POST',
      data: {
          function: (operacion == 'Agregar' || operacion == 'Editar') ?  'Agregar' : operacion,
          model: modelo,
          id: 0
      },
      success: function (data) {
        $('#datos').html(data);
      },
      error: function () {
        $('#datos').html(ajaxError);
      }
  });
}

$('#productoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var operation = button.data('operation');
    var model = button.data('model');
    var modal = $(this);
    $.ajax({
        url: url_request,
        type: 'POST',
        data: {
            function: (operation == 'Agregar' || operation == 'Editar') ?  'Agregar' : operation,
            model: model,
            id: 0
        },
        beforeSend: function () {
            modal.find('.modal-title').html('<h3 style="margin: 0">' + operation + ' registro</h3>');
            modal.find('.modal-body').html(spinner);
        },
        success: function (data) {
            $('#table').dataTable().fnDestroy();
            modal.find('.modal-body').html(data);
            Table();
        },
        error: function () {
            modal.find('.modal-body').html(ajaxError);
        }
    });
});

$('#operationModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    operation = button.data('operation');
    var model = button.data('model');
    var id = button.data('id');
    var modal = $(this);

    $.ajax({
        url: url_request,
        type: 'POST',
        data: {
            function: (operation == 'Agregar' || operation == 'Editar') ?  'Agregar' : operation,
            model: model,
            id: id
        },
        beforeSend: function () {
            modal.find('.modal-title_t').html('<h3 style="margin: 0">' + operation + ' registro</h3>');
            modal.find('.modal-body_t').html(spinner);
        },
        success: function (data) {
            modal.find('.modal-body_t').html(data);
        },
        error: function () {
            modal.find('.modal-body_t').html(ajaxError);
        }
    });
});

function Refresh(modelo){
  comprobacion="";
  i=0;
  window.location=window.location.protocol + "//" + window.location.host + "/venta/"+modelo;
}

function prod_cancel(){
  var valida=false;
  let valores="";
  var filas = $("#table-content").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
  	  var resultado = "";
  	for(g=0; g<filas.length; g++){ //Recorre las filas 1 a 1
      if( $('#select'+g).is(':checked') ) {
        i--;m=0;
        Productos[i]="";
      }
    }
    $('#productoModal').modal('hide');
}

function proc(x){
  var valida=false;
  var val = $('#id'+x).val()
  if( $('#select'+x).is(':checked') ) {
    var datos_prod = comprobacion.split("|");
    for (var g = 0; g < datos_prod.length; g++) {

      if(val == (datos_prod[g].trim())){
        valida=true;
        break;
      }
    }

    if( valida ){
      Swal.fire({
        position: 'top',
        icon: 'warning',
        title: 'El producoto ya fue agregado',
        showConfirmButton: false,
        timer: 1500
      });
      $('#select'+x).attr('checked',false)
    }else{
      Productos[i]=x;
      i++;
    }
  }else{
    i--;m=0;
    Productos[i]="";
  }
}

function save(){
  var table="",datos="";
  var cant=0,g=0;
  let posicion=null;
  var dat;
  var tem="";
  var total = parseFloat($('#total').val());
  // alert(total);
  for (var z = 0; z <= i; z++) {
    g = Productos[z];
    cant = $('#cantidad'+g).val();
    datos = $('#dataProc'+g).val();
    if(datos!=undefined){
        dat = datos.split("|");
         posicion = comprobacion.indexOf(dat[0]);
        if(posicion == -1){
          table= "<tr> <td> <input type='hidden' name='ids[]' class='form-control' value='"+dat[0]+"'>"
          +dat[1]+"</td>"
          +"<td> "+dat[2]+" </td>"
          +"<td width='20'> <input type='number' name='cantidad[]' class='form-control' id='cant"+dat[0]+"' onblur='cantidad("+dat[0]+");' value='"+cant+"'> </td>"
          +"<td> $"+dat[3]+" <input type='hidden' class='form-control' id='valor"+dat[0]+"' value='"+dat[3]+"'> </td>"
          +"<td>  <input type='hidden' id='tc"+dat[0]+"' value='"+(cant*dat[3])+"'> <strong id ='total"+dat[0]+"'> $"+monedaChange(3,2,(cant*dat[3]))+" </strong></td>"
          +"<td width='20' id='delete"+dat[0]+"'> <button type='button' class='btn btn-danger btn-sm' onclick='borraFila("+dat[0]+");'> <i class='fa fa-window-close' aria-hidden='true'></i> </button> </td> </tr>";
          $('#tableProducto-content').append(table);
          total = total+(cant*dat[3]);
          temp=" | "+dat[0];
          comprobacion= comprobacion + temp;
          m--;
          Productos[z]="";
        }else{
          m++;
        }

    }
  }

  $('#total').val(total);
  $('#tf').val("$"+monedaChange(3,2,total));

  if(table==""){
    if(m>0){
    }else{
      Swal.fire({
        position: 'top',
        icon: 'info',
        title: 'No hay producto seleccionado',
        showConfirmButton: false,
        timer: 1500
      });
    }
  }else{
    i=0;m=0;
    $('#productoModal').modal('hide');
  }

}


function code_bar(){
  var table="",datos="";
  var cant=0,g=0;
  let posicion=null;
  var dat;
  var tem="";
  var total = parseFloat($('#total').val());
  $.ajax({
      url: 'venta/search',
      type: 'POST',
      data: {
          code: $("#barras").val()
      },
      success: function (data) {
        if(data != 'n/a'){
          dat = data.split("|");
           posicion = comprobacion.indexOf(dat[0]);
          if(posicion == -1){
            table= "<tr> <td> <input type='hidden' name='ids[]' class='form-control' value='"+dat[0]+"'>"
            +dat[1]+"</td>"
            +"<td> "+dat[2]+" </td>"
            +"<td width='20'> <input type='number' name='cantidad[]' class='form-control' id='cant"+dat[0]+"' onblur='cantidad("+dat[0]+");' value='1'> </td>"
            +"<td> $"+dat[3]+" <input type='hidden' class='form-control' id='valor"+dat[0]+"' value='"+dat[3]+"'> </td>"
            +"<td>  <input type='hidden' id='tc"+dat[0]+"' value='"+(1*dat[3])+"'> <strong id ='total"+dat[0]+"'> $"+monedaChange(3,2,(1*dat[3]))+" </strong></td>"
            +"<td width='20' id='delete"+dat[0]+"'> <button type='button' class='btn btn-danger btn-sm' onclick='borraFila("+dat[0]+");'> <i class='fa fa-window-close' aria-hidden='true'></i> </button> </td> </tr>";
            $('#tableProducto-content').append(table);
            total = total+(1*dat[3]);
            temp=" | "+dat[0];
            comprobacion= comprobacion + temp;
          }
          $('#total').val(total);
          $('#tf').val("$"+monedaChange(3,2,total));
          $('#barras').val('');
        }

      }
  });

}

function cantidad(val){
  var tc = parseFloat($('#tc'+val).val());
  var total = parseFloat($('#total').val());
  total = total - tc;
  var cant = $('#cant'+val).val();
  var valor = $('#valor'+val).val();
  var totalF = valor*cant;
  $('#tc'+val).val(totalF);
  total = total + totalF;
  $('#total').val(total);
  $('#tf').val("$"+monedaChange(3,2,total));

  $('#total'+val).html('$'+monedaChange(3,2,totalF));
}

function borraFila(del){
  var tc = parseFloat($('#tc'+del).val());
  var total = parseFloat($('#total').val());
  total = total - tc;

  $('#total').val(total);
  $('#tf').val("$"+monedaChange(3,2,total));

  $('#delete'+del).closest('tr').remove();
  comprobacion = comprobacion.replace(del,"");
}


function monedaChange (cif = 3, dec = 2, val) {
  // tomamos el valor que tiene el input
  let inputNum = val
  // Lo convertimos en texto
  inputNum = inputNum.toString()
  // separamos en un array los valores antes y después del punto
  inputNum = inputNum.split('.')
  // evaluamos si existen decimales
  if (!inputNum[1]) {
    inputNum[1] = '00'
  }

  let separados
  // se calcula la longitud de la cadena
  if (inputNum[0].length > cif) {
    let uno = inputNum[0].length % cif
    if (uno === 0) {
      separados = []
    } else {
      separados = [inputNum[0].substring(0, uno)]
    }
    let posiciones = parseInt(inputNum[0].length / cif)
    for (let i = 0; i < posiciones; i++) {
      let pos = ((i * cif) + uno)
      // console.log(uno, pos)
      separados.push(inputNum[0].substring(pos, (pos + 3)))
    }
  } else {
    separados = [inputNum[0]]
  }

  return separados.join(',') + '.' + inputNum[1];
}

function Devolucion(){
  var total = parseFloat($('#total').val());
  var inge = parseFloat($('#ingreso').val());
  total = inge - total;

  if($('#ingreso').val() == '' || $('#ingreso').val() == null){total = 0;}

  $('#cambio').val('$'+monedaChange(3,2,total));
}

function Table() {
  $('#table').DataTable(
    {
      "ordering": false,
      "paging":false,
      "searching": true,
      language: {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     ">",
            "sPrevious": "<"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
          "buttons": {
              "copyTitle": 'Informacion copiada',
              "copyKeys": 'Use your keyboard or menu to select the copy command',
              "copySuccess": {
                  "_": '%d filas copiadas al portapapeles',
                  "1": '1 fila copiada al portapapeles'
              },

              "pageLength": {
                  "_": "Mostrar %d filas",
                  "-1": "Mostrar Todo"
              }
          }
      }
  });
}
