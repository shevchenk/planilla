<script type="text/javascript">
var AjaxContrato={
    AgregarEditar:function(evento){
        var data=$("#ModalContratoForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.ContratoPR@New';
        if(AddEdit==0){
            url='AjaxDinamic/Proceso.PersonaContratoPR@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ContratoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ContratoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ContratoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.PersonaContratoPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalContratoForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalContratoForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalContratoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalContratoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Proceso.PersonaContratoPR@EditStatus';
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
    CargarCargo:function(evento){
        url='AjaxDinamic/Mantenimiento.CargoEM@ListCargo';
        data={};
        masterG.postAjax(url,data,evento);
    },
    CargarRegimen:function(evento){
        url='AjaxDinamic/Mantenimiento.RegimenEM@ListRegimen';
        data={};
        masterG.postAjax(url,data,evento);
    },
};
</script>
