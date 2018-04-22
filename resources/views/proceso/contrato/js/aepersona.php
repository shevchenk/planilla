<script type="text/javascript">
var persona_id, cargos_selec=[], PersonaObj,SlctItem='',SlctSedesMarcadas="",SlctConsorciosMarcadas="";
var AddEdit2=0; //0: Editar | 1: Agregar
var PersonaG={id:0,
paterno:"",
materno:"",
nombre:"",
dni:"",
sexo:"",
email:"",
password:"",
telefono:"",
celular:"",
fecha_nacimiento:"",
estado:1}; // 

$(document).ready(function() {
    
    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: false,
        time:false,
        minView:2,
        autoclose: true,
        todayBtn: false
    });
    
    $("#TablePersona").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    
    $('#ModalPersona').on('shown.bs.modal', function (event) {
        $("#f_areas_cargo").css("display","none");
        if( AddEdit2==1 ){
            
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax2();');
        }
        else{
            //AjaxAEPersona.CargarAreas(SlctCargarAreas,PersonaG.id); //no es multiselect
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax2();');
            $("#ModalPersonaForm").append("<input type='hidden' value='"+PersonaG.id+"' name='id'>");
        }

        $('#ModalPersonaForm #txt_paterno').val( PersonaG.paterno );
        $('#ModalPersonaForm #txt_materno').val( PersonaG.materno );
        $('#ModalPersonaForm #txt_nombre').val( PersonaG.nombre );
        $('#ModalPersonaForm #txt_dni').val( PersonaG.dni );
        $('#ModalPersonaForm #slct_sexo').val( PersonaG.sexo );
        $('#ModalPersonaForm #txt_email').val( PersonaG.email );
        $('#ModalPersonaForm #txt_password').val( PersonaG.password );
        $('#ModalPersonaForm #txt_telefono').val( PersonaG.telefono );
        $('#ModalPersonaForm #txt_celular').val( PersonaG.celular );
        $('#ModalPersonaForm #txt_fecha_nacimiento').val( PersonaG.fecha_nacimiento );
        $('#ModalPersonaForm #slct_estado').val( PersonaG.estado );
        $("#ModalPersonaForm select").selectpicker('refresh');
        $('#ModalPersonaForm #txt_nombre').focus();
    });

    $('#ModalPersona').on('hidden.bs.modal', function (event) {
        $("#ModalPersonaForm input[type='hidden']").not('.mant').remove();
        $('#slct_cargos,#slct_rol,#slct_area').selectpicker('destroy');
        $("#ModalPersonaForm #t_cargoPersona").html('');
    });
});

