<script type="text/javascript">
var AddEdit=1;
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
    
    $("#TableListaasistencia").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    AjaxHorario.CargarSede(SlctCargarSede);
    AjaxHorario.CargarConsorcio(SlctCargarConsorcio);
    
    $('#spn_fecha_ini').on('click', function(){
        $('#txt_fecha_inicio').focus();
    });
    $('#spn_fecha_fin').on('click', function(){
        $('#txt_fecha_final').focus();
    });
    
    function DataToFilter(){
        var fecha_inicio = $('#txt_fecha_inicio').val();
        var fecha_final = $('#txt_fecha_final').val();
        var sede_id = $('#slct_sede_id').val();
        var consorcio_id = $('#slct_consorcio_id').val();
        var data = [];
        if ( fecha_inicio!=="" && fecha_final!=="") {
            data.push({fecha_inicio:fecha_inicio,fecha_final:fecha_final,sede_id:sede_id,consorcio_id:consorcio_id});
           
        } else {
            alert("Seleccione Fechas");
        }
        return data;
    }
    
    $("#btn_generar").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            AjaxHorario.Cargar(data[0],HTMLCargarHorario);         
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            $(this).attr('href','ReportDinamic/Horario.TramiteEM@Export'+'?fecha_inicio='+data[0]['fecha_inicio']+'&fecha_final='+data[0]['fecha_final']);
        }else{
            event.preventDefault();
        }
    });
    
    $("#ListaAsistenciaForm #TableListaasistencia select").change(function(){ AjaxHorario.CargarAsistencia(HTMLCargarListaAsistencia); });
    $("#ListaAsistenciaForm #TableListaasistencia input").blur(function(){ AjaxHorario.CargarAsistencia(HTMLCargarListaAsistencia); });
});


HTMLCargarHorario=function(result){
    var html="";
    var cabecera="<th style='width: 200px !important;'>Sede</th>"+
                 "<th style='width: 200px !important;'>Consorcio</th>"+
                 "<th style='width: 200px !important;'>Persona</th>"+
                 "<th style='width: 200px !important;'>DNI</th>";
         
    $('#TableHorario').DataTable().destroy();
    
    for(i=0;i<result.cabecera.length;i++){
        cabecera+="<th>"+result.cabecera[i]+"</th>";
    }
    cabecera+="<th>Toral Días</th>";
    $.each(result.data,function(index,r){
        html+="<tr id='trid_"+r.id+"'>"+
            "<td>"+r.sede+"</td>"+
            "<td>"+r.consorcio+"</td>"+
            "<td>"+r.persona+"</td>"+
            "<td>"+r.dni+"</td>";
        for(i=0;i<result.cabecera.length;i++){
            html+="<td onClick='DetalleAsistencia(\"" + result.cabecera[i] + "\","+r.id+")'>"+r['pa'+i]+"</td>";
        }
//        html+="<td onClick='DetalleAsistencia(null,"+r.id+")'>"+r.pat+"</td>";
        html+="<td>"+r.pat+"</td>";
        html+="</tr>";
    });
    $("#TableHorario tbody").html(html); 
    $("#TableHorario thead tr").html(cabecera); 
    $("#TableHorario tfoot tr").html(cabecera); 
    $("#TableHorario").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });
    $("#TableHorario").css("display",""); 
};
SlctCargarSede=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.sede+"</option>";
    });
    $("#HorarioForm #slct_sede_id").html(html); 
    $("#HorarioForm #slct_sede_id").selectpicker('refresh');

};

SlctCargarConsorcio=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.consorcio+"</option>";
    });
    $("#HorarioForm #slct_consorcio_id").html(html); 
    $("#HorarioForm #slct_consorcio_id").selectpicker('refresh');

};

DetalleAsistencia=function(fecha,persona_contrato_id=null){
    $("#ListaAsistenciaForm #txt_fecha").val(fecha);
    $("#ListaAsistenciaForm #txt_persona_contrato_id").val(persona_contrato_id);
    AjaxHorario.CargarAsistencia(HTMLCargarListaAsistencia);
    $('#ModalListaAsistencia').modal('show');
};

