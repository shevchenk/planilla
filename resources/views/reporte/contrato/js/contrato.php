<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ContratoG={id:0,persona_id:0,persona:"",sede_id:0,consorcio_id:0,cargo_id:0,regimen_id:0
    ,estado_contrato:0,tipo_contrato:0,fecha_ini_contrato:"",fecha_fin_contrato:"",sueldo_mensual:0,
    sueldo_produccion:0,asignacion_familiar:0,estado:1}; // Datos Globales

$(document).ready(function() {
    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: true,
        time:true,
        minView:2,
        autoclose: true,
        todayBtn: false
    });
    
    $("#TableContrato").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    AjaxContrato.Cargar(HTMLCargarContrato);
    
    $("#ContratoForm #TableContrato select").change(function(){ AjaxContrato.Cargar(HTMLCargarContrato); });
    $("#ContratoForm #TableContrato input").blur(function(){ AjaxContrato.Cargar(HTMLCargarContrato); });
    
    $( "#ModalContratoForm #slct_cargo_id" ).change(function() {
            var cargo_id= $('#ModalContratoForm #slct_cargo_id').val();
            AjaxContrato.CargarSueldoCargo(SlctCargarSueldoCargo,cargo_id);
    });
    
});



loadDetail=function(ID){

    $("#lbl_sede").text(contratoDetalle[ID].sede);
    $("#lbl_consorcio").text(contratoDetalle[ID].consorcio);
    $("#lbl_cargo").text(contratoDetalle[ID].cargo);
    $("#lbl_regimen").text(contratoDetalle[ID].regimen);
    $("#lbl_estado").text(contratoDetalle[ID].estado);
    $("#lbl_fecha_ini_contrato").text(contratoDetalle[ID].fecha_ini_contrato);
    $("#lbl_fecha_fin_contrato").text(contratoDetalle[ID].fecha_fin_contrato);

    $("#lbl_tipo").text(contratoDetalle[ID].tipo);
    $("#lbl_asignacion_familiar").text(contratoDetalle[ID].asignacion_familiar);
    $("#lbl_sueldo_mensual").text(contratoDetalle[ID].sueldo_mensual);
    $("#lbl_sueldo_produccion").text(contratoDetalle[ID].sueldo_produccion);
    $("#lbl_nombre").text(contratoDetalle[ID].nombre);
    $("#lbl_dni").text(contratoDetalle[ID].dni);

    $("#modalContratoDetalle").modal();
}


var contratoDetalle = [];
ListContratos=function(idPersona){
    
    $.post("AjaxDinamic/Reporte.Contrato@detalle",{persona:idPersona}, function(response){
        var cData = response.data;
        var mTable="";
        for (var i = cData.length - 1; i >= 0; i--) {
            var mEstado = (cData[i].estado==1?'Vigente':(cData[i].estado==2?'Vacaciones':(cData[i].estado==3?'Cesante':' <b>Desconocido</b> ')));
            mTable = mTable + '<tr onClick="loadDetail(\''+cData[i].id+'\')"><td>'+cData[i].sede+'</td><td>'+cData[i].consorcio+'</td><td>'+cData[i].cargo+'</td><td>'+cData[i].regimen+'</td><td>'+mEstado+'</td><td>'+cData[i].fecha_ini_contrato+'</td><td>'+cData[i].fecha_fin_contrato+'</td></tr>';

            contratoDetalle[cData[i].id] = {};

            contratoDetalle[cData[i].id].sede = cData[i].sede;
            contratoDetalle[cData[i].id].consorcio = cData[i].consorcio;
            contratoDetalle[cData[i].id].cargo = cData[i].cargo;
            contratoDetalle[cData[i].id].regimen = cData[i].regimen;
            contratoDetalle[cData[i].id].estado = cData[i].estado;
            contratoDetalle[cData[i].id].fecha_ini_contrato = cData[i].fecha_ini_contrato;
            contratoDetalle[cData[i].id].fecha_fin_contrato = cData[i].fecha_fin_contrato;
            contratoDetalle[cData[i].id].tipo = cData[i].tipo_contrato;
            contratoDetalle[cData[i].id].asignacion_familiar = cData[i].asignacion_familiar;
            contratoDetalle[cData[i].id].sueldo_mensual = cData[i].sueldo_mensual;
            contratoDetalle[cData[i].id].sueldo_produccion = cData[i].sueldo_produccion;
            contratoDetalle[cData[i].id].dni = cData[i].dni;
            contratoDetalle[cData[i].id].nombre = cData[i].nombre;
            contratoDetalle[cData[i].id].sexo = cData[i].sexo;

        }
        $("#historicoContratos").html(mTable);
        $("#listContratos").show();
    });
}

HTMLCargarContrato=function(result){
    var html="";
    $('#TableContrato').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='persona'>"+r.persona+"</td>"+
            "<td class='sede'>"+r.sede+"</td>"+
            "<td class='consorcio'>"+r.consorcio+"</td>"+
            "<td class='estado_contrato_nombre'>"+r.estado_contrato_nombre+"</td>"+
            "<td class='tipo_contrato_nombre'>"+r.tipo_contrato_nombre+"</td>"+
            "";
        html+="<td>"+
            '<a class="btn btn-primary btn-sm" onClick="ListContratos('+r.persona_id+')"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableContrato tbody").html(html); 
    $("#TableContrato").DataTable({
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
            $('#TableContrato_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarContrato','AjaxContrato',result.data,'#TableContrato_paginate');
        }
    });

};

</script>
