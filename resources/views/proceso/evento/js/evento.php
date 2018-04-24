<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var EventoG={id:0,evento_tipo_id:0,persona_contrato_id:0,evento_descripcion:"",
    fecha_inicio:"",fecha_fin:"",hora_inicio:"",hora_fin:"",estado:1}; // Datos Globales

$(document).ready(function() {
    $('[data-mask]').inputmask("hh:mm", {
        placeholder: "HH:MM", 
        insertMode: false, 
        showMaskOnHover: false,
        hourFormat: 24
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
    
    $("#TableEvento").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

//    AjaxEvento.Cargar(HTMLCargarEvento);
    AjaxEvento.CargarEventoTipo(SlctCargarEventoTipo);
    
    $("#EventoForm #TableEvento select").change(function(){ AjaxEvento.Cargar(HTMLCargarEvento); });
    $("#EventoForm #TableEvento input").blur(function(){ AjaxEvento.Cargar(HTMLCargarEvento); });

});

ValidaForm=function(){
    var r=true; 
    if(  $.trim( $("#ModalEventoForm #txt_fecha_inicio").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha de Inicio',4000);
    }
    else if( $.trim( $("#ModalEventoForm #txt_fecha_fin").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha de Fin',4000);
    }
    else if(  $.trim( $("#ModalEventoForm #txt_hora_inicio").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Hora de Inicio',4000);
    }
    else if( $.trim( $("#ModalEventoForm #txt_hora_fin").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Hora de Fin',4000);
    }
    else if( $.trim( $("#ModalEventoForm #txt_evento_descripcion").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Evento Descripción',4000);
    }    
    else if( $.trim( $("#ModalEventoForm #slct_evento_tipo_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Evento Tipo',4000);
    }
    else if( $.trim( $("#ModalEventoForm #txt_fecha_inicio").val() )>$.trim( $("#ModalEventoForm #txt_fecha_fin").val() )){
        r=false;
        msjG.mensaje('warning','Fecha de Inicio debe ser menor a Fecha Final',4000);
    }
    else if($.trim( $("#ModalEventoForm #txt_fecha_inicio").val() )==$.trim( $("#ModalEventoForm #txt_fecha_fin").val() )){
        if( $.trim( $("#ModalEventoForm #txt_hora_inicio").val() )>$.trim( $("#ModalEventoForm #txt_hora_fin").val() )){
            r=false;
            msjG.mensaje('warning','Hora de Inicio debe ser menor a Hora Final',4000);
        }
    }

    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    $("#Evento").css("display","");
    $("#btn_guardar_evento").show();
    
    $('#ModalEventoForm #slct_evento_tipo_id').prop("disabled",false);
    $('#ModalEventoForm #txt_evento_descripcion').prop("disabled",false);
    $('#ModalEventoForm #txt_hora_inicio').prop("disabled",false);
    $('#ModalEventoForm #txt_hora_fin').prop("disabled",false);
    
    EventoG.id='';
    EventoG.persona_contrato_id=$("#txt_persona_contrato_id").val();
    EventoG.evento_tipo_id='0';
    EventoG.evento_descripcion='';
    EventoG.fecha_inicio='';
    EventoG.fecha_fin="";
    EventoG.hora_inicio="";
    EventoG.hora_fin="";
    EventoG.estado=1;
    
    if( val==0 ){
        $("#Evento").css("display","");
        $("#btn_guardar_evento").hide();
        
        $('#ModalEventoForm #slct_evento_tipo_id').prop("disabled",true);
        $('#ModalEventoForm #txt_evento_descripcion').prop("disabled",true);
        $('#ModalEventoForm #txt_hora_inicio').prop("disabled",true);
        $('#ModalEventoForm #txt_hora_fin').prop("disabled",true);
          
        EventoG.id=id;
        EventoG.persona_contrato_id=$("#TableEvento #trid_"+id+" .persona_contrato_id").val();
        EventoG.evento_tipo_id=$("#TableEvento #trid_"+id+" .evento_tipo_id").val();
        EventoG.evento_descripcion=$("#TableEvento #trid_"+id+" .evento_descripcion").val();
        EventoG.fecha_inicio=$("#TableEvento #trid_"+id+" .fecha_inicio").val();
        EventoG.fecha_fin=$("#TableEvento #trid_"+id+" .fecha_fin").val();
        EventoG.hora_inicio=$("#TableEvento #trid_"+id+" .hora_inicio").val();
        EventoG.hora_fin=$("#TableEvento #trid_"+id+" .hora_fin").val();
        EventoG.estado=1;
    }
    LlenarAgregarEditar();
    $("html, body").animate({scrollTop:$(document).height()+"px"});

}

LlenarAgregarEditar=function(){
        if( AddEdit==1 ){        
//            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
//            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalEventoForm").append("<input type='hidden' value='"+EventoG.id+"' name='id'>");
        }
        $('#ModalEventoForm #txt_persona_contrato_id').val( EventoG.persona_contrato_id );
        $('#ModalEventoForm #slct_evento_tipo_id').selectpicker('val', EventoG.evento_tipo_id );
        $('#ModalEventoForm #txt_evento_descripcion').val(EventoG.evento_descripcion );
        $('#ModalEventoForm #txt_fecha_inicio').val(EventoG.fecha_inicio );
        $('#ModalEventoForm #txt_fecha_fin').val(EventoG.fecha_fin );
        $('#ModalEventoForm #txt_hora_inicio').val(EventoG.hora_inicio );
        $('#ModalEventoForm #txt_hora_fin').val(EventoG.hora_fin );
        $('#ModalEventoForm #txt_estado').val(EventoG.estado );
          
}

CambiarEstado=function(estado,id){
    sweetalertG.confirm("¿Estás seguro?", "Confirme la eliminación", function(){
        AjaxEvento.CambiarEstado(HTMLCambiarEstado,estado,id);
    });
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxEvento.Cargar(HTMLCargarEvento);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxEvento.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxEvento.Cargar(HTMLCargarEvento);
        AgregarEditar(1);
        AddEdit=1;
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarEvento=function(result){
    var html="";
    $('#TableEvento').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='';
        if(r.estado==1 && r.evento_asistencia_id==null){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-lg"></i></span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='evento_tipo'>"+r.evento_tipo+"</td>"+
            "<td class='fecha_hora_inicio'>"+r.fecha_inicio+" "+r.hora_inicio+"</td>"+
            "<td class='fecha_hora_fin'>"+r.fecha_fin+" "+r.hora_fin+"</td>"+
            "<td>"+
            "<input type='hidden' class='evento_descripcion' value='"+r.evento_descripcion+"'>"+
            "<input type='hidden' class='evento_tipo_id' value='"+r.evento_tipo_id+"'>"+
            "<input type='hidden' class='persona_contrato_id' value='"+r.persona_contrato_id+"'>"+
            "<input type='hidden' class='fecha_inicio' value='"+r.fecha_inicio+"'>"+
            "<input type='hidden' class='fecha_fin' value='"+r.fecha_fin+"'>"+
            "<input type='hidden' class='hora_inicio' value='"+r.hora_inicio+"'>"+
            "<input type='hidden' class='hora_fin' value='"+r.hora_fin+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td><td>"+
            '<a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableEvento tbody").html(html); 
    $("#TableEvento").DataTable({
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
            $('#TableEvento_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarEvento','AjaxEvento',result.data,'#TableEvento_paginate');
        }
    });

};

SlctCargarEventoTipo=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.evento_tipo+"</option>";
    });
    $("#ModalEventoForm #slct_evento_tipo_id").html(html); 
    $("#ModalEventoForm #slct_evento_tipo_id").selectpicker('refresh');

};

</script>
