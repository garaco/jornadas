var url_request = window.location.protocol + "//" + window.location.host + "/jornadas/requested.php";
var spinner = '<td colspan="5" class="text-center"> <div class="spinner-border text-dark text-center"><span class="sr-only">Cargando...</span></div> </td>';
var ajaxError = '<i class="fa fa-warning text-warning"></i> Error al cargar los datos!';
var operation;

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
            modal.find('.modal-title').html('<h3 style="margin: 0">' + operation + ' registro</h3>');
            modal.find('.modal-body').html(spinner);
        },
        success: function (data) {
            modal.find('.modal-body').html(data);
        },
        error: function () {
            modal.find('.modal-body').html(ajaxError);
        }
    });
});

 $(document).on('submit', function (event) {
      var model = $('#data-model').val();
      (operation == 'Agregar' || operation == 'Editar') ?  operation='Guardado' : operation='Eliminado';

      if($('#form').attr('action')!=undefined){
        event.preventDefault();
        var data = new FormData(document.getElementById("form"));
        $.ajax({
          type: 'POST',
          url: $('#form').attr('action'),
          data: data,
          processData: false,
          contentType: false,
            success: function (respuesta) {
              $('#operationModal').modal('hide');
              Refresh(model);
              Swal.fire({
                width:'30%',
                padding:'0',
                position: 'center',
                icon: 'success',
                title: operation+' Correctamente',
                showConfirmButton: false,
                timer: 1500
              });

            }
        });
      }

});

function Refresh(model){
  $.ajax({
      url: url_request,
      type: 'POST',
      data: {
          function: 'Refresh',
          model:model
      },
      beforeSend: function () {
          $('#table-content').html(spinner);
      },
      success: function (data) {
          $('#table').dataTable().fnDestroy();
          $('#table-content').html(data);
          Table();
      },
      error: function () {
          $('#table-content').html(ajaxError);
      }
  });
}

  function data(id,type){
    alert('algo');
    // $.ajax({
    //     url: 'Visualiza',
    //     type: 'POST',
    //     data: {
    //         id: 'id,
    //         type:type
    //     }
    // });
  }

function Table() {
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
                }
                doc.styles['td:nth-child(2)'] = {
                    width: '100px',
                    'max-width': '100px'
                },
                doc.styles.tableHeader = {
                    fillColor:'#0094ff',
                    color:'white',
                    alignment:'center'
                },
                doc.content[1].margin = [ 100, 0, 100, 0 ]
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
}
