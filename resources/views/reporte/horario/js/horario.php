<script type="text/javascript">
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
    
    $("#ListaEventoForm #TableListaevento select").change(function(){ AjaxHorario.CargarEvento(HTMLCargarListaEvento); });
    $("#ListaEventoForm #TableListaevento input").blur(function(){ AjaxHorario.CargarEvento(HTMLCargarListaEvento); });

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
        html+="<td onClick='DetalleAsistencia(null,"+r.id+")'>"+r.pat+"</td>";
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

    $.each(result.data.data,function(index,r){

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='fecha_ingreso'>"+$.trim(r.fecha_ingreso)+"</td>"+
            "<td class='hora_ingreso'>"+$.trim(r.hora_ingreso)+"</td>"+
            "<td class='fecha_salida'>"+$.trim(r.fecha_salida)+"</td>"+
            "<td class='hora_salida'>"+$.trim(r.hora_salida)+"</td>"+
           '<td>';
        if(r.evento_asistencia_id!=null){
           html+='<span class="btn btn-primary btn-sm" onClick="DetalleEvento('+r.id+')"+><i class="fa fa-search fa-lg"></i></span>';
        }
        html+='</td>';

        html+="</tr>";
    });
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
};

DetalleEvento=function(asistencia_id){
    $("#ListaEventoForm #txt_asistencia_id").val(asistencia_id);
    AjaxHorario.CargarEvento(HTMLCargarListaEvento);
    $('#ModalListaEvento').modal('show');
};

HTMLCargarListaEvento=function(result){
    var html="";
    $('#TableListaevento').DataTable().destroy();

    $.each(result.data.data,function(index,r){

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='fecha_inicio'>"+$.trim(r.fecha_inicio)+"</td>"+
            "<td class='hora_inicio'>"+$.trim(r.hora_inicio)+"</td>"+
            "<td class='fecha_fin'>"+$.trim(r.fecha_fin)+"</td>"+
            "<td class='hora_fin'>"+$.trim(r.hora_fin)+"</td>"+
            "<td class='evento_descripcion'>"+$.trim(r.evento_descripcion)+"</td>"+
            "<td class='evento_tipo'>"+$.trim(r.evento_tipo)+"</td>"+
            "<td class='aplica_cambio'>"+$.trim(r.aplica_cambio)+"</td>";

        html+="</tr>";
    });
    $("#TableListaevento tbody").html(html); 
    $("#TableListaevento").DataTable({
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
            $('#TableListaevento_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarListaAsistencia','AjaxHorario',result.data,'#TableListaevento_paginate');
        } 
    });
};
</script>
