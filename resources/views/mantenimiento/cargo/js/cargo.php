<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var RegimenG={id:0,cargo:"",sueldo_mensual_base:0,monto_adicional_base:0,estado:1}; // Datos Globales
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
        $('#ModalRegimenForm #txt_cargo').val( RegimenG.cargo );
        $('#ModalRegimenForm #txt_sueldo_mensual_base').val(RegimenG.sueldo_mensual_base );
        $('#ModalRegimenForm #txt_monto_adicional_base').val( RegimenG.monto_adicional_base );
        $('#ModalRegimenForm #slct_estado').selectpicker( 'val',RegimenG.estado );
        $('#ModalRegimenForm #txt_regimen').focus();
    });

    $('#ModalRegimen').on('hidden.bs.modal', function (event) {
        $("#ModalRegimenForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalRegimenForm #txt_cargo").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Cargo',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_sueldo_mensual_base").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Sueldo Base',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_monto_adicional_base").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Adicional Base',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    RegimenG.id='';
    RegimenG.cargo='';
    RegimenG.sueldo_mensual_base='';
    RegimenG.monto_adicional_base='';
    RegimenG.estado='1';
    if( val==0 ){
        RegimenG.id=id;
        RegimenG.cargo=$("#TableRegimen #trid_"+id+" .cargo").text();
        RegimenG.sueldo_mensual_base=$("#TableRegimen #trid_"+id+" .sueldo_mensual_base").text();
        RegimenG.monto_adicional_base=$("#TableRegimen #trid_"+id+" .monto_adicional_base").text();
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
            "<td class='cargo'>"+r.cargo+"</td>"+
            "<td class='sueldo_mensual_base'>"+r.sueldo_mensual_base+"</td>"+
            "<td class='monto_adicional_base'>"+r.monto_adicional_base+"</td>"+
            "<td>";
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
