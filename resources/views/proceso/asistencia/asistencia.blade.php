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

@include( 'reporte.horario.js.horario_ajax' )
@include( 'reporte.horario.js.horario' )
@stop

@section('content')
<style>
    .modal { overflow: auto !important; }
</style>
<section class="content-header">
    <h1>Horarios Programados
        <small>Reporte</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Reportes</li>
        <li class="active">Horarios Programados</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Horario</h3>
                </div>
                <div class="box-body with-border">
                    <form id="HorarioForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Buscar Persona con Horario</center></div>
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <div class="col-sm-2">
                                            <label class="control-label">Fecha Inicio</label>
                                            <div class="input-group">
                                                <span id="spn_fecha_ini" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                                <input type="text" class="form-control fecha"  id="txt_fecha_inicio" name="txt_fecha_inicio" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Fecha Final</label>
                                            <div class="input-group">
                                                <span id="spn_fecha_fin" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                                <input type="text" class="form-control fecha"  id="txt_fecha_final" name="txt_fecha_final" readonly/>
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
                                        <div class="col-sm-1" style="padding:24px">
                                            <span class="btn btn-primary btn-md" id="btn_generar" name="btn_generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                        </div>
                                        <div class="col-sm-1 hidden" style="padding:24px" >
                                            <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="box-body table-responsive">
                                            <table id="TableHorario" class="table table-bordered table-hover" style="display: none">
                                                <thead>
                                                    <tr class="cabecera">
                                                        <th>Sede</th>
                                                        <th>Consorcio</th>
                                                        <th>Persona</th>
                                                        <th>DNI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="cabecera">
                                                        <th>Sede</th>
                                                        <th>Consorcio</th>
                                                        <th>Persona</th>
                                                        <th>DNI</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
@stop
<!--@section('form')
@include( 'reporte.horario.form.listaasistencia' )
@include( 'reporte.horario.form.listaevento' )
@stop-->
