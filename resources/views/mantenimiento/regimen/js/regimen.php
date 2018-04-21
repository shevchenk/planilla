<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var RegimenG={id:0,regimen:"",tipo_regimen:0,aporte:0,comision:0,prima:0,seguro:0,estado:1}; // Datos Globales
$(document).ready(function() {

    $("#TableRegimen").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    AjaxRegimen.Cargar(HTMLCargarRegimen);
    
    $("#RegimenForm #TableRegimen select").change(function(){ AjaxRegimen.Cargar(HTMLCargarRegimen); });
    $("#RegimenForm #TableRegimen input").blur(function(){ AjaxRegimen.Cargar(HTMLCargarRegimen); });
    
    $('#ModalRegimen').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){        
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalRegimenForm").append("<input type='hidden' value='"+RegimenG.id+"' name='id'>");
        }
        $('#ModalRegimenForm #txt_regimen').val( RegimenG.regimen );
        $('#ModalRegimenForm #slct_tipo_regimen_id').selectpicker('val', RegimenG.tipo_regimen );
        $('#ModalRegimenForm #txt_aporte').val(RegimenG.aporte );
        $('#ModalRegimenForm #txt_comision').val( RegimenG.comision );
        $('#ModalRegimenForm #txt_prima').val(RegimenG.prima );
        $('#ModalRegimenForm #txt_seguro').val(RegimenG.seguro );
        $('#ModalRegimenForm #slct_estado').selectpicker( 'val',RegimenG.estado );
        $('#ModalRegimenForm #txt_regimen').focus();
    });

    $('#ModalRegimen').on('hidden.bs.modal', function (event) {
        $("#ModalRegimenForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalRegimenForm #txt_regimen").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Regimen',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #slct_tipo_regimen_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Regimen',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_aporte").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Aporte',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_comision").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Comisión',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_prima").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Prima',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_seguro").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Seguro',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    RegimenG.id='';
    RegimenG.regimen='';
    RegimenG.tipo_regimen='0';
    RegimenG.aporte='';
    RegimenG.comision='';
    RegimenG.prima='';
    RegimenG.seguro='';
    RegimenG.estado='1';
    if( val==0 ){
        RegimenG.id=id;
        RegimenG.regimen=$("#TableRegimen #trid_"+id+" .regimen").text();
        RegimenG.tipo_regimen=$("#TableRegimen #trid_"+id+" .tipo_regimen").val();
        RegimenG.aporte=$("#TableRegimen #trid_"+id+" .aporte").text();
        RegimenG.comision=$("#TableRegimen #trid_"+id+" .comision").text();
        RegimenG.prima=$("#TableRegimen #trid_"+id+" .prima").text();
        RegimenG.seguro=$("#TableRegimen #trid_"+id+" .seguro").text();
        RegimenG.estado=$("#TableRegimen #trid_"+id+" .estado").val();
    }
    $('#ModalRegimen').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxRegimen.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxRegimen.Cargar(HTMLCargarRegimen);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxRegimen.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalRegimen').modal('hide');
        AjaxRegimen.Cargar(HTMLCargarRegimen);
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarRegimen=function(result){
    var html="";
    $('#TableRegimen').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='regimen'>"+r.regimen+"</td>"+
            "<td class='tipo_regimen_nombre'>"+r.tipo_regimen_nombre+"</td>"+
            "<td class='aporte'>"+r.aporte+"</td>"+
            "<td class='comision'>"+r.comision+"</td>"+
            "<td class='prima'>"+r.prima+"</td>"+
            "<td class='seguro'>"+r.seguro+"</td>"+
            "<td>"+
            "<input type='hidden' class='tipo_regimen' value='"+r.tipo_regimen+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableRegimen tbody").html(html); 
    $("#TableRegimen").DataTable({
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
            $('#TableRegimen_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarRegimen','AjaxRegimen',result.data,'#TableRegimen_paginate');
        }
    });

};

</script>
