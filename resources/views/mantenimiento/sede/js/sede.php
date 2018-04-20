<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var SedeG={id:0,
sede:"",
direccion:"",
telefono:"",
celular:"",
email:"",
imagen_nombre:"",
foto:"",
imagen_archivo:"",
estado:1}; // Datos Globales
$(document).ready(function() {
    $("#TableSede").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    AjaxSede.Cargar(HTMLCargarSede);
    $("#SedeForm #TableSede select").change(function(){ AjaxSede.Cargar(HTMLCargarSede); });
    $("#SedeForm #TableSede input").blur(function(){ AjaxSede.Cargar(HTMLCargarSede); });

    $('#ModalSede').on('shown.bs.modal', function (event) {
        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalSedeForm").append("<input type='hidden' value='"+SedeG.id+"' name='id'>");
        }

        $('#ModalSedeForm #txt_sede').val( SedeG.sede );
        $('#ModalSedeForm #txt_direccion').val( SedeG.direccion );
        $('#ModalSedeForm #txt_telefono').val( SedeG.telefono );
        $('#ModalSedeForm #txt_celular').val( SedeG.celular );
        $('#ModalSedeForm #txt_email').val( SedeG.email );

        $('#ModalSedeForm #slct_estado').val( SedeG.estado );
        $('#ModalSedeForm #txt_imagen_nombre').val(SedeG.imagen_nombre);
        $('#ModalSedeForm #txt_imagen_archivo').val('');
        $('#ModalSedeForm .img-circle').attr('src',SedeG.imagen_archivo);
        $('#ModalSedeForm #txt_sede').focus();
    });

    $('#ModalSede').on('hidden.bs.modal', function (event) {
        $("ModalSedeForm input[type='hidden']").not('.mant').remove();
       // $("ModalSedeForm input").val('');
    });

    $(document).on('click', '#btnexport', function(event) {
        $(this).attr('href','ReportDinamic/Mantenimiento.SedeEM@ExportSede?d=1');
    });

});

ValidaForm=function(){
    var r=true;
    if( $.trim( $("#ModalSedeForm #txt_sede").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Sede',4000);
    }

    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    SedeG.id='';
    SedeG.sede='';
    SedeG.direccion='';
    SedeG.telefono='';
    SedeG.celular='';
    SedeG.email='';
    SedeG.imagen_nombre='';
    SedeG.imagen_archivo='';
    SedeG.estado='1';
    if( val==0 ){
        SedeG.id=id;
        SedeG.sede=$("#TableSede #trid_"+id+" .sede").text();
        SedeG.direccion=$("#TableSede #trid_"+id+" .direccion").text();
        SedeG.telefono=$("#TableSede #trid_"+id+" .telefono").text();
        SedeG.celular=$("#TableSede #trid_"+id+" .celular").text();
        SedeG.email=$("#TableSede #trid_"+id+" .email").text();
        SedeG.foto=$("#TableSede #trid_"+id+" .foto").val();
        
        if(SedeG.foto!='undefined'){
            SedeG.imagen_archivo='img/sucursa/'+SedeG.foto;
            SedeG.imagen_nombre=SedeG.foto;
        }else {
            SedeG.imagen_archivo='';
            SedeG.imagen_nombre='';
        }      
        SedeG.estado=$("#TableSede #trid_"+id+" .estado").val();
    }
    $('#ModalSede').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxSede.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxSede.Cargar(HTMLCargarSede);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxSede.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalSede').modal('hide');
        AjaxSede.Cargar(HTMLCargarSede);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarSede=function(result){
    var html="";
    $('#TableSede').DataTable().destroy();

    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td>";
            if(r.foto!=null){    
            html+="<a  target='_blank' href='img/sucursa/"+r.foto+"'><img src='img/sucursa/"+r.foto+"' style='height: 40px;width: 40px;'></a>";}
            html+="</td>"+
            "<td class='sede'>"+r.sede+"</td>"+
            "<td class='direccion'>"+r.direccion+"</td>"+
            "<td class='telefono'>"+r.telefono+"</td>"+
            "<td class='celular'>"+r.celular+"</td>"+
            "<td class='email'>"+r.email+"</td>"+
            "<td>";
        if(r.foto!=null){
        html+="<input type='hidden' class='foto' value='"+r.foto+"'>";}

        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableSede tbody").html(html); 
    $("#TableSede").DataTable({
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
            $('#TableSede_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarSede','AjaxSede',result.data,'#TableSede_paginate');
        }
    });
};

onImagen = function (event) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $('#ModalSedeForm #txt_imagen_archivo').val(e.target.result);
            $('#ModalSedeForm .img-circle').attr('src',e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $('#ModalSedeForm #txt_imagen_nombre').val(files[0].name);
        console.log(files[0].name);
    };
</script>
