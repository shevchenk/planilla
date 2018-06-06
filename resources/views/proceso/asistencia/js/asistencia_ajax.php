<script type="text/javascript">
var AjaxHorario={
    Cargar:function(data,evento){
        url='AjaxDinamic/Proceso.PersonaContratoPR@LoadReporteHorario';
        masterG.postAjax(url,data,evento);
    },
    CargarSede:function(evento){
        url='AjaxDinamic/Mantenimiento.SedeMA@ListSede';
        data={};
        masterG.postAjax(url,data,evento);
    },
    CargarConsorcio:function(evento){
        url='AjaxDinamic/Mantenimiento.ConsorcioMA@ListConsorcio';
        data={};
        masterG.postAjax(url,data,evento);
    },
    CargarAsistencia:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ListaAsistenciaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ListaAsistenciaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ListaAsistenciaForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.AsistenciaPR@LoadAsistencia';
        masterG.postAjax(url,data,evento);
    },
    CargarEvento:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ListaEventoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ListaEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ListaEventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.AsistenciaPR@LoadEvento';
        masterG.postAjax(url,data,evento);
    },
};
</script>