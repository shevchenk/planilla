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

@include( 'proceso.horarioprogramado.js.horarioprogramado_ajax' )
@include( 'proceso.horarioprogramado.js.horarioprogramado' )
@include( 'proceso.horario.js.listapersona_ajax' )
@include( 'proceso.horario.js.listapersona' )

@stop

@section('content')
<section class="content-header">
    <h1>Programaciones
        <small>Proceso</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i>Proceso</li>
        <li class="active">Programaciones</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Horario Programados</h3>
                </div>
                <div class="box-body with-border">
                    <form id="EventoForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Buscar Contratado con Programaciones</center></div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre Completo</label>
                                            <input type="hidden" name="txt_estado" id="txt_estado" class="form-control mant" readonly="" value="1">
                                            <input type="hidden" name="txt_persona_contrato_id" id="txt_persona_contrato_id" class="form-control mant" readonly="">
                                            <input type="hidden" name="txt_tipo_contrato" id="txt_tipo_contrato" class="form-control mant">
                                            <input type="text" class="form-control" id="txt_persona" name="txt_persona" disabled="">
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;&nbsp;&nbsp;</label>
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_buscar_persona" class="btn btn-info btn-flat" data-toggle="modal" data-target="#ModalListapersona" data-filtros="estado:1" data-personaid="EventoForm #txt_persona_contrato_id"  data-persona="EventoForm #txt_persona" data-epersona="1" data-buscarevento="1">Buscar Persona</button>
                                            </span>
                                        </div> 
                                    </div>
                                    <div id="div_horario_programado" class="col-xs-12" style="display: none; overflow: hidden;">
                                        <!--
                                        <div class="col-xs-12" style="padding: 0px;">
                                            <div class="panel panel-info col-md-11" style="padding: 0px;"> 
                                                <div class="panel-heading"> 
                                                    <h3 class="panel-title text-center">HORARIOS PROGRAMADOS</h3>
                                                </div> 
                                                <div class="panel-body">
                                                    
                                                        <div class="col-lg-2">
                                                            <div class="panel panel-danger">
                                                              <div class="panel-heading">
                                                                <h3 class="panel-title text-center"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> LUNES</h3>
                                                              </div>
                                                              <div class="panel-body">
                                                                <p><strong>Hora Ini :</strong> 08:00:20</p>
                                                                <p><strong>Hora Fin :</strong> 13:00:20</p>
                                                                <p class="bg-warning text-center" style="font-weight: bold;">Tolerancia: 10</p>
                                                              </div>
                                                            </div>
                                                        </div>
                                                
                                                </div> 
                                            </div>
                                            <div class="col-md-1" style="padding:0px;">
                                                <div class="">
                                                  <div class="panel-heading">
                                                    <h3 class="panel-title">&nbsp;</h3>
                                                  </div>
                                                  <div class="panel-body">
                                                  </br></br></br>
                                                    <span id="1" onclick="CambiarEstado(0,1)" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i></span>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-xs-12">
                                        <div class='btn btn-primary btn-sm' class="btn btn-primary" onClick="AgregarPlantilla()" style="display: none" id="btn_nuevo">
                                            <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
        <div class="col-xs-12" id="div_horario_plantilla" style="display: none">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">NUEVO HORARIO PROGRAMADO</h3>
                </div>
                <div class="box-body with-border">
                    <form id="ModalHorarioPlantillaForm">
                        <input type="hidden" name="txt_persona_contrato_id" id="txt_persona_contrato_id" class="form-control mant">
                        <div id="ModalHorarioPlantilla" style="overflow: hidden;">
                            <!--<div class="col-xs-12">
                                <div class="panel panel-info col-md-11" style="padding: 0px;"> 
                                    <div class="panel-heading" style="overflow: hidden;"> 
                                        <span class="label" id="" style="font-size: 14px; float:left; padding: 8px; background-color: #fff; color:#666;">LU - VI -SA</span>
                                        <span class="label" id="" style="font-size: 14px; float:right; padding: 8px; background-color: #fff; color:#666;">Mi primera plantilla</span>
                                    </div> 
                                    <div class="panel-body">                                    
                                            <div class="col-lg-2">
                                                <div class="panel panel-warning">
                                                  <div class="panel-heading">
                                                    <h3 class="panel-title text-center"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> LUNES</h3>
                                                  </div>
                                                  <div class="panel-body">
                                                    <p><strong>Hora Ini :</strong> 08:00:20</p>
                                                    <p><strong>Hora Fin :</strong> 13:00:20</p>
                                                    <p><input type="text" class="form-control text-center" id="exampleInputName2" placeholder="Tolerancia"></p>
                                                  </div>
                                                </div>
                                            </div>                                
                                    </div> 
                                </div>
                                <div class="col-md-1" style="padding:0px;">
                                    <div class="">
                                      <div class="panel-heading">
                                        <h3 class="panel-title">&nbsp;</h3>
                                      </div>
                                      <div class="panel-body">
                                      </br></br></br>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox"> <span class="glyphicon glyphicon-arrow-left" style="font-size: 20px;" aria-hidden="true"></span>
                                            </label>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>    
                    </form>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')
@include( 'proceso.horario.form.listapersona' )
@stop
