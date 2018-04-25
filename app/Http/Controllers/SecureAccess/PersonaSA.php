<?php
namespace App\Http\Controllers\SecureAccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\SecureAccess\Persona;
use Auth;

class PersonaSA extends Controller
{
    use AuthenticatesUsers;

    protected $loginView = 'secureaccess.login';

    public function authenticated(Request $r)
    {
        $result['rst']=1;
        $resultMenu = Persona::Menu($r);
        $privilegios = $resultMenu[0];
        $menu = $resultMenu[1];
        $opciones=array();
        $cargo='';
        foreach ($menu as $key => $value) {
            array_push($opciones, $value->opciones);
            $cargo=$value->privilegio;
        }
        $opciones=implode("||", $opciones);
        $session= array(
            'menu'=>$menu,
            'opciones'=>$opciones,
            'dni'=>$r->dni,
            'cargo'=>$cargo,
            'privilegios'=>$privilegios
        );
        session($session);
        return response()->json($result);
    }

    public function Privilegio(Request $r)
    {
        $result['rst']=1;
        $resultMenu = Persona::Menu($r);
        $privilegios = $resultMenu[0];
        $menu = $resultMenu[1];
        $opciones=array();
        $cargo='';
        foreach ($menu as $key => $value) {
            array_push($opciones, $value->opciones);
            $cargo=$value->privilegio;
        }
        $opciones=implode("||", $opciones);
        $session= array(
            'menu'=>$menu,
            'opciones'=>$opciones,
            'dni'=>Auth::user()->dni,
            'cargo'=>$cargo,
            'privilegios'=>$privilegios
        );
        session($session);
        return response()->json($result);
    }

    public function username()
    {
        return "dni";
    }

    public function EditPassword(Request $r)
    {
        if ( $r->ajax() ) {
            if( $r->password == $r->password_confirm ){
                $rs=Persona::runEditPassword($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro actualizado';
                if( $rs==2 ){
                    $return['rst'] = 2;
                    $return['msj'] = 'Contraseña Actual no válida';
                }
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = 'Contraseña y Contraseña de confirmación no '.
                'son iguales';
            }
            return response()->json($return);
        }
    }


}