ValidaForm2=function(){
    var r=true;
    if( $.trim( $("#ModalPersonaForm #txt_nombre").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Nombre',4000);
    }
    else if( $.trim( $("#ModalPersonaForm #txt_paterno").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Apellido Paterno',4000);
    }
    else if( $.trim( $("#ModalPersonaForm #txt_materno").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Apellido Materno',4000);
    }
    
    else if( $.trim( $("#ModalPersonaForm #txt_dni").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese DNI',4000);
    }
    else if( $.trim( $("#ModalPersonaForm #slct_sexo").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Sleccione Sexo',4000);
    }
   
    return r;
}

AgregarEditar2=function(val,id){
    AddEdit2=val;
    PersonaG.id='';
    PersonaG.paterno='';
    PersonaG.materno='';
    PersonaG.nombre='';
    PersonaG.dni='';
    PersonaG.sexo='';
    PersonaG.email='';
    PersonaG.password='';
    PersonaG.telefono='';
    PersonaG.celular='';
    PersonaG.fecha_nacimiento='';
    PersonaG.estado='1';
    if( val==0 ){

        PersonaG.id=id;
        PersonaG.paterno=$("#TableListapersona #trid_"+id+" .paterno").text();

        PersonaG.materno=$("#TableListapersona #trid_"+id+" .materno").text();
        PersonaG.nombre=$("#TableListapersona #trid_"+id+" .nombre").text();
        PersonaG.dni=$("#TableListapersona #trid_"+id+" .dni").text();
        PersonaG.sexo=$("#TableListapersona #trid_"+id+" .sexo").val();
        PersonaG.email=$("#TableListapersona #trid_"+id+" .email").val();
        PersonaG.telefono=$("#TableListapersona #trid_"+id+" .telefono").val();
        PersonaG.celular=$("#TableListapersona #trid_"+id+" .celular").val();
        PersonaG.fecha_nacimiento=$("#TableListapersona #trid_"+id+" .fecha_nacimiento").val();
        PersonaG.estado=$("#TableListapersona #trid_"+id+" .estado").val();
      
    }
    $('#ModalPersona').modal('show');
}

AgregarEditarAjax2=function(){
    if( ValidaForm2() ){
        AjaxAEPersona.AgregarEditar2(HTMLAgregarEditar2);
    }
}

HTMLAgregarEditar2=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalPersona').modal('hide');
        AjaxListapersona.Cargar(HTMLCargarListaPersona);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}
AgregarArea=function(){
    //añadir registro "opcion" por usuario
    var html="";
    var privilegio_id=$('#slct_cargos option:selected').val();
    var privilegio=$('#slct_cargos option:selected').text();
    var buscar_privilegio = $('#cargo_'+privilegio_id).text();
    if (privilegio_id!=='') {
        if (buscar_privilegio==="") {

            html="<li class='list-group-item'>";
            html+="<div class='row'><div class='col-sm-1' id='cargo_"+privilegio_id+"'><h5>"+privilegio+"</h5></div>";
            html+="<div class='col-sm-3'><select class='form-control selectpicker' multiple data-actions-box='true' name='slct_sedes"+privilegio_id+"[]' id='slct_sedes"+privilegio_id+"'></select></div>";
            html+="<div class='col-sm-3'><select class='form-control selectpicker' multiple data-actions-box='true' name='slct_consorcios"+privilegio_id+"[]' id='slct_consorcios"+privilegio_id+"'></select></div>";
            html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_ingreso" name="txt_fecha_ingreso'+privilegio_id+'"  readonly="" ></div>';
            html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_salida" name="txt_fecha_salida'+privilegio_id+'"  readonly=""></div>';
            html+='<div class="col-sm-1">';
            html+='<button type="button" id="'+privilegio_id+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
            html+="</li>";

            $("#t_cargoPersona").append(html); 
            SlctItem=privilegio_id;
            SlctSedesMarcadas="";
            SlctConsorciosMarcadas="";
            AjaxAEPersona.CargarSede(SlctCargarSede2);
            AjaxAEPersona.CargarConsorcio(SlctCargarConsorcio2);
            cargos_selec.push(privilegio_id);
            Fecha(); 
        } else 
            alert("Ya se agrego este Privilegio");
    } else 
        alert("Seleccione Privilegio");

};

EliminarArea=function(obj){
    //console.log(obj);
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = cargos_selec.indexOf(valor);
    cargos_selec.splice( index, 1 );
    console.log(cargos_selec);
};
CargarSlct=function(){
    AjaxAEPersona.CargarPrivilegio(SlctCargarPrivilegio);
}

SlctCargarPrivilegio=function(result){
    var html="<option value=''>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.privilegio+"</option>";
    });
    $("#ModalPersona #slct_cargos").html(html); 
    $("#ModalPersona #slct_cargos").selectpicker('refresh');

}

SlctCargarSede2=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.sede+"</option>";
    });
    $("#t_cargoPersona #slct_sedes"+SlctItem).html(html); 
    $("#t_cargoPersona #slct_sedes"+SlctItem).val(SlctSedesMarcadas); 
    $("#t_cargoPersona #slct_sedes"+SlctItem).selectpicker('refresh');
};
SlctCargarConsorcio2=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.consorcio+"</option>";
    });
    $("#t_cargoPersona #slct_consorcios"+SlctItem).html(html); 
    $("#t_cargoPersona #slct_consorcios"+SlctItem).val(SlctConsorciosMarcadas); 
    $("#t_cargoPersona #slct_consorcios"+SlctItem).selectpicker('refresh');
};
SlctCargarAreas=function(result){
    var html="";
    cargos_selec=[];
    $.each(result, function(index,r){
        var sedes = r.sede_ids.split(",");
        var consorcios = r.consorcio_ids.split(",");
        html="<li class='list-group-item'>";
        html+="<div class='row'><div class='col-sm-1' id='cargo_"+r.privilegio_id+"'><h5>"+r.privilegio+"</h5></div>";
        html+="<div class='col-sm-3'><select class='form-control selectpicker' multiple data-actions-box='true' name='slct_sedes"+r.privilegio_id+"[]' id='slct_sedes"+r.privilegio_id+"'></select></div>";
        html+="<div class='col-sm-3'><select class='form-control selectpicker' multiple data-actions-box='true' name='slct_consorcios"+r.privilegio_id+"[]' id='slct_consorcios"+r.privilegio_id+"'></select></div>";
        html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_ingreso" name="txt_fecha_ingreso'+r.privilegio_id+'"  readonly="" value="'+r.fecha_ingreso+'"></div>';
        html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_salida" name="txt_fecha_salida'+r.privilegio_id+'"  readonly="" value="'+r.fecha_salida+'"></div>';
        html+='<div class="col-sm-1">';
        html+='<button type="button" id="'+r.privilegio_id+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
        html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
        html+="</li>";

        $("#t_cargoPersona").append(html); 
        SlctItem=r.privilegio_id;
        SlctSedesMarcadas=sedes;
        SlctConsorciosMarcadas=consorcios;
        AjaxAEPersona.CargarSede(SlctCargarSede2);
        AjaxAEPersona.CargarConsorcio(SlctCargarConsorcio2);
        cargos_selec.push(r.privilegio_id);
    });
    Fecha(); 
};

Fecha=function(){
    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: false,
        time:false,
        minView:2,
        autoclose: true,
        todayBtn: false
    });
}
</script>
