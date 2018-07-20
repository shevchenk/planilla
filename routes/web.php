<?php
// Rutas de Servicios Rest.
Route::resource('personas', 'Api\ApiPersonas',
                ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::resource('cursos', 'Api\ApiCurso',
                ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
// --
//Route::get('/api', function () {
//    $ruta='api.curso.curso';
//    $valores['valida_ruta_url'] = $ruta;
//    return view($ruta)->with($valores);
//});

Route::get('/', function () {
    return view('secureaccess.login');
});

Route::get('/salir','SecureAccess\PersonaSA@logout');

Route::get('/verPlanillaDetalle/{id}','Proceso\Planilla@verPlanillaDetalle');

Route::get('/ReportDinamic/{ruta}','SecureAccess\PersonaSA@Menu');
Route::post('/AjaxDinamic/{ruta}','SecureAccess\PersonaSA@Menu');

Route::post('/marcacionRemota','Proceso\MarcacionPR@Marcacion');

Route::get(
    '/{ruta}', function ($ruta) {        
        if( session()->has('dni') && session()->has('menu')
            && session()->has('opciones')
        ){
            $valores['valida_ruta_url'] = $ruta;
            $valores['menu'] = session('menu');
            $valores['privilegios'] = session('privilegios');

            if( strpos( session('opciones'),$ruta )!==false
                || $ruta=='secureaccess.inicio'
                || $ruta=='secureaccess.myself' ){
                return view($ruta)->with($valores);
            }
            else{
                return redirect('secureaccess.inicio');
            }
        }
        else{
            return redirect('/');
        }
    }
);


