<!-- /.modal -->
<div class="modal fade" id="ModalListaEvento" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista Evento</h4>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="box">
                        <form id="ListaEventoForm">
                            <input type="hidden" class="mant" id="txt_estado" name="txt_estado"value="1">
                            <input type="hidden" class="mant" id="txt_asistencia_id" name="txt_asistencia_id">
                            <div class="box-body table-responsive no-padding">
                                <table id="TableListaevento" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="cabecera">
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Fecha Inicio:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_fecha_inicio" id="txt_fecha_inicio" placeholder="Fecha Inicio" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Hora Inicio:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_hora_inicio" id="txt_hora_inicio" placeholder="Hora Inicio" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Fecha Fin:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_fecha_fin" id="txt_fecha_fin" placeholder="Fecha Fin" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Hora Fin:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_hora_fin" id="txt_hora_fin" placeholder="Hora Fin" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>  
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Descripcion:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_evento_descripcion" id="txt_evento_descripcion" placeholder="Descripción" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-3">
                                                <div class="form-group">
                                                    <label><h4>Tipo Evento:</h4></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                        <input type="text" class="form-control" name="txt_evento_tipo" id="txt_evento_tipo" placeholder="Evento Tipo" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="col-xs-2">
                                                <div class="form-group">
                                                    <label><h4>Aplica Cambio:</h4></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="slct_aplica_cambio" id="slct_aplica_cambio">
                                                            <option value='' selected>.::Todo::.</option>
                                                            <option value='0'>Cambio a Todo</option>
                                                            <option value='1'>Fecha Inicio</option>
                                                            <option value='2'>Fecha Fin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr class="cabecera">
                                            <th>Fecha Inicio</th>
                                            <th>Hora Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Hora Fin</th>
                                            <th>Descripción</th>
                                            <th>Tipo Evento</th>
                                            <th>Aplica Cambio</th>
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
