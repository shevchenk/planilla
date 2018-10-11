<script type="text/javascript">
var AjaxDato={
    AgregarEditar:function(evento){
        var data=$("#ModalHorarioPlantillaForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@New';
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        data={ persona_contrato_id : $('#txt_persona_contrato_id').val()};
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CargarCursos:function(evento){
        data={};
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@LoadCursos';
        masterG.postAjax(url,data,evento);
    },  
    CambiarEstado:function(evento,AI,id){
        $("#EventoForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#EventoForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#EventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#EventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    /*
    CargarEventoTipo:function(evento){
        url='AjaxDinamic/Mantenimiento.TipoEventoEM@ListTipoEvento';
        data={};
        masterG.postAjax(url,data,evento);
    },
    */
    CargarHorarioPlantilla:function(evento,pag){
        url='AjaxDinamic/Mantenimiento.HorarioPlantillaMA@ListHorarioPlantilla';
        data={persona_contrato_id:$("#EventoForm #txt_persona_contrato_id").val()};
        masterG.postAjax(url,data,evento);
    },
    
};
</script>
