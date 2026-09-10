<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'role_id',
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
        'password' => 'hashed',
    ];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relationship with Employee (optional)
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function getRoleAttribute($value)
    {
        if ($this->relationLoaded('role')) {
            return $this->getRelation('role');
        }

        if ($this->role_id) {
            return Role::find($this->role_id);
        }

        return $value ? new Role(['name' => $value]) : null;
    }

    public function isAdmin(): bool
    {
        $role = $this->role;
        $roleName = $role instanceof Role ? $role->name : (string) $role;
        return strtolower($roleName) === 'admin';
    }
}
