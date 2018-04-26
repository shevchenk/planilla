<div class="modal" id="ModalDatos" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Horario Plantilla</h4>
            </div>
            <div class="modal-body">
                <form id="ModalHorarioPlantillalForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Plantilla</label>
                            <input type="text" class="form-control" id="txt_plantilla_descripcion" name="txt_plantilla_descripcion">
                        </div>
                    </div> 
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dias</label>
                            <div class="form-group">
                                <select class="form-control selectpicker show-menu-arrow" multiple data-actions-box="true" data-live-search="true" name="slct_dia_ids[]" id="slct_dia_ids">
                                </select>  
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Horario Amanecida</label>
                            <div class="form-group">
                                <select class="form-control selectpicker show-menu-arrow" name="slct_horario_amanecida" id="slct_horario_amanecida">
                                    <option value='0'>NO</option>
                                    <option value='1'>SI</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hora Inicio</label>
                            <input type="text" class="form-control time" id="txt_hora_inicio" placeholder="00:00:00" name="txt_hora_inicio">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hora Fin</label>
                            <input type="text" class="form-control time" id="txt_hora_fin" placeholder="00:00:00" name="txt_hora_fin">
                        </div>
                    </div> 

                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control selectpicker show-menu-arrow" name="slct_estado" id="slct_estado">
                                <option  value='0'>Inactivo</option>
                                <option  value='1'>Activo</option>
                            </select>
                        </div>
                    </div>
                     <div class="form-group"> 
                         <label></label>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
