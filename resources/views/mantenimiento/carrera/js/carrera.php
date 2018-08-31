<script type="text/javascript">
var cursos_selec=[];
var AddEdit=0; //0: Editar | 1: Agregar
var CarreraG={id:0,
carrera:"",
//certificado_carrera:"",
curso_id:"",
estado:1}; // Datos Globales
$(document).ready(function() {
    $("#TableCarrera").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    CargarSlct(3);
    AjaxCarrera.Cargar(HTMLCargarCarrera);
    $("#CarreraForm #TableCarrera select").change(function(){ AjaxCarrera.Cargar(HTMLCargarCarrera); });
    $("#CarreraForm #TableCarrera input").blur(function(){ AjaxCarrera.Cargar(HTMLCargarCarrera); });

    $('#ModalCarrera').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalCarreraForm").append("<input type='hidden' value='"+CarreraG.id+"' name='id'>");
        }
        
        $('#ModalCarreraForm #txt_carrera').val( CarreraG.carrera );
//        $('#ModalCarreraForm #txt_certificado_carrera').val( CarreraG.certificado_carrera );
        var curso = CarreraG.curso_id.split(',');
        $('#ModalCarreraForm #slct_curso_id').selectpicker( 'val',curso );
        $('#ModalCarreraForm #slct_estado').selectpicker( 'val',CarreraG.estado );
        $('#ModalCarreraForm #txt_carrera').focus();
    });

    $('#ModalCarrera').on('hidden.bs.modal', function (event) {
        $("ModalCarreraForm input[type='hidden']").not('.mant').remove();
       // $("ModalCarreraForm input").val('');
    });
});

ValidaForm=function(){
    var r=true;
    if( $.trim( $("#ModalCarreraForm #txt_carrera").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Carrera',4000);
    }
//    else if( $.trim( $("#ModalCarreraForm #txt_certificado_carrera").val() )=='' ){
//        r=false;
//        msjG.mensaje('warning','Ingrese Nombre del Certificado',4000);
//    }
    else if( $.trim( $("#ModalCarreraForm #slct_curso_id").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione almenos 1 Curso',4000);
    }

    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    CarreraG.id='';
    CarreraG.carrera='';
//    CarreraG.certificado_carrera='';
    CarreraG.curso_id='';
    CarreraG.estado='1';
    if( val==0 ){
        CarreraG.id=id;
        CarreraG.carrera=$("#TableCarrera #trid_"+id+" .carrera").text();
//        CarreraG.certificado_carrera=$("#TableCarrera #trid_"+id+" .certificado_carrera").text();
        CarreraG.curso_id=$("#TableCarrera #trid_"+id+" .curso_id").val();

        CarreraG.estado=$("#TableCarrera #trid_"+id+" .estado").val();
    }
    $('#ModalCarrera').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxCarrera.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxCarrera.Cargar(HTMLCargarCarrera);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxCarrera.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        cursos_selec=[];
        $('#ModalCarrera').modal('hide');
        AjaxCarrera.Cargar(HTMLCargarCarrera);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

CargarSlct=function(slct){

    if(slct==3){
    AjaxCarrera.CargarCurso(SlctCargarCurso);
    }
}

SlctCargarCurso=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.curso+"</option>";
    });
    $("#ModalCarrera #slct_curso_id").html(html); 
    $("#ModalCarrera #slct_curso_id").selectpicker('refresh');

};

HTMLCargarCarrera=function(result){ //INICIO HTML
    var html="";
    $('#TableCarrera').DataTable().destroy();

    $.each(result.data.data,function(index,r){ //INICIO FUNCTION
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>";
   
            html+="</td>"+
            "<td class='carrera'>"+r.carrera+"</td>"+
//            "<td class='certificado_carrera'>"+r.certificado_carrera+"</td>"+
            "<td class='cursos'>"+$.trim(r.cursos).split(",").join("<br>")+"</td>"+
            "<td>"+
            "<input type='hidden' class='curso_id' value='"+r.curso_id+"'>";

        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });//FIN FUNCTION

    $("#TableCarrera tbody").html(html); 
    $("#TableCarrera").DataTable({ //INICIO DATATABLE
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
            $('#TableCarrera_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarCarrera','AjaxCarrera',result.data,'#TableCarrera_paginate');
        }
    }); //FIN DATA TABLE
}; //FIN HTML

</script>
