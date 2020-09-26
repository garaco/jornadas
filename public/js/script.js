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

function img(){
  function archivo(evt) {
      var files = evt.target.files; // FileList object

      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
              // Insertamos la imagen
             document.getElementById("list").innerHTML = ['<img class="thumb" width="160" height="160" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f);

        reader.readAsDataURL(f);
      }
  }

  document.getElementById('files').addEventListener('change', archivo, false);
}

$('#select').on('change', function(){
  var val = $('#select').val();
  var datos = val.split("|");

  if(datos[0]==0){
    $('#send').attr("disabled", true);
    $('#Nombre').val('');
    $('#RazonSocial').val('');
    $('#Rfc').val('');
    document.getElementById("list").innerHTML ='<img src="'+datos[4]+'" class="thumb" width="180" height="180">';
  }else{
    $('#Nombre').val(datos[1]);
    $('#RazonSocial').val(datos[2]);
    $('#Rfc').val(datos[3]);
    document.getElementById("list").innerHTML = '<img src="'+datos[4]+'" class="thumb" width="180" height="180">';
    $('#send').attr("disabled", false);
  }

});

  if($('#data-model').val() == "informe"){
    var datos = $('#datos').val();
    datos = datos.split(',');

    var data = [
    {
      x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      y: datos ,
      type: 'bar',
    }
    ];

    Plotly.newPlot('grafico', data);
  }
