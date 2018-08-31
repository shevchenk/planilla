<script type="text/javascript">
var AjaxCarrera={
    AgregarEditar:function(evento){
        var data=$("#ModalCarreraForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.CarreraEM@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.CarreraEM@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#CarreraForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#CarreraForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#CarreraForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CarreraEM@Load';
        masterG.postAjax(url,data,evento);
    },
    CambiarEstado:function(evento,AI,id){
        $("#ModalCarreraForm").append("<input type='hidden' value='"+AI+"' name='estadof'>");
        $("#ModalCarreraForm").append("<input type='hidden' value='"+id+"' name='id'>");
        var data=$("#ModalCarreraForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalCarreraForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CarreraEM@EditStatus';
        masterG.postAjax(url,data,evento);
    },
    CargarCurso:function(evento){
        url='AjaxDinamic/Mantenimiento.CursoEM@ListCurso';
        data={};
        masterG.postAjax(url,data,evento);
    }
};
</script>