HTMLCargarListaAsistencia=function(result){
    var html="";
    $('#TableListaasistencia').DataTable().destroy();
    
    if(result.data.data==0 && $.trim($("#ListaAsistenciaForm #txt_fecha").val())!=''){
        html+="<tr>"+
        "<td class='fecha_ingreso'><input type='text' class='form-control fecha' id='txt_fecha_ingreso_0' value='' readonly></td>"+
        "<td class='hora_ingreso'><input type='numeric' class='form-control' id='txt_hora_ingreso_0' data-mask='' value=''></td>"+
        "<td class='fecha_salida'><input type='text' class='form-control fecha' id='txt_fecha_salida_0' value='' readonly></td>"+
        "<td class='hora_salida'><input type='numeric' class='form-control' id='txt_hora_salida_0' data-mask='' value=''></td>"+
       '<td>';
       html+='<span class="btn btn-primary btn-sm" onClick="AgregarEditar(0,0)"+><i class="fa fa-save fa-lg"></i></span>';
       html+='</td>';
       html+="</tr>";
    }else{
        $.each(result.data.data,function(index,r){
            if($.trim($("#ListaAsistenciaForm #txt_fecha").val())!=''){
                html+="<tr id='trid_"+r.id+"'>"+
                "<td class='fecha_ingreso'><input type='text' class='form-control fecha' id='txt_fecha_ingreso_"+index+"' value='"+$.trim(r.fecha_ingreso)+"' readonly></td>"+
                "<td class='hora_ingreso'><input type='numeric' class='form-control' id='txt_hora_ingreso_"+index+"' data-mask='' value='"+$.trim(r.hora_ingreso)+"'></td>"+
                "<td class='fecha_salida'><input type='text' class='form-control fecha' id='txt_fecha_salida_"+index+"' value='"+$.trim(r.fecha_salida)+"' readonly></td>"+
                "<td class='hora_salida'><input type='numeric' class='form-control' id='txt_hora_salida_"+index+"' data-mask='' value='"+$.trim(r.hora_salida)+"'></td>"+
               '<td>';
                html+='<span class="btn btn-primary btn-sm" onClick="AgregarEditar('+index+','+r.id+')"+><i class="fa fa-edit fa-lg"></i></span>';
                html+='</td>';
                html+="</tr>";
            }
        });
    }

    $("#TableListaasistencia tbody").html(html); 
    $("#TableListaasistencia").DataTable({
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
            $('#TableListaasistencia_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarListaAsistencia','AjaxHorario',result.data,'#TableListaasistencia_paginate');
        } 
    });
    
    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: true,
        time:true,
        minView:2,
        autoclose: true,
        todayBtn: false
    });
    
    $('[data-mask]').inputmask("hh:mm", {
        placeholder: "HH:MM", 
        insertMode: false, 
        showMaskOnHover: false,
        hourFormat: 24
    });
};

AgregarEditar=function(index,id){
    if(id==0){AddEdit=1;}else{ AddEdit=0;}
    var persona_contrato_id=$("#ListaAsistenciaForm #txt_persona_contrato_id").val();
    var fecha_ingreso=$("#TableListaasistencia tbody #txt_fecha_ingreso_"+index).val();
    var fecha_salida=$("#TableListaasistencia tbody #txt_fecha_salida_"+index).val();
    var hora_ingreso=$("#TableListaasistencia tbody #txt_hora_ingreso_"+index).val();
    var hora_salida=$("#TableListaasistencia tbody #txt_hora_salida_"+index).val();

    var dataG={persona_contrato_id:persona_contrato_id,id:id,fecha_ingreso:fecha_ingreso,fecha_salida:fecha_salida,hora_ingreso:hora_ingreso,hora_salida:hora_salida};
    AjaxHorario.AgregarEditar(HTMLAgregarEditar,dataG);
};

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AddEdit=1;
        $('#ModalListaAsistencia').modal('hide');
        $("#btn_generar").click();
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}
</script>
