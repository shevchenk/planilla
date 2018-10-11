<div class="modal" id="ModalConsorcio" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Consorcio</h4>
            </div>
            <div class="modal-body">
                <form id="ModalConsorcioForm">
                    <!--                    <div class="col-md-12">
                                            <label>Docente</label>
                                        </div>
                                            <div class="input-group margin">
                                                <input type="hidden" class="form-control mant" id="txt_docente_id" name="txt_docente_id" readOnly="">
                                                <input type="hidden" name="txt_persona_id" id="txt_persona_id" class="form-control mant" readonly="">
                                                <input type="text" class="form-control" id="txt_docente" name="txt_docente"  disabled="">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#ModalListadocente" data-filtros="estado:1" data-personaid="ModalConsorcioForm #txt_persona_id" data-docenteid="ModalConsorcioForm #txt_docente_id" data-docente="ModalConsorcioForm #txt_docente">Buscar</button>
                                                </span>
                                            </div>           -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Consorcio</label>
                            <input type="text" onkeypress="return masterG.validaAlfanumerico(event, this);" class="form-control" id="txt_consorcio" name="txt_consorcio">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Consorcio Apocope</label>
                            <input type="text" onkeypress="return masterG.validaAlfanumerico(event, this);" class="form-control" id="txt_consorcio_apocope" name="txt_consorcio_apocope">                        </div>
                    </div>                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ruc</label>
                            <input type="text" maxlength="11" onkeypress="return masterG.validaNumeros(event,this,'ruc');" class="form-control" id="txt_ruc" name="txt_ruc">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="text"  readOnly class="form-control input-sm" id="txt_imagen_nombre"  name="txt_imagen_nombre" value="">
                            <input type="text" style="display: none;" id="txt_imagen_archivo" name="txt_imagen_archivo">
                            <label class="btn btn-default btn-flat margin btn-xs">
                                <i class="fa fa-file-image-o fa-lg"></i>
                                <input type="file" style="display: none;" onchange="onImagen(event);" >
                            </label>

                        </div>  
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <img class="img-circle" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px"> 
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
