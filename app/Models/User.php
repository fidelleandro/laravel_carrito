<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getUserPrivileges($id_rol,$id_user){
        $rows = DB::select(DB::raw("SELECT  p.id as id,
                p.label,
                p.parent,
                p.url,
                p.icon,
                p.is_visible visible,
                Deriv1.Count
            FROM
            privilegio p
            LEFT OUTER JOIN (SELECT parent,
                                    COUNT(*) AS Count
                            FROM privilegio
                            GROUP BY parent
                            ) Deriv1 ON
            p.id = Deriv1.parent
            inner join users u2 on
            u2.id = $id_user 
            inner join rol r on
            r.id = $id_rol
            inner join rol_priv rp on
            rp.rol_id = r.id AND
            rp.privilegio_id = p.id AND 
            rp.status = 1 
            LEFT join dashboardmenu_priv dp ON dp.privilegio_id = p.id
            LEFT join user_priv up on
            up.user_id = u2.id AND 
            up.privilegio_id = p.id
            WHERE p.status = '1'"));
            
        return $rows;    
    }
}
