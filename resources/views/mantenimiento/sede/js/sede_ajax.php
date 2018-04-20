<script type="text/javascript">
var AjaxSede={
    AgregarEditar:function(evento){
        var data=$("#ModalSedeForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.SedeMA@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.SedeMA@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#SedeForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#SedeForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#SedeForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.SedeMA@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalSedeForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalSedeForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalSedeForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalSedeForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.SedeMA@EditStatus';
        masterG.postAjax(url,data,evento);
    }
};
</script>
