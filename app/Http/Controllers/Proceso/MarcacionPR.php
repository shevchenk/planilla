<?php

namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proceso\Asistencia;
use Auth;

class MarcacionPR extends Controller {

    public function __construct() {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    }

    public function Marcacion( Request $r ) {
        $return=Asistencia::Marcacion( $r );
        return response()->json($return);
    }

}
