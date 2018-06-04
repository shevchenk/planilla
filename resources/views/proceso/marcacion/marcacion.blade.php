@extends('layout.master')  

@section('include')
@parent

@include( 'proceso.marcacion.js.marcacion_ajax' )
@include( 'proceso.marcacion.js.marcacion' )

@stop

@section('content')
<section class="content-header">
    <h1>Marcación
        <small>Proceso</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i>Proceso</li>
        <li class="active">Marcación</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Marcación</h3>
                </div>
                <div class="box-body with-border">
                    <form id="MarcacionForm">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Marcación - Asistencia</center></div>
                                <div class="panel-body">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Digite su DNI:</label>
                                            <input type="text" class="form-control" onkeypress="masterG.enterGlobal(event,'#btn_marcacion');" id="txt_dni" name="txt_dni">
                                            <a class="btn btn-primary btn-sm col-md-12" id="btn_marcacion" onclick="Registrar();">.::Validar::.</a>
                                        </div> 
                                    </div>
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

@stop
