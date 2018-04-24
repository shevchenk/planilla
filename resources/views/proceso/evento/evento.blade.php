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

@include( 'proceso.evento.js.evento_ajax' )
@include( 'proceso.evento.js.evento' )
@include( 'proceso.evento.js.listapersona_ajax' )
@include( 'proceso.evento.js.listapersona' )

@stop

@section('content')
<section class="content-header">
    <h1>Eventos
        <small>Proceso</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i>Proceso</li>
        <li class="active">Eventos</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Evento</h3>
                </div>
                <div class="box-body with-border">
                    <form id="EventoForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Buscar Persona con Evento</center></div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre Completo</label>
                                            <input type="hidden" name="txt_estado" id="txt_estado" class="form-control mant" readonly="" value="1">
                                            <input type="hidden" name="txt_persona_contrato_id" id="txt_persona_contrato_id" class="form-control mant" readonly="">
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
                                    <div class="col-xs-12">
                                        <table id="TableEvento" class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="cabecera">
                                                    <th class="col-xs-2">
                                                        <div class="form-group">
                                                            <label><h4>Evento Tipo:</h4></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                                <input type="text" class="form-control" name="txt_evento_tipo" id="txt_evento_tipo" placeholder="Evento Tipo" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th class="col-xs-2">
                                                        <div class="form-group">
                                                            <label><h4>Evento Descripcion:</h4></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                                <input type="text" class="form-control" name="txt_evento_descripcion" id="txt_evento_descripcion" placeholder="Evento Descripción" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th class="col-xs-1">[-]</th>
                                                    <th class="col-xs-1">[-]</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr class="cabecera">
                                                    <th>Evento Tipo</th>
                                                    <th>Evento Descripción</th>
                                                    <th>[-]</th>
                                                    <th>[-]</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class='btn btn-primary btn-sm' class="btn btn-primary" onClick="AgregarEditar(1)" style="display: none" id="btn_nuevo">
                                            <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
        <div class="col-xs-12" id="Evento" style="display: none">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Evento</h3>
                </div>
                <div class="box-body with-border">
                    <form id="ModalEventoForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Evento</center></div>
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha Inicio</label>
                                            <input type="hidden" name="txt_estado" id="txt_estado" class="form-control mant" readonly="" value="1">
                                            <input type="hidden" name="txt_persona_contrato_id" id="txt_persona_contrato_id" class="form-control mant" readonly="">
                                            <input type="text" class="form-control fecha" id="txt_fecha_inicio" name="txt_fecha_inicio" readonly="">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha Fin</label>
                                            <input type="text" class="form-control fecha" id="txt_fecha_fin" name="txt_fecha_inicio" readonly="">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hora Inicio</label>
                                            <input type="time" class="form-control" id="txt_hora_inicio" name="txt_hora_inicio" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hora Fin</label>
                                            <input type="time" class="form-control" id="txt_hora_fin" name="txt_hora_fin" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Evento Descripción</label>
                                            <input type="text" class="form-control" id="txt_evento_descripcion" name="txt_evento_descripcion">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Evento Tipo</label>
                                            <select  class="form-control selectpicker show-menu-arrow" data-live-search="true" id="slct_evento_tipo_id" name="slct_evento_tipo_id">
                                                <option value="0">.::Seleccione::.</option>
                                            </select>
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
                    <button type="submit" class="btn btn-info pull-right" onclick="AgregarEditarAjax()" id="btn_guardar_evento">Guardar Evento</button>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')
@include( 'proceso.evento.form.listapersona' )
@stop
