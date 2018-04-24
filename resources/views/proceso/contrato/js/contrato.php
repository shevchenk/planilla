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
    AjaxContrato.CargarSede(SlctCargarSede);
    AjaxContrato.CargarConsorcio(SlctCargarConsorcio);
    AjaxContrato.CargarRegimen(SlctCargarRegimen);
    AjaxContrato.CargarCargo(SlctCargarCargo);
    
    $("#ContratoForm #TableContrato select").change(function(){ AjaxContrato.Cargar(HTMLCargarContrato); });
    $("#ContratoForm #TableContrato input").blur(function(){ AjaxContrato.Cargar(HTMLCargarContrato); });
    
    $( "#ModalContratoForm #slct_cargo_id" ).change(function() {
            var cargo_id= $('#ModalContratoForm #slct_cargo_id').val();
            AjaxContrato.CargarSueldoCargo(SlctCargarSueldoCargo,cargo_id);
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalContratoForm #txt_persona").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione Persona',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_sede_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Sede',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_consorcio_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Consorcio',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_cargo_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Cargo',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_regimen_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Regimen',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_estado_contrato").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Estado de Contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_tipo_contrato").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_fecha_ini_contrato").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Inicial de contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_fecha_fin_contrato").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Final de contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_sueldo_mensual").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Sueldo Mensual',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_sueldo_produccion").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Sueldo Producción',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    $("#btn_buscar_persona").prop("disabled",false);
    $("#btn_buscar_persona").show();
    $("#Contrato").css("display","");
    ContratoG.id='';
    ContratoG.persona_id='';
    ContratoG.persona='';
    ContratoG.sede_id='0';
    ContratoG.consorcio_id='0';
    ContratoG.cargo_id="0";
    ContratoG.regimen_id="0";
    ContratoG.estado_contrato="0";
    ContratoG.tipo_contrato="0";
    ContratoG.fecha_ini_contrato="";
    ContratoG.fecha_fin_contrato="";
    ContratoG.sueldo_mensual="";
    ContratoG.sueldo_produccion="";
    ContratoG.asignacion_familiar="0";
    ContratoG.estado=1;
    
    if( val==0 ){
        $("#btn_buscar_persona").prop("disabled",true);
        $("#btn_buscar_persona").hide();
        $("#Contrato").css("display","");
        ContratoG.id=id;
        ContratoG.persona_id=$("#TableContrato #trid_"+id+" .persona_id").val();
        ContratoG.persona=$("#TableContrato #trid_"+id+" .persona").text();
        ContratoG.sede_id=$("#TableContrato #trid_"+id+" .sede_id").val();
        ContratoG.consorcio_id=$("#TableContrato #trid_"+id+" .consorcio_id").val();
        ContratoG.cargo_id=$("#TableContrato #trid_"+id+" .cargo_id").val();
        ContratoG.regimen_id=$("#TableContrato #trid_"+id+" .regimen_id").val();
        ContratoG.estado_contrato=$("#TableContrato #trid_"+id+" .estado_contrato").val();
        ContratoG.tipo_contrato=$("#TableContrato #trid_"+id+" .tipo_contrato").val();
        ContratoG.fecha_ini_contrato=$("#TableContrato #trid_"+id+" .fecha_ini_contrato").val();
        ContratoG.fecha_fin_contrato=$("#TableContrato #trid_"+id+" .fecha_fin_contrato").val();
        ContratoG.sueldo_mensual=$("#TableContrato #trid_"+id+" .sueldo_mensual").val();
        ContratoG.sueldo_produccion=$("#TableContrato #trid_"+id+" .sueldo_produccion").val();
        ContratoG.asignacion_familiar=$("#TableContrato #trid_"+id+" .asignacion_familiar").val();
        ContratoG.estado=1;
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
            $("#ModalContratoForm").append("<input type='hidden' value='"+ContratoG.id+"' name='id'>");
        }
        $('#ModalContratoForm #txt_persona').val( ContratoG.persona );
        $('#ModalContratoForm #txt_persona_id').val( ContratoG.persona_id );
        $('#ModalContratoForm #slct_sede_id').selectpicker('val', ContratoG.sede_id );
        $('#ModalContratoForm #slct_consorcio_id').selectpicker('val', ContratoG.consorcio_id );
        $('#ModalContratoForm #slct_cargo_id').selectpicker('val', ContratoG.cargo_id );
        $('#ModalContratoForm #slct_regimen_id').selectpicker('val', ContratoG.regimen_id );
        $('#ModalContratoForm #slct_estado_contrato').selectpicker('val', ContratoG.estado_contrato );
        $('#ModalContratoForm #slct_tipo_contrato').selectpicker('val', ContratoG.tipo_contrato );
        $('#ModalContratoForm #txt_fecha_ini_contrato').val(ContratoG.fecha_ini_contrato );
        $('#ModalContratoForm #txt_fecha_fin_contrato').val(ContratoG.fecha_fin_contrato );
        $('#ModalContratoForm #txt_sueldo_mensual').val(ContratoG.sueldo_mensual );
        $('#ModalContratoForm #txt_sueldo_produccion').val(ContratoG.sueldo_produccion );
        $('#ModalContratoForm #slct_asignacion_familiar').selectpicker('val',ContratoG.asignacion_familiar);
        $('#ModalContratoForm #txt_estado').val(ContratoG.estado );
        $('#ModalContratoForm #txt_persona').focus();
        
        
}

CambiarEstado=function(estado,id){
    sweetalertG.confirm("¿Estás seguro?", "Confirme la eliminación", function(){
        AjaxContrato.CambiarEstado(HTMLCambiarEstado,estado,id);
    });
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxContrato.Cargar(HTMLCargarContrato);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxContrato.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxContrato.Cargar(HTMLCargarContrato);
        $("#btn_buscar_persona").prop("disabled",true);
        $("#btn_buscar_persona").hide();
        AddEdit=0;
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarContrato=function(result){
    var html="";
    $('#TableContrato').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-lg"></i></span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='persona'>"+r.persona+"</td>"+
            "<td class='sede'>"+r.sede+"</td>"+
            "<td class='consorcio'>"+r.consorcio+"</td>"+
            "<td class='estado_contrato_nombre'>"+r.estado_contrato_nombre+"</td>"+
            "<td class='tipo_contrato_nombre'>"+r.tipo_contrato_nombre+"</td>"+
            "<td>"+
            "<input type='hidden' class='persona_id' value='"+r.persona_id+"'>"+
            "<input type='hidden' class='sede_id' value='"+r.sede_id+"'>"+
            "<input type='hidden' class='consorcio_id' value='"+r.consorcio_id+"'>"+
            "<input type='hidden' class='cargo_id' value='"+r.cargo_id+"'>"+
            "<input type='hidden' class='regimen_id' value='"+r.regimen_id+"'>"+
            "<input type='hidden' class='estado_contrato' value='"+r.estado_contrato+"'>"+
            "<input type='hidden' class='tipo_contrato' value='"+r.tipo_contrato+"'>"+
            "<input type='hidden' class='fecha_ini_contrato' value='"+r.fecha_ini_contrato+"'>"+
            "<input type='hidden' class='fecha_fin_contrato' value='"+r.fecha_fin_contrato+"'>"+
            "<input type='hidden' class='sueldo_mensual' value='"+r.sueldo_mensual+"'>"+
            "<input type='hidden' class='sueldo_produccion' value='"+r.sueldo_produccion+"'>"+
            "<input type='hidden' class='asignacion_familiar' value='"+r.asignacion_familiar+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td><td>"+
            '<a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
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

SlctCargarSede=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.sede+"</option>";
    });
    $("#ModalContratoForm #slct_sede_id").html(html); 
    $("#ModalContratoForm #slct_sede_id").selectpicker('refresh');

};

SlctCargarConsorcio=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.consorcio+"</option>";
    });
    $("#ModalContratoForm #slct_consorcio_id").html(html); 
    $("#ModalContratoForm #slct_consorcio_id").selectpicker('refresh');

};

SlctCargarCargo=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.cargo+"</option>";
    });
    $("#ModalContratoForm #slct_cargo_id").html(html); 
    $("#ModalContratoForm #slct_cargo_id").selectpicker('refresh');

};

SlctCargarRegimen=function(result){
    var html="<option value='0'>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.regimen+"</option>";
    });
    $("#ModalContratoForm #slct_regimen_id").html(html); 
    $("#ModalContratoForm #slct_regimen_id").selectpicker('refresh');

};

SlctCargarSueldoCargo=function(result){
    if(result.data.length>0){
        $("#ModalContratoForm #txt_sueldo_mensual").val(result.data[0].sueldo_mensual_base); 
        $("#ModalContratoForm #txt_sueldo_produccion").val(result.data[0].sueldo_produccion_base); 
    }else{
        $("#ModalContratoForm #txt_sueldo_mensual").val(""); 
        $("#ModalContratoForm #txt_sueldo_produccion").val(""); 
    }
    
};
</script>
