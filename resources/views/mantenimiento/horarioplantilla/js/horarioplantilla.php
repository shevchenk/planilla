<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var DatosG={id:0,plantilla_descripcion:"",dia_ids:0, hora_inicio:"", hora_fin:"", horario_amanecida:0, estado:1}; // Datos Globales
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

    $("#TableDatos").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    CargarSlct(3);
    AjaxDatos.Cargar(HTMLCargarDatos);
    $("#DiaHorarioPlantillaForm #TableDatos input").blur(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });
    $("#DiaHorarioPlantillaForm #TableDatos select").change(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });
     
    $('#ModalDatos').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalHorarioPlantillalForm").append("<input type='hidden' value='"+DatosG.id+"' name='id'>");
        }
        $('#ModalHorarioPlantillalForm #txt_plantilla_descripcion').val( DatosG.plantilla_descripcion );

        var dias = DatosG.dia_ids.split(',');
        $('#ModalHorarioPlantillalForm #slct_dia_ids').selectpicker( 'val', dias );

        $('#ModalHorarioPlantillalForm #txt_hora_inicio').val( DatosG.hora_inicio );
        $('#ModalHorarioPlantillalForm #txt_hora_fin').val( DatosG.hora_fin );
        $('#ModalHorarioPlantillalForm #slct_horario_amanecida').selectpicker('val', DatosG.horario_amanecida );  

        $('#ModalHorarioPlantillalForm #slct_estado').selectpicker( 'val',DatosG.estado );
        $('#ModalHorarioPlantillalForm #txt_plantilla_descripcion').focus();
    });

    $('#ModalDatos').on('hidden.bs.modal', function (event) {
        $("#ModalHorarioPlantillalForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalHorarioPlantillalForm #txt_plantilla_descripcion").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese la Plantilla',4000);
    }
    else if( $.trim( $("#ModalHorarioPlantillalForm #slct_dia_ids").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione almenos 1 Dia',4000);
    }
    else if(  $.trim( $("#ModalHorarioPlantillalForm #txt_hora_inicio").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese la Hora Inicio',4000);
    }
    else if(  $.trim( $("#ModalHorarioPlantillalForm #txt_hora_fin").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese la Hora Fin',4000);
    }
    else if( $.trim( $("#ModalHorarioPlantillalForm #slct_horario_amanecida").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione si tiene Horario Amanecida',4000);
    }
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    DatosG.id='';
    DatosG.plantilla_descripcion='';
    DatosG.dia_ids='0';
    DatosG.hora_inicio='';
    DatosG.hora_fin='';
    DatosG.horario_amanecida='0';
    DatosG.estado='1';
    if( val==0 ){
        DatosG.id=id;
        DatosG.plantilla_descripcion=$("#TableDatos #trid_"+id+" .plantilla_descripcion").text();
        DatosG.dia_ids=$("#TableDatos #trid_"+id+" .dia_ids").val();
        DatosG.hora_inicio=$("#TableDatos #trid_"+id+" .hora_inicio").text();
        DatosG.hora_fin=$("#TableDatos #trid_"+id+" .hora_fin").text();
        DatosG.horario_amanecida=$("#TableDatos #trid_"+id+" .horario_amanecida").val();
        DatosG.estado=$("#TableDatos #trid_"+id+" .estado").val();
    }
    //alert(DatosG.horario_amanecida);
    $('#ModalDatos').modal('show');
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
        $('#ModalDatos').modal('hide');
        AjaxDatos.Cargar(HTMLCargarDatos);
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarDatos=function(result){
    var html="";
    $('#TableDatos').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='plantilla_descripcion'>"+r.plantilla_descripcion+"</td>"+
            "<td class='dia'>"+r.dia+"</td>"+
            "<td class='hora_inicio'>"+r.hora_inicio+"</td>"+
            "<td class='hora_fin'>"+r.hora_fin+"</td>"+
            "<td class='amanecida'>"+r.amanecida+"</td>"+
            "<td>"+
            "<input type='hidden' class='dia_ids' value='"+r.dia_ids+"'>"+
            "<input type='hidden' class='horario_amanecida' value='"+r.horario_amanecida+"'>";
        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableDatos tbody").html(html); 
    $("#TableDatos").DataTable({
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
            $('#TableDatos_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarDatos','AjaxDatos',result.data,'#TableDatos_paginate');
        }
    });

};

// SELECT MULTIPLE
CargarSlct=function(slct){

    if(slct==3){
    AjaxDatos.CargarDia(SlctCargarDia);
    }
}

SlctCargarDia=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.dia+"</option>";
    });
    $("#ModalDatos #slct_dia_ids").html(html); 
    $("#ModalDatos #slct_dia_ids").selectpicker('refresh');

};
// -- 

</script>
