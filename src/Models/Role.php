<?php

namespace Teckipro\Admin\Models;

use Teckipro\Admin\Models\Traits\Attribute\RoleAttribute;
use Teckipro\Admin\Models\Traits\Method\RoleMethod;
use Teckipro\Admin\Models\Traits\Scope\RoleScope;
use Teckipro\Admin\Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 */
class Role extends SpatieRole
{
    use HasFactory,
        RoleAttribute,
        RoleMethod,
        RoleScope;

  protected $table='roles'; //very important
    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RoleFactory::new();
    }
}
