<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var DatosG={id:0,fecha:"",sede_ids:"",estado:1,pago:1}; // Datos Globales
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
    $("#DiaNoLaboralForm #TableDatos input").blur(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });
    $("#DiaNoLaboralForm #TableDatos select").change(function(){ AjaxDatos.Cargar(HTMLCargarDatos); });
     
    $('#ModalDatos').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){        
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalDiaNoLaboralForm").append("<input type='hidden' value='"+DatosG.id+"' name='id'>");
        }
        $('#ModalDiaNoLaboralForm #txt_fecha').val( DatosG.fecha );

        var sede = DatosG.sede_ids.split(',');
        $('#ModalDiaNoLaboralForm #slct_sede_ids').selectpicker( 'val', sede );
        $('#ModalDiaNoLaboralForm #slct_pago').selectpicker( 'val', pago );

        $('#ModalDiaNoLaboralForm #slct_estado').selectpicker( 'val',DatosG.estado );
        //$('#ModalDiaNoLaboralForm #txt_fecha').focus();
    });

    $('#ModalDatos').on('hidden.bs.modal', function (event) {
        $("#ModalDiaNoLaboralForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;
    if(  $.trim( $("#ModalDiaNoLaboralForm #txt_fecha").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese la Fecha',4000);
    }
    /*else if( $.trim( $("#ModalDiaNoLaboralForm #slct_sede_ids").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione almenos 1 Sede',4000);
    }*/
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    DatosG.id='';
    DatosG.fecha='';
    DatosG.sede_ids='0';
    DatosG.estado='1';
    DatosG.pago='1';
    if( val==0 ){
        DatosG.id=id;
        DatosG.fecha=$("#TableDatos #trid_"+id+" .fecha").text();
        DatosG.sede_ids=$("#TableDatos #trid_"+id+" .sede_ids").val();
        DatosG.estado=$("#TableDatos #trid_"+id+" .estado").val();
        DatosG.pago=$("#TableDatos #trid_"+id+" .pago").val();
    }
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
    var sede='';
    $('#TableDatos').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        if($.trim(r.sede)*1==0)
            sede = '';
        else
            sede = r.sede;

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='fecha'>"+r.fecha+"</td>"+
            "<td class='sede'>"+sede+"</td>"+
            "<td>"+r.pago+" Días</td>"+
            "<td>"+
            "<input type='hidden' class='sede_ids' value='"+r.sede_ids+"'>";
            "<input type='hidden' class='pago' value='"+r.pago+"'>";
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
    AjaxDatos.CargarSede(SlctCargarSede);
    }
}

SlctCargarSede=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.sede+"</option>";
    });
    $("#ModalDatos #slct_sede_ids").html(html); 
    $("#ModalDatos #slct_sede_ids").selectpicker('refresh');

};
// -- 

</script>
