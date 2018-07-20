@extends('layout.master')  

@section('include')
    @parent

    {{ Html::style('css/multi-select.css') }}


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
                	<table class="table table-hover table-stripped">
                		<thead>
                			<tr>
                				<th>ID</th>
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
	<button onClick="generarPlanilla();">Generar Planilla</button>
	<br>

	<span id="result"></span>
</dv>




<script type="text/javascript">
	
	function generarPlanilla(){
		console.log("generar planilla");

		$.post("AjaxDinamic/Proceso.Planilla@generar",function(data){
			
			$("#result").html(data);
			cargarPlanillas();

		});
	}

	function verPlanilla(idp){
		newwindow=window.open("verPlanillaDetalle/"+idp);
		if (window.focus) {newwindow.focus()}
		return false;
	}




	function cargarPlanillas(){

		$.post("AjaxDinamic/Proceso.Planilla@verPlanillas",function(data){
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

	cargarPlanillas();


</script>



                </div>

            </div>
        </div>
    </div>
</section>

@stop
