<script type="text/javascript">
var AjaxDatos={
    AgregarEditar:function(evento){
        var data=$("#ModalHorarioPlantillalForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.HorarioPlantillaMA@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.HorarioPlantillaMA@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#DiaHorarioPlantillaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#DiaHorarioPlantillaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#DiaHorarioPlantillaForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.HorarioPlantillaMA@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalHorarioPlantillalForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalHorarioPlantillalForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalHorarioPlantillalForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalHorarioPlantillalForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.HorarioPlantillaMA@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    CargarDia:function(evento){
        url='AjaxDinamic/Mantenimiento.DiaMA@Load';
        data={};
        masterG.postAjax(url,data,evento);
    }
};
</script>
