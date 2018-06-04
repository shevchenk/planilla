<script type="text/javascript">
var AjaxEvento={
    Registrar:function(evento){
        var data=$("#MarcacionForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.MarcacionPR@Marcacion';
        masterG.postAjax(url,data,evento);
    }
};
</script>
