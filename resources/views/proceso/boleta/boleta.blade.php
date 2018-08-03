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

{{ HTML::script('lib/input-mask/js/jquery.inputmask.js') }}
{{ HTML::script('lib/input-mask/js/jquery.inputmask.date.extensions.js') }}

@include( 'proceso.boleta.js.boleta_ajax' )
@include( 'proceso.boleta.js.boleta' )
@include( 'proceso.boleta.js.listapersona_ajax' )
@include( 'proceso.boleta.js.listapersona' )

@stop

@section('content')
<section class="content-header">
    <h1>Boletas
        <small>Proceso</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i>Proceso</li>
        <li class="active">Boletas</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Boleta</h3>
                </div>
                <div class="box-body with-border">
                    <form id="EventoForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Buscar Boletas de Persona</center></div>
                                <div class="panel-body">
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
                                                <button type="button" id="btn_buscar_persona" class="btn btn-info btn-flat" data-toggle="modal" data-target="#ModalListapersona" data-filtros="estado:1" data-personaid="EventoForm #txt_persona_id"  data-persona="EventoForm #txt_persona" data-epersona="1" data-buscarevento="1">Buscar Persona</button>
                                            </span>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;&nbsp;&nbsp;</label>
                                            <a class="btn btn-white pull-right" onclick="VerBoleta(0)"><i class="fa fa-search fa-lg"></i>Ver Todas las Boletas</a>
                                        </div> 
                                    </div>
                                    <div class="col-xs-12">
                                        <table id="TableEvento" class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="cabecera">
                                                    <th class="col-xs-2">
                                                        <div class="form-group">
                                                            <label><h4>Sueldo Bruto:</h4></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                                <input type="text" class="form-control" name="txt_sueldo_bruto" id="txt_sueldo_bruto" placeholder="Sueldo Bruto" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th class="col-xs-2">
                                                        <div class="form-group">
                                                            <label><h4>Sueldo Neto:</h4></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                                <input type="text" class="form-control" id="txt_sueldo_neto" name="txt_sueldo_neto" placeholder="Sueldo Neto" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th class="col-xs-2">
                                                        <div class="form-group">
                                                            <label><h4>Descuento:</h4></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                                <input type="text" class="form-control" id="txt_descuento" name="txt_descuento" placeholder="Descuento"  onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th class="col-xs-1">[-]</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr class="cabecera">
                                                    <th>Sueldo Bruto</th>
                                                    <th>Sueldo Neto</th>
                                                    <th>Descuento</th>
                                                    <th>[-]</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <!--                                        <div class='btn btn-primary btn-sm' class="btn btn-primary" onClick="AgregarEditar(1)" style="display: none" id="btn_nuevo">
                                                                                    <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                                                                                </div>-->
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

@section('form')
@include( 'proceso.boleta.form.listapersona' )
@stop
