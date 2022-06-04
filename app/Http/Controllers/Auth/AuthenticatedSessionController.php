<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\Helper;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = new User();//cargamos el modelo user
        /*******CARGAMOS EL MENU DE LOS PRIVILEGIOS********/
        $auth = \Auth()->user();
        //echo 'ROL_ID:'.$auth->rol_id.' ID_USER:'.$auth->id; exit;
        $menu_priv = Helper::objectToArray($user->getUserPrivileges($auth->rol_id,$auth->id));
        
        $data['id']         = $auth->id;
        $data['name']       = $auth->name;
        $data['email']      = $auth->email;
        $data['rol_id']     = $auth->rol_id;
        $data['menu_priv']  = $menu_priv;
        session(['user_data' => $data]); 
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
