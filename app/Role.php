<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['jenis', 'slug', 'permissions'];
    protected $casts = [
        'permissions' => 'array',
    ];
    public $timestamps=false;
    function users() {
        return $this->belongsToMany(User::class, 'group_roles','role_id','user_id');
    }
    function hasAccess(array $permissions) {
        foreach($permissions as $p) {
            
            if($this->hasPermission($p)) return TRUE;
        }
        return false;
    }
    private function hasPermission(string $permission) {
        return $this->permissions[$permission] ?? false;
    }

}