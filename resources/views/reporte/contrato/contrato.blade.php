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

@include( 'reporte.contrato.js.contrato_ajax' )
@include( 'reporte.contrato.js.contrato' )

@stop

@section('content')
<section class="content-header">
    <h1>Contratos
        <small>Reporte</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Reporte</a></li>
        <li class="active">Contratos</li>
    </ol>
</section>


<div id="modalContratoDetalle" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalle del contrato</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><center>Contrato</center></div>
                                <div class="panel-body">
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nombre Completo</label>
                                                <span id="lbl_nombre"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>DNI</label>
                                                <span id="lbl_dni"></span>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sede</label>
                                                <span id="lbl_sede"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Consorcio</label>
                                                <span id="lbl_consorcio"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cargo</label>
                                                <span id="lbl_cargo"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Regimen</label>
                                                <span id="lbl_regimen"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado Contrato</label>
                                                <span id="lbl_estado"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipo Contrato</label>
                                                <span id="lbl_tipo"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha Inicial de contrato</label>
                                                <span id="lbl_fecha_ini_contrato"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha Final de contrato</label>
                                                <span id="lbl_fecha_fin_contrato"></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sueldo Mensual</label>
                                                <span id="lbl_sueldo_mensual"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sueldo Producción</label>
                                                <span id="lbl_sueldo_produccion"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Asignación Familiar</label>
                                                <span id="lbl_asignacion_familiar"></span>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label></label>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



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
                                                    <option value='1'>Producción</option>
                                                    <option value='2'>Regular</option>
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
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div><!-- .box-body -->
                </form><!-- .form -->
            </div><!-- .box -->
        </div><!-- .col -->
    



        <div class="col-xs-12" id="listContratos" style="display: none">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Historico de contratos</h3>
                </div>
                <div class="box-body with-border">
                    <table class="table table-hover">
                        <thead>
                            <tr class="cabecera">
                                <th>Sede</th>
                                <th>Consorcio</th>
                                <th>Cargo</th>
                                <th>Regimen</th>
                                <th>Estado</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                        </thead>
                        <tbody id="historicoContratos"> 
                            
                        </tbody>
                        
                        <tfoot></tfoot>
                    </table>
                </div>
                <div class="box-footer">
                    
                </div>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')

@stop
