@extends('layout.master')  

@section('include')
    @parent

    {{ Html::style('css/multi-select.css') }}


    {{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

    {{ Html::script('js/jquery.multi-select.js') }}
@stop

@section('content')
<section class="content-header">
    <h1>Planilla
        <small>Bienvenido</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Planilla</a></li>
        <li class="active">Generar</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Planillas generadas</h3>
                </div>

                <div class="box-body with-border">
                	<div class="row" align="center">
                		<div class="col-md-3">
	                		<b>Consorcio</b>
	                	</div>
	                	<div class="col-md-4">
		                	<div class="col-md-6">
		                		<b>Fecha Inicial</b>
		                	</div>
		                	<div class="col-md-6">
		                		<b>Fecha Final</b>
		                	</div>
	                	</div>
                	</div>

                	<div class="row">
                		<div class="col-md-3">
	                		<select class="form-control" id="fconsorcio">
		                	</select>
	                	</div>
	                	<div class="col-md-4">
		                	<div class="col-md-6">
		                		<input type="text" id="ffecha_ini" class="form-control fecha" placeholder="Año-Mes-Día">
		                	</div>
		                	<div class="col-md-6">
		                		<input type="text" id="ffecha_fin" class="form-control fecha" placeholder="Año-Mes-Día">
		                	</div>
	                	</div>

		                	<div class="col-md-2">
		                		<button class="btn btn-success">Filtrar</button>
		                	</div>
                	</div>
<div class="row">&nbsp;</div>
                	<table class="table table-hover table-stripped">
                		<thead>
                			<tr>
                				<th>ID</th>
                				<th>Consorcio</th>
                				<th>Fecha</th>
                				<th>Trabajadores</th>
                				<th>Total Neto</th>
                				<th>Total Descuentos</th>
                				<th>Total Aporte</th>
                				<th>Ver</th>
                			</tr>
                		</thead>
                		<tbody id="tbBody">


                		</tbody>
                	</table>
                </div>

            </div>

                        <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Planillas</h3>
                </div>

                <div class="box-body with-border">



<br>

<div class="form-group">
	<p>Seleccione consorcio.</p>
	<div class="col-md-6">
		<select id="gconsorcio" class="form-control" onchange="loadFecha(this.value);">
			<option value=""> - Consorcios - </option>	
		</select>
	</div>
	
	<div class="col-md-2">
		<input type="text" id="gfecha" class="form-control fecha" placeholder="Año-Mes-Día">
	</div>


	<div class="col-md-12">&nbsp;</div>
	<div class="col-md-12">
		<div align="center">
			<button onClick="generarPlanilla();" class="btn btn-success">Generar Planilla</button>
		</div>
	</div>

	<br>

	<span id="result"></span>
</dv>




<script type="text/javascript">
	
	var consorcios = [];

	function cargarConsorcios(){
		$.post("AjaxDinamic/Proceso.Planilla@verConsorcios",function(data){
			
			var xhtml = "<option value=\"\"> - Seleccione consorcio - </option>";
			var xhtml2 = "<option value=\"\"> - Seleccione consorcio - </option>";


			for (var i = data.length - 1; i >= 0; i--){
				var fech = data[i].fecha_ultima_planilla == null ? 'Nuevo' : data[i].fecha_ultima_planilla;
				consorcios[data[i].id] = data[i].fecha_ultima_planilla;
				xhtml = xhtml+"<option value="+data[i].id+">"+data[i].consorcio+" - "+fech+"</option>";
				xhtml2 = xhtml2+"<option value="+data[i].id+">"+data[i].consorcio+"</option>";
			}			

			$("#gconsorcio").html(xhtml);
			$("#fconsorcio").html(xhtml2);
		});
	}


	function generarPlanilla(){

		$.post("AjaxDinamic/Proceso.Planilla@generar",{consorcio:$("#gconsorcio").val(),fecha:$("#gfecha").val()},function(data){
			
			$("#result").html(data);
			cargarPlanillas();

		});
	}

	function verPlanilla(idp){
		newwindow=window.open("verPlanillaDetalle/"+idp);
		if (window.focus) {newwindow.focus()}
		return false;
	}

	function cargarPlanillas(filtrar=0){
		var params = {};
		if(filtrar=!0){
			var params = {ffecha_ini:$("#ffecha_ini").val(),ffecha_fin:$("#ffecha_fin").val(),fconsorcio:$("#fconsorcio").val()}
		}

		$.post("AjaxDinamic/Proceso.Planilla@verPlanillas",params,function(data){
			var mTr = "";
			var totalBruto = 0;
			var totalAporte = 0;
			var totalDescuento = 0;
			var totalNeto = 0;
			
			for (var i = 0; i < data.length; i++) {

				totalBruto = data[i].total_bruto;
				totalNeto = data[i].total_neto;
				totalAporte = data[i].total_aporte;
				totalDescuento = data[i].total_descuentos;

				mTr = mTr + "<tr>";
				mTr = mTr + "	<td>"+data[i].id+"</td>";
				mTr = mTr + "	<td>"+data[i].consorcio+"</td>";
				mTr = mTr + "	<td>"+data[i].fecha_generada+"</td>";
				mTr = mTr + "	<td>"+data[i].total_trabajadores+"</td>";
				mTr = mTr + "	<td>S./ "+totalNeto+"</td>";
				mTr = mTr + "	<td>S./ "+totalDescuento+"</td>";
				mTr = mTr + "	<td>S./ "+totalAporte+"</td>";
				mTr = mTr + "	<td><button onClick=\"verPlanilla("+data[i].id+")\" class=\"btn btn-info\"><i class=\"fa fa-file\"></i> Ver</button></td>";
				mTr = mTr + "<tr>";

			}

			$("#tbBody").html(mTr);


		});
	}

	function filtrar(){

	}

	function loadFecha(val){
		var currentDate = new Date();
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		console.log(consorcios[val]);
		$('#gfecha').val(consorcios[val] == null || consorcios[val] == 'undefined' ? year+'-'+pad(month,2)+'-'+pad(day,2) : consorcios[val]);
	}

	function pad(n, width, z) {
	  z = z || '0';
	  n = n + '';
	  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}


	cargarPlanillas();
	cargarConsorcios();

    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: true,
        time:true,
        minView:2,
        autoclose: true,
        todayBtn: false
    });

</script>



                </div>

            </div>
        </div>
    </div>
</section>

@stop
