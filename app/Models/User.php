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
       $sql = 'SELECT p.id as id
                      p.label,
                      p.parent,
                      p.url,
                      p.icon,
                      Deriv.Count
               FROM 
               privilegio p
               LEFT OUTER JOIN(
                   SELECT parent,
                          COUNT(*) AS Count
                   FROM privilegio
                   GROUP BY parent         
               )               
               inner join users u ON
               inner join rol r ON
               inner join rol_priv   
       ';
       return DB::select(DB::raw($sql)); 
    }
}
