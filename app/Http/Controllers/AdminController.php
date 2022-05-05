<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construc(){
        $this->middleware('auth');//inicio de autenticación
        $this->middleware(function ($request,$next){
            $datos = $request->session()->all();//cargamos todas las sessiones    
            return $next($request);
        });
    }
}
