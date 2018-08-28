<script type="text/javascript">
var ConGradoG=100000;
var grados_selec=[];

var ConInvestigaG=100000;
var investiga_selec=[];

var ConPublicaG=100000;
var publica_selec=[];

var persona_id, cargos_selec=[], PersonaObj,SlctItem='',SlctSedesMarcadas="",SlctConsorciosMarcadas="";
var AddEdit=0; //0: Editar | 1: Agregar
var PersonaG={id:0,
paterno:"",
materno:"",
nombre:"",
dni:"",
sexo:0,
email:"",
password:"",
telefono:"",
celular:"",
fecha_nacimiento:"",
estado:1,
regina:"",
regina_anio:"",
dina:"",
dina_anio:""}; // Datos Globales
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
    AjaxPersona.Cargar(HTMLCargarPersona);
    $("#PersonaForm #TablePersona select").change(function(){ AjaxPersona.Cargar(HTMLCargarPersona); });
    $("#PersonaForm #TablePersona input").blur(function(){ AjaxPersona.Cargar(HTMLCargarPersona); });

    $('#ModalPersona').on('shown.bs.modal', function (event) {
        CargarSlct();
        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            AjaxPersona.CargarGrados(SlctCargarGrados,PersonaG.id);
            AjaxPersona.CargarInvestigaciones(SlctCargarInvestigacion,PersonaG.id);
            AjaxPersona.CargarPublicaciones(SlctCargarPublicacion,PersonaG.id);
            AjaxPersona.CargarAreas(SlctCargarAreas,PersonaG.id); //no es multiselect
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalPersonaForm").append("<input type='hidden' value='"+PersonaG.id+"' name='id'>");
        }

        $('#ModalPersonaForm #txt_paterno').val( PersonaG.paterno );
        $('#ModalPersonaForm #txt_materno').val( PersonaG.materno );
        $('#ModalPersonaForm #txt_nombre').val( PersonaG.nombre );
        $('#ModalPersonaForm #txt_dni').val( PersonaG.dni );
        $('#ModalPersonaForm #slct_sexo').val( PersonaG.sexo );
        $('#ModalPersonaForm #txt_email').val( PersonaG.email );
        $('#ModalPersonaForm #txt_telefono').val( PersonaG.telefono );
        $('#ModalPersonaForm #txt_password').val( PersonaG.password );
        $('#ModalPersonaForm #txt_celular').val( PersonaG.celular );
        $('#ModalPersonaForm #txt_fecha_nacimiento').val( PersonaG.fecha_nacimiento );
        $('#ModalPersonaForm #slct_estado').val( PersonaG.estado );

        $('#ModalPersonaForm #txt_regina').val( PersonaG.regina );
        $('#ModalPersonaForm #txt_regina_anio').val( PersonaG.regina_anio );
        $('#ModalPersonaForm #txt_dina').val( PersonaG.dina );
        $('#ModalPersonaForm #txt_dina_anio').val( PersonaG.dina_anio );

        $("#ModalPersona select").selectpicker('refresh');
        $('#ModalPersonaForm #txt_nombre').focus();
    });

    $('#ModalPersona').on('hidden.bs.modal', function (event) {
        $("#ModalPersonaForm input[type='hidden']").not('.mant').remove();
        $('#slct_cargos,#slct_rol,#slct_area').selectpicker('destroy');
        $("#ModalPersonaForm #t_gradoPersona").html(''); //Limpia los datos
        $("#ModalPersonaForm #t_investigaPersona").html('');
        $("#ModalPersonaForm #t_publicaPersona").html('');
        $("#ModalPersonaForm #t_cargoPersona").html('');
    });
});

