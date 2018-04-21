<script type="text/javascript">
var Ajaxconsorcio={
    AgregarEditar:function(evento){
        var data=$("#ModalConsorcioForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.consorcioMA@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.consorcioMA@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#consorcioForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#consorcioForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#consorcioForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.consorcioMA@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalConsorcioForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalConsorcioForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalConsorcioForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalConsorcioForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.consorcioMA@EditStatus';
        masterG.postAjax(url,data,evento);
    }
};
</script>
