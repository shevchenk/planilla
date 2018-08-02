<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Plantilla</title>

        @section('include')
        {{ Html::style('lib/bootstrap/css/bootstrap.min.css') }} 
        {{ Html::script('lib/bootstrap/js/bootstrap.min.js') }}

        @show
    </head>

    <body class="skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">
            @if (isset($boletas))
            @foreach ( $boletas as $key => $val)
            <div class="content-wrapper">
<!--                <table style="width: 100% !important">
                    <tr>
                        <td class="c1">
                            <b>CARRERA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->carrera }}
                        </td>
                        <td class="c1">
                            <b>SEMESTRE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->semestre }}
                        </td>
                    </tr>
                    <tr>
                        <td class="c1">
                            <b>CURSO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->curso }}
                        </td>
                        <td class="c1">
                            <b>CICLO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->ciclo }}
                        </td>
                    </tr>
                    <tr>
                        <td class="c1">
                            <b>PROFESOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->profesor }}
                        </td>
                        <td class="c1">
                            <b>TIPO EVALUACIÓN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            {{ $head->tipo_evaluacion }}
                        </td>
                    </tr>
                </table>-->
                <hr>
                <div>
                    <table style="width: 100% !important" border="1">
                        <tr>
                            <td class="c1">
                                <b>APELLIDOS Y NOMBRES&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{$val->colaborador }}
                            </td>
                            <td class="c1">
                                <b>DNI&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->dni }}
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table style="width: 100% !important" border="1">
                        <tr>
                            <td class="c1" colspan="2" align="center">
                                <b>INGRESOS</b>
                            </td>
                            <td class="c1" colspan="2" align="center">
                                <b>APORTACIONES</b>
                            </td>
                            <td class="c1" colspan="2" align="center">
                                <b>DESCUENTOS</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="c1">
                                <b>SUELDO BRUTO&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{$val->sueldo_bruto }}
                            </td>
                            <td class="c1">
                                <b>APORTE&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->aporte }}
                            </td>
                            <td class="c1">
                                <b>DESCUENTO&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->descuento }}
                            </td>
                        </tr>
                        <tr>
                            <td class="c1">
                                <b>SUELDO NETO&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->sueldo_neto }}
                            </td>
                            <td class="c1">
                                
                            </td>
                            <td class="c2">
                               
                            </td>
                            <td class="c1">
                                <b>SEGURO&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->seguro }}
                            </td>
                        </tr>
                        <tr>
                            <td class="c1">
                                
                            </td>
                            <td class="c2">
                                
                            </td>
                            <td class="c1">
                                
                            </td>
                            <td class="c2">
                               
                            </td>
                            <td class="c1">
                                <b>PRIMA&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                            </td>
                            <td class="c2">
                                {{ $val->prima }}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            @endforeach
            @endif
        </div><!-- ./wrapper -->
    </body>
</html>

