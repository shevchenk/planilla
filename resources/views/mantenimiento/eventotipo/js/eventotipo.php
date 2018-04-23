<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var DatosG={id:0,evento_tipo:"",aplica_dscto:0,estado:1}; // Datos Globales
$(document).ready(function() {

    $("#TableTipoEvento").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    AjaxDatos.Cargar(HTMLCargarDatos);
    $("#TipoEventoForm #TableTipoEvento input").blur(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });
    $("#TipoEventoForm #TableTipoEvento select").change(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });

    $('#ModalEventoTipo').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){        
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalTipoEventoForm").append("<input type='hidden' value='"+DatosG.id+"' name='id'>");
        }
        $('#ModalTipoEventoForm #txt_evento_tipo').val( DatosG.evento_tipo );
        $('#ModalTipoEventoForm #slct_aplica_dscto').selectpicker('val', DatosG.aplica_dscto );        
        $('#ModalTipoEventoForm #slct_estado').selectpicker( 'val',DatosG.estado );
        $('#ModalTipoEventoForm #txt_evento_tipo').focus();
    });

    $('#ModalEventoTipo').on('hidden.bs.modal', function (event) {
        $("#ModalTipoEventoForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalTipoEventoForm #txt_evento_tipo").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Tipo de Evento',4000);
    }
    else if( $.trim( $("#ModalTipoEventoForm #slct_aplica_dscto").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione si Aplica Descuento',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    DatosG.id='';
    DatosG.evento_tipo='';
    DatosG.aplica_dscto='0';
    DatosG.estado='1';
    if( val==0 ){
        DatosG.id=id;
        DatosG.evento_tipo=$("#TableTipoEvento #trid_"+id+" .evento_tipo").text();
        DatosG.aplica_dscto=$("#TableTipoEvento #trid_"+id+" .aplica_dscto").val();
        DatosG.estado=$("#TableTipoEvento #trid_"+id+" .estado").val();
    }
    $('#ModalEventoTipo').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxDatos.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxDatos.Cargar(HTMLCargarDatos);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxDatos.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalEventoTipo').modal('hide');
        AjaxDatos.Cargar(HTMLCargarDatos);
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarDatos=function(result){
    var html="";
    $('#TableTipoEvento').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='evento_tipo'>"+r.evento_tipo+"</td>"+
            "<td class='descuento'>"+r.descuento+"</td>"+
            "<td>"+
            "<input type='hidden' class='aplica_dscto' value='"+r.aplica_dscto+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableTipoEvento tbody").html(html); 
    $("#TableTipoEvento").DataTable({
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
            $('#TableTipoEvento_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarDatos','AjaxDatos',result.data,'#TableTipoEvento_paginate');
        }
    });

};

</script>
