<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivilegioModel;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//inicio de autenticación
        $this->middleware(function ($request,$next){
            $datos = $request->session()->all();//cargamos todas las sessiones 
            if(isset($datos['user_data']))  {//existe la session user_data?
                $menu_priv = Helper::buildTree($datos['user_data']['menu_priv']); 
                dump($menu_priv); exit;
            }   
            return $next($request);
        });
    }
    public function dashboard(){
        return view('dashboard');
    }
    public function page($page){ //crear-usuario
        $privilegio = $this->getMethodControllerPriv($page);
        if (count($privilegio)) {
            session()->put('current_page',$page);
            $ruta_privilegio = $this->getRouteAdmin();// Obtener la ruta del controlador o controladores de los privilegios
            $method = $privilegio['method'];
            return app($ruta_privilegio.$privilegio['controller'])->$method(); //cargar otro controlador con su metodo
            //return App\Http\Controllers\Privilegios\UserController->index();
            // UserController()->index();
        }
        else{
            return view('dashboard.404');
        }
        return view('dashboard');
    }
    public function getRouteAdmin(){
        $ruta =  'App\Http\Controllers\Privilegios\.';
        return substr($ruta,0,strlen($ruta)-1);
    }
    public function getMethodControllerPriv($page){
        $privilegio = new PrivilegioModel();
        $data = $privilegio::select(['name','controller','method','post_method','get_method'])->where('url',$page)->get()->toArray();
        $priv = isset($data[0]) ? $data[0] : array();
        if (count($priv)) { //existe el privilegio
            View::share('titulo_privilegio',$priv['name']);
        }else{ //No existe el privilegio
            View::share('titulo_privilegio','No existe');
        }
        return $priv;
    }
}
