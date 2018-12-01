<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['name', 'username', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['deleted_at'];

    public function roles() {
        return $this->belongsToMany(Role::class)->withTrashed();
    }

    public function assignRole($role) {
        if (is_string($role)) {
            $role = Role::whereName($role)->first();
        }
        return $this->roles()->attach($role);
    }

    public function revokeRole($role) {
        if (is_string($role)) {
            $role = Role::whereName($role)->first();
        }
        return $this->roles()->detach($role);
    }

    public function hasRole($roles) {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        foreach ($roles as $name) {
            foreach ($this->roles as $role) {
                if ($role->name === $name) return true;
            }
        }
        return false;
    }
}
