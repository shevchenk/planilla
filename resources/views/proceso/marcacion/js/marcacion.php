<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var EventoG={id:0,evento_tipo_id:0,persona_contrato_id:0,evento_descripcion:"",
    fecha_inicio:"",fecha_fin:"",hora_inicio:"",hora_fin:"",estado:1}; // Datos Globales

$(document).ready(function() {

});

Registrar=function(){
    sweetalertG.confirm("Bienvenido!", "Confirme confirme su dni '"+$("#txt_dni").val()+"'", function(){
        AjaxEvento.Registrar(HTMLRegistrar);
    });
}

HTMLRegistrar=function(result){
    if( result.rst==1 ){
        $("#txt_dni").val("");
    }
        $("#txt_dni").focus();

    swal({
        title: result.tittle,
        text: result.msj,
        showCancelButton: false,
        type: result.type,
        confirmButtonText: "Aceptar",
        closeOnConfirm: true
    })
}
</script>
