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
};
</script>