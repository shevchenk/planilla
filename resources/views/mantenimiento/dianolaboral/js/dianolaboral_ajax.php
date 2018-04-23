<script type="text/javascript">
var AjaxDatos={
    AgregarEditar:function(evento){
        var data=$("#ModalDiaNoLaboralForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.DiaNoLaboralMA@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.DiaNoLaboralMA@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#DiaNoLaboralForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#DiaNoLaboralForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#DiaNoLaboralForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.DiaNoLaboralMA@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalDiaNoLaboralForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalDiaNoLaboralForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalDiaNoLaboralForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalDiaNoLaboralForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.DiaNoLaboralMA@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    CargarSede:function(evento){
        url='AjaxDinamic/Mantenimiento.SedeMA@ListSede';
        data={};
        masterG.postAjax(url,data,evento);
    }
};
</script>
