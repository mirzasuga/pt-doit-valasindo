<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_user', 'email', 'password','telepon','alamat','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','token','remember_token'
    ];
    public $timestamps = FALSE;

    public function roles() {
        return $this->belongsToMany(Role::class,'group_roles','user_id','role_id');
    }
    public function hasAccess(array $permissions) {
        foreach($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }
    public function inRole(string $roleSlug) {
        return $this->roles()->where('slug',$roleSlug)->count() == 1;
    }
}
