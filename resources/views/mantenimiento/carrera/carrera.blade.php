@extends('layout.master')  

@section('include')
    @parent
    {{ Html::style('lib/datatables/dataTables.bootstrap.css') }}
    {{ Html::script('lib/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('lib/datatables/dataTables.bootstrap.min.js') }}

    {{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
    {{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
    {{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

    @include( 'mantenimiento.carrera.js.carrera_ajax' )
    @include( 'mantenimiento.carrera.js.carrera' )
@stop

@section('content')
<section class="content-header">
    <h1>Carrera
        <small>Mantenimiento</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mantenimiento</a></li>
        <li class="active">Carrera</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form id="CarreraForm">
                    <div class="box-body table-responsive no-padding">
                        <table id="TableCarrera" class="table table-bordered table-hover">
                            <thead>
                                <tr class="cabecera">

                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Carrera:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_carrera" id="txt_carrera" placeholder="Buscar Carrera" onkeypress="return masterG.enterGlobal(event,'.input-group',1);">
                                            </div>                                          
                                        </div>
                                    </th>
<!--                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Certificado Carrera:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_certificado_carrera" id="txt_certificado_carrera" placeholder="Buscar Certificado Carrera" onkeypress="return masterG.enterGlobal(event,'.input-group',1);">
                                            </div>                                          
                                        </div>
                                    </th>-->
                                    <th class="col-xs-2">
                                        <div class="form-group">
                                            <label><h4>Cursos Asignados:</h4></label>
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

                                  <th>Carrera</th>
                                      <!--<th>Certificado Carrera</th>-->
                                  <th>Cursos Asignados</th>
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
     @include( 'mantenimiento.carrera.form.carrera' )
@stop
