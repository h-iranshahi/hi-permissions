<?php

namespace Iransh\HiPermissions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

    ];


    protected $casts = [
        'image' => 'array'
    ];

    //protected $connection = 'mysqlSecondConnection';

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hi_permissions.roles_table', $this->table);
    }

    protected static function newFactory()
    {

    }

    public function getTitleAttribute()
    {
        return $this->name;
    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, config('hi_permissions.role_permission_table'));
    }

    public function users()
    {
        $userModelClass = config('hi_permissions.user_model');

        return $this->belongsToMany($userModelClass, config('hi_permissions.user_role_table'));
    }
}
