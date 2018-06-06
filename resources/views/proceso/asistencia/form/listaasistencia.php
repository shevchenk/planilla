<!-- /.modal -->
<div class="modal fade" id="ModalListaAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista Asistencia</h4>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="box">
                        <form id="ListaAsistenciaForm">
                            <input type="hidden" class="mant" id="txt_estado" name="txt_estado"value="1">
                            <input type="hidden" class="mant" id="txt_fecha" name="txt_fecha">
                            <input type="hidden" class="mant" id="txt_persona_contrato_id" name="txt_persona_contrato_id">
                            <div class="box-body table-responsive no-padding">
                                <table id="TableListaasistencia" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="cabecera">
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Fecha Ingreso:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_fecha_ingreso" id="txt_fecha_ingreso" placeholder="Fecha Ingreso" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Hora Ingreso:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_hora_ingreso" id="txt_hora_ingreso" placeholder="Hora Ingreso" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Fecha Salida:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_fecha_salida" id="txt_fecha_salida" placeholder="Fecha Salida" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Hora Salida:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_hora_salida" id="txt_hora_salida" placeholder="Hora Salida" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>                                   
                                            <th class="col-xs-1">[Eventos]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr class="cabecera">
                                            <th>Fecha Ingreso</th>
                                            <th>Hora Ingreso</th>
                                            <th>Fecha Salida</th>
                                            <th>Hora Salida</th>
                                            <th>[Eventos]</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><!-- .box-body -->
                        </form><!-- .form -->   
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary active pull-right" onclick="AgregarEditar2(1)">Nuevo</button>-->
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
