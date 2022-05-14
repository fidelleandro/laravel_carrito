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
    public function page($page){ 
        $privilegio = $this->getMethodControllerPage($page);
        
        return view('dashboard');
    }
    public function getMethodControllerPage($page){
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
