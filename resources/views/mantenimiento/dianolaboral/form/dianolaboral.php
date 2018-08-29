<div class="modal" id="ModalDatos" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dias No Laborables</h4>
            </div>
            <div class="modal-body">
                <form id="ModalDiaNoLaboralForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" class="form-control fecha" id="txt_fecha" name="txt_fecha" readonly="" >
                        </div>
                    </div> 
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Sedes</label>
                            <div class="form-group">
                                <select class="form-control selectpicker show-menu-arrow" multiple data-actions-box="true" data-live-search="true" name="slct_sede_ids[]" id="slct_sede_ids">
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

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pago</label>
                            <select class="form-control selectpicker show-menu-arrow" name="slct_pago" id="slct_pago">
                                <option  value='1'>1 Día</option>
                                <option  value='1.5'>1.5 Días</option>
                                <option  value='2'>2.0 Días</option>
                                <option  value='2.5'>2.5 Días</option>
                                <option  value='3'>3 Días</option>
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
