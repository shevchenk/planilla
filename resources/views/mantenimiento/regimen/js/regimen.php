<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var RegimenG={id:0,regimen:"",tipo_regimen:0,pregunta_id:0,ipo_respuesta_id:0,estado:1}; // Datos Globales
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
        $('#ModalRegimenForm #txt_respuesta').val( RegimenG.respuesta );
        $('#ModalRegimenForm #txt_puntaje').val( RegimenG.puntaje );
        $('#ModalRegimenForm #slct_pregunta_id').selectpicker('val', RegimenG.pregunta_id );
        $('#ModalRegimenForm #slct_tipo_respuesta_id').selectpicker('val', RegimenG.tipo_respuesta_id );
        $('#ModalRegimenForm #slct_estado').selectpicker( 'val',RegimenG.estado );
        $('#ModalRegimenForm #txt_respuesta').focus();
    });

    $('#ModalRegimen').on('hidden.bs.modal', function (event) {
        $("#ModalRegimenForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if( $.trim( $("#ModalRegimenForm #slct_pregunta_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Pregunta',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #slct_tipo_respuesta_id").val() )=='0' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Regimen',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_respuesta").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Regimen',4000);
    }
    else if( $.trim( $("#ModalRegimenForm #txt_puntaje").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Puntaje',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    RegimenG.id='';
    RegimenG.respuesta='';
    RegimenG.puntaje='';
    RegimenG.pregunta_id='0';
    RegimenG.tipo_respuesta_id='0';
    RegimenG.estado='1';
    if( val==0 ){
        RegimenG.id=id;
        RegimenG.respuesta=$("#TableRegimen #trid_"+id+" .respuesta").text();
        RegimenG.puntaje=$("#TableRegimen #trid_"+id+" .puntaje").text();
        RegimenG.pregunta_id=$("#TableRegimen #trid_"+id+" .pregunta_id").val();
        RegimenG.tipo_respuesta_id=$("#TableRegimen #trid_"+id+" .tipo_respuesta_id").val();
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
