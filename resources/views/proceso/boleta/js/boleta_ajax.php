<script type="text/javascript">
var AjaxEvento={
    AgregarEditar:function(evento){
        var data=$("#ModalEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.EventoPR@New';
        if(AddEdit==0){
            url='AjaxDinamic/Proceso.EventoPR@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#EventoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#EventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#EventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.PersonaContratoPR@LoadBoleta';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalEventoForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalEventoForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalEventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.EventoPR@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    CargarEventoTipo:function(evento){
        url='AjaxDinamic/Mantenimiento.TipoEventoEM@ListTipoEvento';
        data={};
        masterG.postAjax(url,data,evento);
    },
};
</script>