ValidaForm=function(){
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

AgregarEditar=function(val,id){
    AddEdit=val;
    PersonaG.id='';
    PersonaG.paterno='';
    PersonaG.materno='';
    PersonaG.nombre='';
    PersonaG.dni='';
    PersonaG.sexo='0';
    PersonaG.email='';
    PersonaG.password='';
    PersonaG.telefono='';
    PersonaG.celular='';
    PersonaG.fecha_nacimiento='';
    PersonaG.estado='1';
    PersonaG.regina='';
    PersonaG.regina_anio='';
    PersonaG.dina='';
    PersonaG.dina_anio='';
    if( val==0 ){

        PersonaG.id=id;
        PersonaG.paterno=$("#TablePersona #trid_"+id+" .paterno").text();
        PersonaG.materno=$("#TablePersona #trid_"+id+" .materno").text();
        PersonaG.nombre=$("#TablePersona #trid_"+id+" .nombre").text();
        PersonaG.dni=$("#TablePersona #trid_"+id+" .dni").text();
        PersonaG.sexo=$("#TablePersona #trid_"+id+" .sexo").val();
        PersonaG.email=$("#TablePersona #trid_"+id+" .email").text();
        PersonaG.telefono=$("#TablePersona #trid_"+id+" .telefono").val();
        PersonaG.celular=$("#TablePersona #trid_"+id+" .celular").val();
        PersonaG.fecha_nacimiento=$("#TablePersona #trid_"+id+" .fecha_nacimiento").val();
        PersonaG.estado=$("#TablePersona #trid_"+id+" .estado").val();

        PersonaG.regina=$("#TablePersona #trid_"+id+" .regina").val();
        PersonaG.regina_anio=$("#TablePersona #trid_"+id+" .regina_anio").val();
        PersonaG.dina=$("#TablePersona #trid_"+id+" .dina").val();
        PersonaG.dina_anio=$("#TablePersona #trid_"+id+" .dina_anio").val();
      
    }
    $('#ModalPersona').modal('show');
}

CambiarEstado=function(estado,id){
    AjaxPersona.CambiarEstado(HTMLCambiarEstado,estado,id);
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxPersona.Cargar(HTMLCargarPersona);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxPersona.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        cargos_selec=[];
        $('#ModalPersona').modal('hide');
        AjaxPersona.Cargar(HTMLCargarPersona);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

CargarSlct=function(){
    AjaxPersona.CargarPrivilegio(SlctCargarPrivilegio);
}

SlctCargarPrivilegio=function(result){
    var html="<option value=''>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.privilegio+"</option>";
    });
    $("#ModalPersona #slct_cargos").html(html); 
    $("#ModalPersona #slct_cargos").selectpicker('refresh');

}

SlctCargarSede=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.sede+"</option>";
    });
    $("#t_cargoPersona #slct_sedes"+SlctItem).html(html); 
    $("#t_cargoPersona #slct_sedes"+SlctItem).val(SlctSedesMarcadas); 
    $("#t_cargoPersona #slct_sedes"+SlctItem).selectpicker('refresh');
};
SlctCargarConsorcio=function(result){
    var html="";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.consorcio+"</option>";
    });
    $("#t_cargoPersona #slct_consorcios"+SlctItem).html(html); 
    $("#t_cargoPersona #slct_consorcios"+SlctItem).val(SlctConsorciosMarcadas); 
    $("#t_cargoPersona #slct_consorcios"+SlctItem).selectpicker('refresh');
};

SlctCargarGrados=function(result){    
    var html="";
    grados_selec=[];
    $.each(result, function(index,r){
        html="<li class='list-group-item'>";
        html+="<div class='row'>";                
        html+='<div class="col-sm-4"><input type="text" class="form-control" id="txt_universidad'+r.id+'" name="txt_universidad'+r.id+'" placeholder="Universidad" value="'+r.universidad+'"></div>';
        html+='<div class="col-sm-5"><input type="text" class="form-control" id="txt_grado_instruccion'+r.id+'" name="txt_grado_instruccion'+r.id+'" placeholder="Grado Instruccion" value="'+r.grado_instruccion+'"></div>';
        html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+r.id+'" name="txt_anio'+r.id+'"  readonly="" value="'+r.anio+'" style="cursor:pointer;"></div>';
        html+='<div class="col-sm-1">';
        html+='<button type="button" id="'+r.id+'" Onclick="EliminarGrado(this)" class="btn btn-danger btn-sm" >';
        html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
        html+="</li>";

        $("#t_gradoPersona").append(html); 
        grados_selec.push(r.id);
    });
    FechaAnio(); 
};

