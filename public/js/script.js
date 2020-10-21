$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    $('.user').toggleClass("user-show");

});

$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple || false;
        var link = this.el.find('.link');
        link.on('click', { el: this.el, multiple: this.multiple }, this.dropdown);

    }
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el,
            $this = $(this),
            $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');
        if (!this.multiple) {
            $el.find('.sidebar-submenu').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('.sidebar-nav'));
});


$(document).ready(function() {
    $('#table').DataTable(
      {
        "pagingType": "full_numbers",
        "ordering": false,
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
        },
        responsive:'true',
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Mostrar Todo"]],
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>> <'row'<'col-sm-12'tr>> <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: {
          dom: {
            container: {
                tag: 'div',
                className: 'flexcontent'
            },
            buttonLiner: {
                tag: null
            }
          },
          buttons:[
      			{
      				extend:    'excelHtml5',
      				text:      '<i class="fa fa-file-excel-o"></i> ',
      				titleAttr: 'Exportar a Excel',
      				className: 'btn btn-success scale'
      			},
      			{
      				extend:    'pdfHtml5',
      				text:      '<i class="fa fa-file-pdf-o"></i> ',
      				titleAttr: 'Exportar a PDF',
      				className: 'btn btn-danger scale',
              customize:function(doc) {
                doc.styles.title = {
                    color: '#004fff',
                    fontSize: '15',
                    alignment: 'center'
                },
                doc.styles['td:nth-child(2)'] = {
                    width: '100px',
                    'max-width': '100px'
                },
                doc.styles.tableHeader = {
                    fillColor:'#0094ff',
                    color:'white',
                    alignment:'center'
                },
                doc.content[1].margin = [ 2, 0, 2, 0 ]
              }
      			},
            {
              extend: 'pageLength',
              titleAttr: 'Registros a mostrar',
              className: 'selectTable'
            }
    		]
      }
    });
});

function dias(){
  let id = $("#empleado").val();

  $.ajax({
      url: 'jornadas_dias',
      type: 'POST',
      data: {
          id: id,
      },
      success: function (data) {
        $('#dia option').remove();
        $("#dia").prepend(data)
      }
  });
}

function horarios(){
  let id = $("#empleado").val();
  let dia = $("#dia").val();
  let dato;

  $.ajax({
      url: 'jornadas_horas',
      type: 'POST',
      data: {
          id: id,
          dia:dia
      },
      success: function (data) {
        dato = data.split("|");
        $("#enrada").val(dato[0]);
        $("#salida").val(dato[1]);
        $("#inicio_extra").val(dato[1]);
      }
  });
}

function calculo(){
  let id = $("#empleado").val();
  let inicio = $("#inicio_extra").val();
  let salida = $("#final_extra").val();
  var datos;

  $.ajax({
      url: 'jornadas_horas_extras',
      type: 'POST',
      data: {
          id: id,
          salida:salida,
          inicio:inicio
      },
      success: function (data) {
        $("#horas").val(data);
        $
      }
  });
}
