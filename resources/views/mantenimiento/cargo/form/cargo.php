<div class="modal" id="ModalRegimen" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cargos</h4>
            </div>
            <div class="modal-body">
                <form id="ModalRegimenForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" onkeypress="return masterG.validaAlfanumerico(event, this);" class="form-control" id="txt_cargo" name="txt_cargo">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sueldo Mes Base</label>
                            <input type="text" onkeyup="masterG.DecimalMax(this, 2);" onkeypress="return masterG.validaDecimal(event, this);" class="form-control" id="txt_sueldo_mensual_base" name="txt_sueldo_mensual_base">
                        </div>
                    </div>                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Monto Adicional</label>
                            <input type="text" onkeyup="masterG.DecimalMax(this, 2);" onkeypress="return masterG.validaDecimal(event, this);" class="form-control" id="txt_monto_adicional_base" name="txt_monto_adicional_base">
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