SlctCargarInvestigacion=function(result){    
    var html="";
    investiga_selec=[];
    $.each(result, function(index,r){
        html="<li class='list-group-item'>";
        html+="<div class='row'>";
        html+='<div class="col-sm-9"><input type="text" class="form-control" id="txt_investiga'+r.id+'" name="txt_investiga'+r.id+'" placeholder="Ingrese Investigación" value="'+r.investiga+'"></div>';
        html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+r.id+'" name="txt_anio'+r.id+'"  readonly="" value="'+r.anio+'" style="cursor:pointer;"></div>';
        html+='<div class="col-sm-1">';
        html+='<button type="button" id="'+r.id+'" Onclick="EliminarInvestiga(this)" class="btn btn-danger btn-sm" >';
        html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
        html+="</li>";

        $("#t_investigaPersona").append(html); 
        investiga_selec.push(r.id);
    });
    FechaAnio(); 
};

SlctCargarPublicacion=function(result){    
    var html="";
    publica_selec=[];
    $.each(result, function(index,r){
        html="<li class='list-group-item'>";
        html+="<div class='row'>";
        html+='<div class="col-sm-5"><input type="text" class="form-control" id="txt_publica'+r.id+'" name="txt_publica'+r.id+'" placeholder="Ingrese Publicación" value="'+r.publica+'"></div>';
        html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+r.id+'" name="txt_anio'+r.id+'"  readonly="" value="'+r.anio+'" style="cursor:pointer;"></div>';
        html+='<div class="col-sm-4"><input type="text" class="form-control" id="txt_revista'+r.id+'" name="txt_revista'+r.id+'" placeholder="Ingrese Revista" value="'+r.revista+'"></div>';
        html+='<div class="col-sm-1">';
        html+='<button type="button" id="'+r.id+'" Onclick="EliminarPublica(this)" class="btn btn-danger btn-sm" >';
        html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
        html+="</li>";

        $("#t_publicaPersona").append(html); 
        publica_selec.push(r.id);
    });
    FechaAnio(); 
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
        AjaxPersona.CargarSede(SlctCargarSede);
        AjaxPersona.CargarConsorcio(SlctCargarConsorcio);
        cargos_selec.push(r.privilegio_id);
    });
    Fecha(); 
};


