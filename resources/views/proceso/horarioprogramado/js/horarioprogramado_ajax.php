<script type="text/javascript">
var AjaxDato={
    AgregarEditar:function(evento){
        var data=$("#ModalHorarioPlantillaForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@New';
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        data={};
        url='AjaxDinamic/Proceso.HorarioProgramadoPR@Load';
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
        data={};
        masterG.postAjax(url,data,evento);
    },
    
};
</script>
