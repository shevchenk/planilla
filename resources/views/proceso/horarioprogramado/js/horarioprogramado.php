<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var EventoG={id:0,evento_tipo_id:0,persona_contrato_id:0,evento_descripcion:"",
    fecha_inicio:"",fecha_fin:"",hora_inicio:"",hora_fin:"",estado:1}; // Datos Globales

var carrerasOptions = "";
var cursosLbl = [];
var cursos = [];

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

    //AjaxDato.CargarEventoTipo(SlctCargarEventoTipo);

    AjaxDato.CargarCursos(function(da){
        

        tmp = [];
        if(da.rst==1)for (var i = da.data.length - 1; i >= 0; i--) {
            
            
            if(!tmp.includes(da.data[i].idcarrera)){
                carrerasOptions+='<option value="'+da.data[i].idcarrera+'">'+da.data[i].carrera+'</option>';
                tmp.push(da.data[i].idcarrera);
                cursos[da.data[i].idcarrera] = [];
            }

            tmp[da.data[i].idcarrera] = da.data[i].idcarrera;
            cursos[da.data[i].idcarrera].push(da.data[i].idcurso);
            cursosLbl[da.data[i].idcurso] = da.data[i].curso;
        }

    });

    
    //$("#EventoForm #TableEvento select").change(function(){ AjaxDato.Cargar(HTMLCargarDatos); });
    //$("#EventoForm #TableEvento input").blur(function(){ AjaxDato.Cargar(HTMLCargarDatos); });

});

ValidaForm=function(){
    var r=true;
    if($(".horario_plantilla").is(':checked')) {  
            
    } else {  
        r=false;
        //msjG.mensaje('warning','Por favor seleccione un Horario!',4000);
        swal("", "Por favor seleccione un Horario de Programación!", "warning");
    }
    return r;
}
/*
AgregarEditar=function(val,id){
    AddEdit=val;
    $("#Evento").css("display","");
    $("#btn_guardar_evento").show();
    
    $('#ModalEventoForm #slct_evento_tipo_id').prop("disabled",false);
    $('#ModalEventoForm #txt_evento_descripcion').prop("disabled",false);
    $('#ModalEventoForm #txt_hora_inicio').prop("disabled",false);
    $('#ModalEventoForm #txt_hora_fin').prop("disabled",false);
    
    EventoG.id='';
    EventoG.persona_contrato_id=$("#txt_persona_contrato_id").val();
    EventoG.evento_tipo_id='0';
    EventoG.evento_descripcion='';
    EventoG.fecha_inicio='';
    EventoG.fecha_fin="";
    EventoG.hora_inicio="";
    EventoG.hora_fin="";
    EventoG.estado=1;
    
    if( val==0 ){
        $("#Evento").css("display","");
        $("#btn_guardar_evento").hide();
        
        $('#ModalEventoForm #slct_evento_tipo_id').prop("disabled",true);
        $('#ModalEventoForm #txt_evento_descripcion').prop("disabled",true);
        $('#ModalEventoForm #txt_hora_inicio').prop("disabled",true);
        $('#ModalEventoForm #txt_hora_fin').prop("disabled",true);
          
        EventoG.id=id;
        EventoG.persona_contrato_id=$("#TableEvento #trid_"+id+" .persona_contrato_id").val();
        EventoG.evento_tipo_id=$("#TableEvento #trid_"+id+" .evento_tipo_id").val();
        EventoG.evento_descripcion=$("#TableEvento #trid_"+id+" .evento_descripcion").text();
        EventoG.fecha_inicio=$("#TableEvento #trid_"+id+" .fecha_inicio").val();
        EventoG.fecha_fin=$("#TableEvento #trid_"+id+" .fecha_fin").val();
        EventoG.hora_inicio=$("#TableEvento #trid_"+id+" .hora_inicio").val();
        EventoG.hora_fin=$("#TableEvento #trid_"+id+" .hora_fin").val();
        EventoG.estado=1;
    }
    LlenarAgregarEditar();
    $("html, body").animate({scrollTop:$(document).height()+"px"});
}
*/
/*
LlenarAgregarEditar=function(){
        if( AddEdit==1 ){        
        }
        else{
            $("#ModalEventoForm").append("<input type='hidden' value='"+EventoG.id+"' name='id'>");
        }
        $('#ModalEventoForm #txt_persona_contrato_id').val( EventoG.persona_contrato_id );
        $('#ModalEventoForm #slct_evento_tipo_id').selectpicker('val', EventoG.evento_tipo_id );
        $('#ModalEventoForm #txt_evento_descripcion').val(EventoG.evento_descripcion );
        $('#ModalEventoForm #txt_fecha_inicio').val(EventoG.fecha_inicio );
        $('#ModalEventoForm #txt_fecha_fin').val(EventoG.fecha_fin );
        $('#ModalEventoForm #txt_hora_inicio').val(EventoG.hora_inicio );
        $('#ModalEventoForm #txt_hora_fin').val(EventoG.hora_fin );
        $('#ModalEventoForm #txt_estado').val(EventoG.estado );        
}
*/