HTMLCargarPersona=function(result){
    var html="";
    $('#TablePersona').DataTable().destroy();

    $.each(result.data.data,function(index,r){        
        estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(1,'+r.id+')" class="btn btn-danger">Inactivo</span>';
        if(r.estado==1){
            estadohtml='<span id="'+r.id+'" onClick="CambiarEstado(0,'+r.id+')" class="btn btn-success">Activo</span>';
        }
       
        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='paterno'>"+r.paterno+"</td>"+
            "<td class='materno'>"+r.materno+"</td>"+
            "<td class='nombre'>"+r.nombre+"</td>"+
            "<td class='dni'>"+r.dni+"</td>"+
            "<td class='email'>"+r.email+"</td>"+
            "<td>"+
            "<input type='hidden' class='fecha_nacimiento' value='"+r.fecha_nacimiento+"'>"+
            "<input type='hidden' class='sexo' value='"+r.sexo+"'>"+
            "<input type='hidden' class='telefono' value='"+r.telefono+"'>"+
            "<input type='hidden' class='celular' value='"+r.celular+"'>"+
                "<input type='hidden' class='regina' value='"+r.regina+"'>"+
                "<input type='hidden' class='regina_anio' value='"+r.regina_anio+"'>"+
                "<input type='hidden' class='dina' value='"+r.dina+"'>"+
                "<input type='hidden' class='dina_anio' value='"+r.dina_anio+"'>"+
            "<input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+
            "</td>"+
            '<td><a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TablePersona tbody").html(html); 
    $("#TablePersona").DataTable({
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
            $('#TablePersona_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarPersona','AjaxPersona',result.data,'#TablePersona_paginate');
        } 
    });
};

AgregarGrado=function(){
    ConGradoG++;
    var html="";
    html="<li class='list-group-item'>";
    html+="<div class='row'>";
    html+='<div class="col-sm-4"><input type="text" class="form-control" id="txt_universidad'+ConGradoG+'" name="txt_universidad'+ConGradoG+'" placeholder="Universidad" value=""></div>';
    html+='<div class="col-sm-5"><input type="text" class="form-control" id="txt_grado_instruccion'+ConGradoG+'" name="txt_grado_instruccion'+ConGradoG+'" placeholder="Grado Instruccion" value=""></div>';
    html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+ConGradoG+'" name="txt_anio'+ConGradoG+'"  readonly="" value="<?php echo date('Y')?>" style="cursor:pointer;"></div>';
    html+='<div class="col-sm-1">';
    html+='<button type="button" id="'+ConGradoG+'" Onclick="EliminarGrado(this)" class="btn btn-danger btn-sm" >';
    html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
    html+="</li>";

    $("#t_gradoPersona").append(html);
    grados_selec.push(ConGradoG);
    FechaAnio();
};

AgregarInvestigacion=function(){
    ConInvestigaG++;
    var html="";
    html="<li class='list-group-item'>";
    html+="<div class='row'>";
    html+='<div class="col-sm-9"><input type="text" class="form-control" id="txt_investiga'+ConInvestigaG+'" name="txt_investiga'+ConInvestigaG+'" placeholder="Ingrese Investigación" value=""></div>';
    html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+ConInvestigaG+'" name="txt_anio'+ConInvestigaG+'"  readonly="" value="<?php echo date('Y')?>" style="cursor:pointer;"></div>';
    html+='<div class="col-sm-1">';
    html+='<button type="button" id="'+ConInvestigaG+'" Onclick="EliminarInvestiga(this)" class="btn btn-danger btn-sm" >';
    html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
    html+="</li>";

    $("#t_investigaPersona").append(html);
    investiga_selec.push(ConInvestigaG);
    FechaAnio();
};

AgregarPublicacion=function(){
    ConPublicaG++;
    var html="";
    html="<li class='list-group-item'>";
    html+="<div class='row'>";
    html+='<div class="col-sm-5"><input type="text" class="form-control" id="txt_publica'+ConPublicaG+'" name="txt_publica'+ConPublicaG+'" placeholder="Ingrese Publicación" value=""></div>';
    html+='<div class="col-sm-2"><input type="text" class="form-control fechaanio" id="txt_anio'+ConPublicaG+'" name="txt_anio'+ConPublicaG+'"  readonly="" value="<?php echo date('Y')?>" style="cursor:pointer;"></div>';
    html+='<div class="col-sm-4"><input type="text" class="form-control" id="txt_revista'+ConPublicaG+'" name="txt_revista'+ConPublicaG+'" placeholder="Ingrese Revista" value=""></div>';
    html+='<div class="col-sm-1">';
    html+='<button type="button" id="'+ConPublicaG+'" Onclick="EliminarInvestiga(this)" class="btn btn-danger btn-sm" >';
    html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
    html+="</li>";

    $("#t_publicaPersona").append(html);
    publica_selec.push(ConPublicaG);
    FechaAnio();
};

EliminarGrado=function(obj){
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = grados_selec.indexOf(valor);
    grados_selec.splice( index, 1 );
};

EliminarInvestiga=function(obj){
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = investiga_selec.indexOf(valor);
    investiga_selec.splice( index, 1 );
};

EliminarPublica=function(obj){
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = publica_selec.indexOf(valor);
    publica_selec.splice( index, 1 );
};


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
            html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_ingreso" name="txt_fecha_ingreso'+privilegio_id+'"  readonly="" value="<?php echo date('Y-m-d')?>"></div>';
            html+='<div class="col-sm-2"> <input type="text" class="form-control fecha" id="txt_fecha_salida" name="txt_fecha_salida'+privilegio_id+'"  readonly=""></div>';
            html+='<div class="col-sm-1">';
            html+='<button type="button" id="'+privilegio_id+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div></div>';
            html+="</li>";

            $("#t_cargoPersona").append(html); 
            SlctItem=privilegio_id;
            SlctSedesMarcadas="";
            SlctConsorciosMarcadas="";
            AjaxPersona.CargarSede(SlctCargarSede);
            AjaxPersona.CargarConsorcio(SlctCargarConsorcio);
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

FechaAnio=function(){
    $(".fechaanio").datetimepicker({
        format: "yyyy",
        language: 'es',
        startView: 'decade',
        minView: 'decade',
        viewSelect: 'decade',
        autoclose: true,
    });
}
</script>
