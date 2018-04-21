<script type="text/javascript">
var AjaxRegimen={
    AgregarEditar:function(evento){
        var data=$("#ModalRegimenForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.RegimenEM@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.RegimenEM@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#RegimenForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#RegimenForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#RegimenForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.RegimenEM@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalRegimenForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalRegimenForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalRegimenForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalRegimenForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.RegimenEM@EditStatus';
        masterG.postAjax(url,data,evento);
    }
};
</script>
