<script type="text/javascript">
var LTtextoIdPersona='';
var LTtextoPersona='';
var LTtextoDNI='';
var LPfiltrosG='';
var LTvalorIdPersona='';
var LTEpersona=1;
var LTBuscarEvento=0;
var LDValidarPersona=0;
$(document).ready(function() {
    $("#TableListapersona").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
   
    $("#ListapersonaForm #TableListapersona select").change(function(){ AjaxListapersona.Cargar(HTMLCargarListaPersona); });
    $("#ListapersonaForm #TableListapersona input").blur(function(){ AjaxListapersona.Cargar(HTMLCargarListaPersona); });

    $('#ModalListapersona').on('shown.bs.modal', function (event) {
        
      var button = $(event.relatedTarget); // captura al boton
      bfiltros= button.data('filtros');
      if( typeof (bfiltros)!='undefined'){
          LPfiltrosG=bfiltros;
      }
      
      if( typeof (button.data('epersona'))!='undefined'){
           LTEpersona=0;
      }
      if( typeof (button.data('buscarevento'))!='undefined'){
           LTBuscarEvento=button.data('buscarevento');  
      }
      if( typeof (button.data('validarpersona'))!='undefined'){
           LDValidarPersona=button.data('validarpersona');  
      }
      
      AjaxListapersona.Cargar(HTMLCargarListaPersona);

      LTtextoIdPersona= button.data('personaid');
      LTtextoPersona= button.data('persona');
      LTtextoDNI= button.data('dni');

    });

    $('#ModalListapersona').on('hidden.bs.modal', function (event) {
        LPfiltrosG='';
        if(LDValidarPersona==1){
                if(LTvalorIdPersona==''){
                }
                else if($("#ModalMatriculaForm #txt_persona_id").val()!=LTvalorIdPersona){
                   $('#ModalMatriculaForm #tb_matricula, #ModalMatriculaForm #tb_pago').html('');
                }
                LTvalorIdPersona='';
                LDValidarPersona='';
            }

    });
});

SeleccionarPersona = function(val,id){
    LTvalorIdPersona=$("#"+LTtextoIdPersona).val();
    $("#"+LTtextoPersona).val('');
    $("#"+LTtextoIdPersona).val('');
    $("#"+LTtextoDNI).val('');
    
    if( val==0 ){
        var paterno=$("#TableListapersona #trid_"+id+" .paterno").text();
        var materno=$("#TableListapersona #trid_"+id+" .materno").text();
        var nombre=$("#TableListapersona #trid_"+id+" .nombre").text();
        var dni=$("#TableListapersona #trid_"+id+" .dni").text();
        $("#"+LTtextoPersona).val(paterno+" "+materno+" "+nombre);
        $("#"+LTtextoIdPersona).val(id); // persona_contrato_id
        $("#"+LTtextoDNI).val(dni);
        if(LTBuscarEvento==1){
            $("#div_horario_programado").hide();
            AjaxDato.Cargar(HTMLCargarDatos);
            $("#btn_nuevo").show();

            $("#div_horario_plantilla").fadeOut('slow');
        }
        
        $('#ModalListapersona').modal('hide');
    }
    };
 
    
    
HTMLCargarListaPersona=function(result){
    var html="";
    $('#TableListapersona').DataTable().destroy();

    $.each(result.data.data,function(index,r){

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='paterno'>"+r.paterno+"</td>"+
            "<td class='materno'>"+r.materno+"</td>"+
            "<td class='nombre'>"+r.nombre+"</td>"+
            "<td class='dni'>"+r.dni+"</td>"+
           '<td><span class="btn btn-primary btn-sm" onClick="SeleccionarPersona(0,'+r.id+')"+><i class="glyphicon glyphicon-ok"></i></span>'+
            "</td>"+
            '<td>';
            if(LTEpersona==1){
                 html+='<a class="btn btn-primary btn-sm" onClick="AgregarEditar2(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a>';
            }
        html+='</td>';

        html+="</tr>";
    });
    $("#TableListapersona tbody").html(html); 
    $("#TableListapersona").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "lengthMenu": [10],
        "language": {
            "info": "Mostrando página "+result.data.current_page+" / "+result.data.last_page+" de "+result.data.total,
            "infoEmpty": "No éxite registro(s) aún",
        },
        "initComplete": function () {
            $('#TableListapersona_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarListaPersona','AjaxListapersona',result.data,'#TableListapersona_paginate');
        } 
    });
};
</script>
