<div class="modal" id="ModalEventoTipo" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tipo Evento</h4>
            </div>
            <div class="modal-body">
                <form id="ModalTipoEventoForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tipo</label>
                            <input type="text" onkeypress="return masterG.validaAlfanumerico(event, this);" class="form-control" id="txt_evento_tipo" name="txt_evento_tipo">
                        </div>
                    </div> 
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Aplica Descuento</label>
                            <div class="form-group">
                                <select class="form-control selectpicker show-menu-arrow" name="slct_aplica_dscto" id="slct_aplica_dscto">
                                    <option value='0'>NO</option>
                                    <option value='1'>SI</option>
                                </select>
                            </div>
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
