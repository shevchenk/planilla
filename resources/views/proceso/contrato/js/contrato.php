<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ContratoG={id:0,regimen:"",tipo_regimen:0,aporte:0,comision:0,prima:0,seguro:0,estado:1}; // Datos Globales
$(document).ready(function() {

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
    
    $('#ModalContrato').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){        
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalContratoForm").append("<input type='hidden' value='"+ContratoG.id+"' name='id'>");
        }
        $('#ModalContratoForm #txt_regimen').val( ContratoG.regimen );
        $('#ModalContratoForm #slct_tipo_regimen_id').selectpicker('val', ContratoG.tipo_regimen );
        $('#ModalContratoForm #txt_aporte').val(ContratoG.aporte );
        $('#ModalContratoForm #txt_comision').val( ContratoG.comision );
        $('#ModalContratoForm #txt_prima').val(ContratoG.prima );
        $('#ModalContratoForm #txt_seguro').val(ContratoG.seguro );
        $('#ModalContratoForm #slct_estado').selectpicker( 'val',ContratoG.estado );
        $('#ModalContratoForm #txt_regimen').focus();
    });

    $('#ModalContrato').on('hidden.bs.modal', function (event) {
        $("#ModalContratoForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalContratoForm #txt_regimen").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #slct_tipo_regimen_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Contrato',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_aporte").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Aporte',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_comision").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Comisión',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_prima").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Prima',4000);
    }
    else if( $.trim( $("#ModalContratoForm #txt_seguro").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Seguro',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    ContratoG.id='';
    ContratoG.regimen='';
    ContratoG.tipo_regimen='0';
    ContratoG.aporte='';
    ContratoG.comision='';
    ContratoG.prima='';
    ContratoG.seguro='';
    ContratoG.estado='1';
    if( val==0 ){
        ContratoG.id=id;
        ContratoG.regimen=$("#TableContrato #trid_"+id+" .regimen").text();
        ContratoG.tipo_regimen=$("#TableContrato #trid_"+id+" .tipo_regimen").val();
        ContratoG.aporte=$("#TableContrato #trid_"+id+" .aporte").text();
        ContratoG.comision=$("#TableContrato #trid_"+id+" .comision").text();
        ContratoG.prima=$("#TableContrato #trid_"+id+" .prima").text();
        ContratoG.seguro=$("#TableContrato #trid_"+id+" .seguro").text();
        ContratoG.estado=$("#TableContrato #trid_"+id+" .estado").val();
    }
    $('#ModalContrato').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxContrato.CambiarEstado(HTMLCambiarEstado,estado,id);
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
        $('#ModalContrato').modal('hide');
        AjaxContrato.Cargar(HTMLCargarContrato);
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
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='persona'>"+r.persona+"</td>"+
            "<td class='sede'>"+r.sede+"</td>"+
            "<td class='consorcio'>"+r.consorcio+"</td>"+
            "<td class='estado_contrato_nombre'>"+r.estado_contrato_nombre+"</td>"+
            "<td class='tipo_contrato_nombre'>"+r.tipo_contrato_nombre+"</td>"+
            "<td>"+
            "<input type='hidden' class='tipo_regimen' value='"+r.tipo_regimen+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
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