AgregarPlantilla=function(estado,id){
   $("#div_horario_plantilla").hide(); 
   $("#div_horario_plantilla").fadeIn('slow');
   
   $("#ModalHorarioPlantillaForm #txt_persona_contrato_id").val($("#EventoForm #txt_persona_contrato_id").val());
   AjaxDato.CargarHorarioPlantilla(HTMLCargarHorarioPlantilla);
   var altura = $(document).height();
   $("html, body").animate({scrollTop:altura+"px"});
}

CambiarEstado=function(estado,id){
    sweetalertG.confirm("¿Estás seguro?", "Confirme la eliminación", function(){
        AjaxDato.CambiarEstado(HTMLCambiarEstado, estado, id);
    });
}

HTMLCambiarEstado=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxDato.Cargar(HTMLCargarDatos);
    }
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxDato.AgregarEditar(HTMLAgregarEditar);
    }
}

marcarCheck=function(id){
    // Si esta seleccionado (si la propiedad checked es igual a true)
    if ($('#hp'+id).prop('checked')) {
        $('.input_tolera'+id).val(0);
        $('.input_tolera'+id).prop('readonly', false);
    } else {
        $('.input_tolera'+id).prop('readonly', true);
        $('.input_tolera'+id).val('');
    }
}
cancelarHP=function(){
    $("html, body").animate({scrollTop:"0px"});
    $("#div_horario_plantilla").fadeOut('slow');
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $("#div_horario_plantilla").fadeOut('slow');
        AjaxDato.Cargar(HTMLCargarDatos);
        
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarDatos=function(result){
    $("#div_horario_programado").show('slow');
    var html="";
    //console.log(result.data);
    if(result.data.length > 0)
    {
        $.each(result.data,function(index, r){
            html += '<div class="col-xs-12" style="padding: 0px;">'+
                        '<div class="panel panel-info col-md-11" style="padding: 0px;">'+
                            '<div class="panel-heading">'+ 
                                '<h3 class="panel-title text-center">HORARIOS PROGRAMADOS</h3>'+
                            '</div>'+ 
                            '<div class="panel-body">';
                                
                        var ar_hpro = r.horas_programadas.split('|');
                        $.each(ar_hpro, function(i, d){
                            var ar_d = d.split('-');       
                            html+='<div class="col-lg-2">'+
                                        '<div class="panel panel-danger">'+
                                          '<div class="panel-heading">'+
                                            '<h3 class="panel-title text-center"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> '+ar_d[0]+'</h3>'+
                                          '</div>'+
                                          '<div class="panel-body">'+
                                            '<p><strong>Hora Ini :</strong> '+ar_d[1]+'</p>'+
                                            '<p><strong>Hora Fin :</strong> '+ar_d[2]+'</p>'+
                                            '<p class="bg-warning text-center" style="font-weight: bold;">Tolerancia: '+ar_d[3]+'</p>'+
                                          '</div>'+
                                        '</div>'+
                                    '</div>';
                        });

                    html+='</div>'+ 
                        '</div>'+
                        '<div class="col-md-1" style="padding:0px;">'+
                            '<div class="">'+
                              '<div class="panel-heading">'+
                                '<h3 class="panel-title">&nbsp;</h3>'+
                              '</div>'+
                              '<div class="panel-body">'+
                              '</br></br></br>';

                        //html+="<input type='hidden' class='estado' value='"+r.estado+"'>";
                        html+='<span id="1" onclick="CambiarEstado(0,'+r.horario_plantilla_id+')" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i></span>'+
                              '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
        });
    }
    $("#div_horario_programado").html(html);
};

HTMLCargarHorarioPlantilla=function(result){
    $("#ModalHorarioPlantilla").show('slow');
    var html="";
     
    $.each(result.data,function(index,r){
                
        html+='<div class="col-xs-12">'+
                '<div class="panel panel-info col-md-11" style="padding: 0px;">'+
                    '<div class="panel-heading" style="overflow: hidden;">'+
                        //'<input type="hidden" name="txt_estado" id="txt_estado" class="form-control mant" readonly="" value="1">'+
                        '<span class="label" id="" style="font-size: 14px; float:left; padding: 8px; background-color: #fff; color:#666;">'+r.dia_apocope+'</span>'+
                        '<span class="label" id="" style="font-size: 14px; float:right; padding: 8px; background-color: #fff; color:#666;">'+r.plantilla_descripcion+'</span>'+
                    '</div>'+
                    '<div class="panel-body">';

                    var ar_dias = r.dias.split(',');
                    var it=0;
                    $.each(ar_dias, function(i, d){
                        var ar_d = d.split('-');
                        it++;
                        html+='<div class="col-lg-2">'+
                                    '<div class="panel panel-warning">'+
                                      '<div class="panel-heading">'+
                                        '<h3 class="panel-title text-center"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> '+ar_d[1]+'</h3>'+
                                      '</div>'+
                                      '<div class="panel-body">'+
                                        '<p><strong>Hora Ini :</strong> '+r.hora_inicio+'</p>'+
                                        '<p><strong>Hora Fin :</strong> '+r.hora_fin+'</p>'+
                                        '<p><input type="text" readonly class="form-control text-center input_tolera'+r.id+'" id="txt_tolerancia'+r.id+ar_d[0]+'" name="txt_tolerancia'+r.id+ar_d[0]+'" onkeypress="return masterG.validaNumeros(event, this);" placeholder="Tolerancia">'+
                                        '<select class="form-control" id="carrera_'+it+'" name="carrera'+r.id+ar_d[0]+'" onchange="dependiente(this);"><option value="0"> - Carrera - </option>'+carrerasOptions+'</select><select class="form-control" id="curso_'+it+'" name="curso'+r.id+ar_d[0]+'"><option value="0"> - Curso -</option></select><input type="text" placeholder="Monto por hora" id="monto_hora'+r.id+'" name="monto_hora'+r.id+ar_d[0]+'" class="form-control" onkeypress="return masterG.validaNumeros(event, this);"></p>'+
                                      '</div>'+
                                    '</div>'+
                                '</div>';
                    });
                    
              html+='</div>'+
                '</div>'+
                '<div class="col-md-1" style="padding:0px;">'+
                    '<div class="">'+
                      '<div class="panel-heading">'+
                        '<h3 class="panel-title">&nbsp;</h3>'+
                      '</div>'+
                      '<div class="panel-body">'+
                      '</br></br></br>'+
                        '<div class="checkbox">'+
                            '<label>'+
                              '<input type="checkbox" class="horario_plantilla" id="hp'+r.id+'" name="horario_plantilla[]" value="'+r.id+'" onclick="marcarCheck('+r.id+')"> <span class="glyphicon glyphicon-arrow-left" style="font-size: 20px;" aria-hidden="true"></span>'+
                            '</label>'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';        
    });
    
        html+='<div class="col-xs-12 text-center">'+
                '<button type="button" class="btn btn-primary" onclick="AgregarEditarAjax()" id="btn_guardar_evento">Guardar Horario</button>'+
                '<button type="button" class="btn btn-default" onclick="cancelarHP()" id="btn_cancelar_evento">Cancelar</button>'+
              '</div>';

    $("#ModalHorarioPlantilla").html(html);
};




function dependiente(t){
    var id=$(t).attr("id").replace("carrera_","");
    var tCarrera=$(t).val();
    console.log(tCarrera);
    var tCursos ="<option> - Cursos -</option>";
    for (var i = cursos[tCarrera].length - 1; i >= 0; i--) {
        tCursos+="<option value=\""+cursos[tCarrera][i]+"\">"+cursosLbl[cursos[tCarrera][i]]+"</option>";
    }
    $("#curso_"+id).html(tCursos);

}

</script>
