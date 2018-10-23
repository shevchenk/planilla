@extends('layout.master')  

@section('include')
@parent
{{ Html::style('lib/datatables/dataTables.bootstrap.css') }}
{{ Html::script('lib/datatables/jquery.dataTables.min.js') }}
{{ Html::script('lib/datatables/dataTables.bootstrap.min.js') }}

{{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
{{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
{{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

@include( 'proceso.contrato.js.contrato_ajax' )
@include( 'proceso.contrato.js.contrato' )
@include( 'proceso.contrato.js.listapersona_ajax' )
@include( 'proceso.contrato.js.listapersona' )
@include( 'proceso.contrato.js.aepersona_ajax' )
@include( 'proceso.contrato.js.aepersona' )

@stop

@section('content')
<section class="content-header">
    <h1>Contratos
        <small>Mantenimiento</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mantenimiento</a></li>
        <li class="active">Contratos</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form id="ContratoForm">
                    <div class="box-body table-responsive no-padding">
                        <table id="TableContrato" class="table table-bordered table-hover">
                            <thead>
                                <tr class="cabecera">
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Persona:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_persona" id="txt_persona" placeholder="Persona" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Sede:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_sede" id="txt_sede" placeholder="Sede" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Consorcio:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_consorcio" id="txt_consorcio" placeholder="Consorcio" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Estado de Contrato:</h4></label>
                                            <div class="input-group">
                                                <select class="form-control" name="slct_estado_contrato" id="slct_estado_contrato">
                                                    <option value='' selected>.::Todo::.</option>
                                                    <option value='1'>Vigente</option>
                                                    <option value='2'>Vacaciones</option>
                                                    <option value='3'>Cesante</option>
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Tipo de Contrato:</h4></label>
                                            <div class="input-group">
                                                <select class="form-control" name="slct_tipo_contrato" id="slct_tipo_contrato">
                                                    <option value='' selected>.::Todo::.</option>
                                                    <option value='1'>Irregular</option>
                                                    <option value='2'>Regular</option>
                                                    <option value='3'>Docente</option>
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Modalidad de Contrato:</h4></label>
                                            <div class="input-group">
                                                <select class="form-control" name="slct_modalidad_contrato" id="slct_modalidad_contrato">
                                                    <option value='' selected>.::Todo::.</option>
                                                    <option value='1'>Tiempo completo</option>
                                                    <option value='2'>Tiempo parcial</option>
                                                </select>
                                            </div>
                                        </div>
                                    </th>
<!--                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Estado:</h4></label>
                                            <div class="input-group">
                                                <select class="form-control" name="slct_estado" id="slct_estado">
                                                    <option value='' selected>.::Todo::.</option>
                                                    <option value='0'>Inactivo</option>
                                                    <option value='1'>Activo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </th>-->
                                    <th class="col-xs-1">[-]</th>
                                    <th class="col-xs-1">[-]</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="cabecera">
                                    <th>Persona</th>
                                    <th>Sede</th>
                                    <th>Consorcio</th>
                                    <th>Estado Contrato</th>
                                    <th>Tipo Contrato</th>
                                    <th>[-]</th>
                                    <th>[-]</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class='btn btn-primary btn-sm' class="btn btn-primary" onClick="AgregarEditar(1)" >
                            <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                        </div>
                    </div><!-- .box-body -->
                </form><!-- .form -->
            </div><!-- .box -->
        </div><!-- .col -->
        <div class="col-xs-12" id="Contrato" style="display: none">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Contrato</h3>
                </div>
                <div class="box-body with-border">
                    <form id="ModalContratoForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Contrato</center></div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre Completo</label>
                                            <input type="hidden" name="txt_estado" id="txt_estado" class="form-control mant" readonly="" value="1">
                                            <input type="hidden" name="txt_persona_id" id="txt_persona_id" class="form-control mant" readonly="">
                                            <input type="text" class="form-control" id="txt_persona" name="txt_persona" disabled="">
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;&nbsp;&nbsp;</label>
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_buscar_persona" class="btn btn-info btn-flat" data-toggle="modal" data-target="#ModalListapersona" data-filtros="estado:1" data-personaid="ModalContratoForm #txt_persona_id"  data-persona="ModalContratoForm #txt_persona">Buscar Persona</button>
                                            </span>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sede</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_sede_id" name="slct_sede_id">
                                                <option value="0">.::Seleccione::.</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Consorcio</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_consorcio_id" name="slct_consorcio_id">
                                                <option value="0">.::Seleccione::.</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_cargo_id" name="slct_cargo_id">
                                                <option value="0">.::Seleccione::.</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Regimen</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_regimen_id" name="slct_regimen_id">
                                                <option value="0">.::Seleccione::.</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado Contrato</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_estado_contrato" name="slct_estado_contrato">
                                                <option value="0">.::Seleccione::.</option>
                                                <option value='1'>Vigente</option>
                                                <option value='2'>Vacaciones</option>
                                                <option value='3'>Cesante</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Contrato</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_tipo_contrato" name="slct_tipo_contrato">
                                                <option value="0">.::Seleccione::.</option>
                                                <option value='1'>Irregular</option>
                                                <option value='2'>Regular</option>
                                                <option value='3'>Docente</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Modalidad de Contrato</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_modalidad_contrato" name="slct_modalidad_contrato">
                                                <option value="0">.::Seleccione::.</option>
                                                <option value='1'>Tiempo completo</option>
                                                <option value='2'>Tiempo parcial</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Fecha Inicial de contrato</label>
                                            <input type="text" class="form-control fecha" id="txt_fecha_ini_contrato" name="txt_fecha_ini_contrato" readonly="">
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Fecha Final de contrato</label>
                                            <input type="text" class="form-control fecha" id="txt_fecha_fin_contrato" name="txt_fecha_fin_contrato" readonly="">
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sueldo Mensual</label>
                                            <input type="text" onkeyup="masterG.DecimalMax(this, 2);" onkeypress="return masterG.validaDecimal(event, this);" class="form-control" id="txt_sueldo_mensual" name="txt_sueldo_mensual" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Asignación Familiar</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_asignacion_familiar" name="slct_asignacion_familiar">
                                                <option value="0">No</option>
                                                <option value='1'>Si</option>
                                            </select>
                                        </div> 
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Monto adicional</label>
                                            <input type="text" onkeyup="masterG.DecimalMax(this, 2);" onkeypress="return masterG.validaDecimal(event, this);" class="form-control" id="txt_monto_adicional" name="txt_monto_adicional" readonly="">
                                        </div>
                                        
                                        <div class="form-group">
                                                    

                                            
                                            <div id="extraDiv"></div>
                                           <hr>
<button onClick="agregarExtra();return false;" class="btn btn-info"><i class="fa fa-plus"></i> Agregar pago extra</button><hr>
                                            
                                            
                                        </div>
                                        
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label></label>
                        </div>

                    </form>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right" onclick="AgregarEditarAjax()">Guardar Contrato</button>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->

<script type="text/javascript">
    
    var iterator = 0;
    function agregarExtra(n,m){

        n = n || "";
        m = m || "";

        var div ="";
        div+='<div class="row" id="extra_'+iterator+'">';
        div+='<div class="col-md-4"> <input type="text" class="form-control" placeholder="Nombre: Ej. Bono hogar." name="nombre_extra[]" value="'+n+'"></div>';
        div+='<div class="col-md-4"><input type="text" class="extraMonto form-control" placeholder="Monto: Ej. 200" name="monto_extra[]" value="'+m+'" onkeyup="calcExtra();" onkeypress="return isNumber(event)"></div>';
        div+='<div class="col-md-4"><button onClick="removeExtra(\''+iterator+'\');return false;" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></div>';
        div+='<br></div>';

        $("#extraDiv").append(div);

        iterator++;
    }


    function removeExtra(it){
        $('#extra_'+it).remove();
    }


    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }        
        return true;
    }

    function calcExtra(){        
        var montoTotal = 0;

        $(".extraMonto").each(function( index ) {
            console.log("extra plus."+index);
            montoTotal=parseInt(montoTotal)+ parseInt($( this ).val());
        });

        $("#txt_monto_adicional").val(montoTotal);
    }


</script>
@stop

@section('form')
@include( 'proceso.contrato.form.listapersona' )
@include( 'mantenimiento.persona.form.persona' )
@stop
