@extends('layout.master')  

@section('include')
@parent
{{ Html::style('lib/datatables/dataTables.bootstrap.css') }}
{{ Html::script('lib/datatables/jquery.dataTables.min.js') }}
{{ Html::script('lib/datatables/dataTables.bootstrap.min.js') }}

{{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
{{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
{{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

@include( 'mantenimiento.consorcio.js.consorcio_ajax' )
@include( 'mantenimiento.consorcio.js.consorcio' )
@stop

@section('content')
<section class="content-header">
    <h1>Consorcios
        <small>Mantenimiento</small>
        <!--<a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>-->
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mantenimiento</a></li>
        <li class="active">Consorcios</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form id="consorcioForm">
                    <div class="box-body table-responsive no-padding">
                        <table id="Tableconsorcio" class="table table-bordered table-hover">
                            <thead>

                                <tr class="cabecera">
                                    <th class="col-xs-1">
                                        <div class="form-group">
                                            <label><h4>Logo de Consorcio:</h4></label>
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
                                    <th class="col-xs-1">
                                        <div class="form-group">
                                            <label><h4>Consorcio apocope:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_consorcio_apocope" id="txt_consorcio_apocope" placeholder="Consorcio apocope" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>

                                    <th class="col-xs-1">
                                        <div class="form-group">
                                            <label><h4>RUC:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" maxlength="11" class="form-control" name="txt_ruc" id="txt_ruc" placeholder="RUC" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-2">
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
                                    </th>
                                    <th class="col-xs-1">[-]</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="cabecera">
                                    <th>Logo</th>
                                    <th>consorcio</th>
                                    <th>Consorcio Apocope</th>

                                    <th>RUC</th>
                                    <th>Estado</th>
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
    </div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')
@include( 'mantenimiento.consorcio.form.consorcio' )
@stop
