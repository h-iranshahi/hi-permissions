<?php

namespace Iransh\HiPermissions\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Traits\HasAdjacencyList;

class AccessLevel extends Model
{
    //use HasAdjacencyList;

    protected $fillable = ['name', 'parent_id'];

    protected $table = "access_levels";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hi_permissions.access_levels_table', $this->table);
    }

    /**
     * Get the parent access level.
     */
    public function parent()
    {
        return $this->belongsTo(AccessLevel::class, 'parent_id');
    }

    /**
     * Get the children access levels.
     */
    public function children()
    {
        return $this->hasMany(AccessLevel::class, 'parent_id');
    }

    /**
     * Get the users assigned to this access level.
     */
    public function users()
    {

        $userModelClass = config('hi_permissions.user_model');

        return $this->hasMany($userModelClass, 'access_level');
    }



}
