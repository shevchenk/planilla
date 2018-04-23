<script type="text/javascript">
var AjaxDatos={
    AgregarEditar:function(evento){
        var data=$("#ModalTipoEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.TipoEventoEM@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.TipoEventoEM@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#TipoEventoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#TipoEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#TipoEventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.TipoEventoEM@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalTipoEventoForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalTipoEventoForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalTipoEventoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalTipoEventoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.TipoEventoEM@EditStatus';
        masterG.postAjax(url,data,evento);
    }
};
</script>
