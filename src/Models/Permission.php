<?php

namespace Iransh\HiPermissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    protected $table = 'permissions';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hi_permissions.permissions_table', $this->table);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, config('hi_permissions.role_permission_table'));
    }

    public function users()
    {
        $userModelClass = config('hi_permissions.user_model');

        return $this->belongsToMany($userModelClass, config('hi_permissions.user_permission_table'));
    }
}
