<script type="text/javascript">
var AjaxPersona={
    AgregarEditar:function(evento){
        $("#ModalPersonaForm input[name='cargos_selec']").remove();
        $("#ModalPersonaForm").append("<input type='hidden' value='"+cargos_selec+"' name='cargos_selec'>");

        $("#ModalPersonaForm input[name='grados_selec']").remove();
        $("#ModalPersonaForm").append("<input type='hidden' value='"+grados_selec+"' name='grados_selec'>");

        $("#ModalPersonaForm input[name='investiga_selec']").remove();
        $("#ModalPersonaForm").append("<input type='hidden' value='"+investiga_selec+"' name='investiga_selec'>");

        $("#ModalPersonaForm input[name='publica_selec']").remove();
        $("#ModalPersonaForm").append("<input type='hidden' value='"+publica_selec+"' name='publica_selec'>");
        var data=$("#ModalPersonaForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.PersonaEM@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.PersonaEM@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#PersonaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#PersonaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#PersonaForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.PersonaEM@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalPersonaForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalPersonaForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalPersonaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalPersonaForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.PersonaEM@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    CargarPrivilegio:function(evento){
        url='AjaxDinamic/Mantenimiento.PersonaEM@ListPrivilegio';
        data={};
        masterG.postAjax(url,data,evento);
    },
    CargarSede:function(evento){
        url='AjaxDinamic/Mantenimiento.SedeMA@ListSede';
        data={};
        masterG.postAjax(url,data,evento,null,false);
    },
    CargarConsorcio:function(evento){
        url='AjaxDinamic/Mantenimiento.ConsorcioMA@ListConsorcio';
        data={};
        masterG.postAjax(url,data,evento,null,false);
    },
    CargarAreas:function(evento,persona){
        url='AjaxDinamic/Mantenimiento.PersonaEM@CargarAreas';
        data={persona_id:persona};
        masterG.postAjax(url,data,evento);
    },
    CargarGrados:function(evento,persona){
        url='AjaxDinamic/Mantenimiento.PersonaEM@CargarGrados';
        data={persona_id:persona};
        masterG.postAjax(url,data,evento);
    },
    CargarInvestigaciones:function(evento,persona){
        url='AjaxDinamic/Mantenimiento.PersonaEM@CargarInvestigaciones';
        data={persona_id:persona};
        masterG.postAjax(url,data,evento);
    },
    CargarPublicaciones:function(evento,persona){
        url='AjaxDinamic/Mantenimiento.PersonaEM@CargarPublicaciones';
        data={persona_id:persona};
        masterG.postAjax(url,data,evento);
    },
};
</script>
