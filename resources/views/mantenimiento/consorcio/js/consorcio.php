<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var consorcioG={id:0,
consorcio:"",
consorcio_apocope:"",
ruc:"",
imagen_nombre:"",
foto:"",
imagen_archivo:"",
estado:1}; // Datos Globales
$(document).ready(function() {
    $("#Tableconsorcio").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    Ajaxconsorcio.Cargar(HTMLCargarconsorcio);
    $("#consorcioForm #Tableconsorcio select").change(function(){ Ajaxconsorcio.Cargar(HTMLCargarconsorcio); });
    $("#consorcioForm #Tableconsorcio input").blur(function(){ Ajaxconsorcio.Cargar(HTMLCargarconsorcio); });

    $('#ModalConsorcio').on('shown.bs.modal', function (event) {
        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalConsorcioForm").append("<input type='hidden' value='"+consorcioG.id+"' name='id'>");
        }

        $('#ModalConsorcioForm #txt_consorcio').val( consorcioG.consorcio );
        $('#ModalConsorcioForm #txt_consorcio_apocope').val( consorcioG.consorcio_apocope );
        $('#ModalConsorcioForm #txt_ruc').val( consorcioG.ruc );
        $('#ModalConsorcioForm #slct_estado').selectpicker('val', consorcioG.estado );
        $('#ModalConsorcioForm #txt_imagen_nombre').val(consorcioG.imagen_nombre);
        $('#ModalConsorcioForm #txt_imagen_archivo').val('');
        $('#ModalConsorcioForm .img-circle').attr('src',consorcioG.imagen_archivo);
        $('#ModalConsorcioForm #txt_consorcio').focus();
    });

    $('#ModalConsorcio').on('hidden.bs.modal', function (event) {
        $("ModalConsorcioForm input[type='hidden']").not('.mant').remove();
       // $("ModalConsorcioForm input").val('');
    });

//    $(document).on('click', '#btnexport', function(event) {
//        $(this).attr('href','ReportDinamic/Mantenimiento.consorcioEM@Exportconsorcio?d=1');
//    });

});

ValidaForm=function(){
    var r=true;
    if( $.trim( $("#ModalConsorcioForm #txt_consorcio").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese consorcio',4000);
    }
    else if( $.trim( $("#ModalConsorcioForm #txt_consorcio_apocope").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese apocope de consorcio',4000);
    }
    else if( $.trim( $("#ModalConsorcioForm #txt_ruc").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese RUC',4000);
    }

    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    consorcioG.id='';
    consorcioG.consorcio='';
    consorcioG.consorcio_apocope='';
    consorcioG.ruc='';
    consorcioG.imagen_nombre='';
    consorcioG.imagen_archivo='';
    consorcioG.estado='1';
    if( val==0 ){
        consorcioG.id=id;
        consorcioG.consorcio=$("#Tableconsorcio #trid_"+id+" .consorcio").text();
        consorcioG.consorcio_apocope=$("#Tableconsorcio #trid_"+id+" .consorcio_apocope").text();
        consorcioG.ruc=$("#Tableconsorcio #trid_"+id+" .ruc").text();
        consorcioG.foto=$("#Tableconsorcio #trid_"+id+" .foto").val();
        
        if(consorcioG.foto!='undefined'){
            consorcioG.imagen_archivo='img/consorcio/'+consorcioG.foto;
            consorcioG.imagen_nombre=consorcioG.foto;
        }else {
            consorcioG.imagen_archivo='';
            consorcioG.imagen_nombre='';
        }      
        consorcioG.estado=$("#Tableconsorcio #trid_"+id+" .estado").val();
    }
    $('#ModalConsorcio').modal('show');
}

CambiarEstado=function(estado,id){
    Ajaxconsorcio.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        Ajaxconsorcio.Cargar(HTMLCargarconsorcio);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        Ajaxconsorcio.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalConsorcio').modal('hide');
        Ajaxconsorcio.Cargar(HTMLCargarconsorcio);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarconsorcio=function(result){
    var html="";
    $('#Tableconsorcio').DataTable().destroy();

    $.each(result.data.data,function(index,r){
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td>";
            if(r.logo!=null){    
            html+="<a  target='_blank' href='img/consorcio/"+r.logo+"'><img src='img/consorcio/"+r.logo+"' style='height: 40px;width: 40px;'></a>";}
            html+="</td>"+
            "<td class='consorcio'>"+r.consorcio+"</td>"+
            "<td class='consorcio_apocope'>"+r.consorcio_apocope+"</td>"+
            "<td class='ruc'>"+r.ruc+"</td>"+
            "<td>";
        if(r.logo!=null){
        html+="<input type='hidden' class='foto' value='"+r.logo+"'>";}

        html+="<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#Tableconsorcio tbody").html(html); 
    $("#Tableconsorcio").DataTable({
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
            $('#Tableconsorcio_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarconsorcio','Ajaxconsorcio',result.data,'#Tableconsorcio_paginate');
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
            $('#ModalConsorcioForm #txt_imagen_archivo').val(e.target.result);
            $('#ModalConsorcioForm .img-circle').attr('src',e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $('#ModalConsorcioForm #txt_imagen_nombre').val(files[0].name);
        console.log(files[0].name);
    };
</script>
