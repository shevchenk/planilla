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
    
    $.each(result.data,function(index,r){
        html+="<tr id='trid_"+r.id+"'>"+
            "<td>"+r.sede+"</td>"+
            "<td>"+r.consorcio+"</td>"+
            "<td>"+r.persona+"</td>"+
            "<td>"+r.dni+"</td>";
        for(i=0;i<result.cabecera.length;i++){
            html+="<td>"+r['pa'+i]+"</td>";
        }
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

</script>
