<?php

namespace Teckipro\Admin\Models;

use Teckipro\Admin\Models\Traits\Relationship\PermissionRelationship;
use Teckipro\Admin\Models\Traits\Scope\PermissionScope;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission.
 */
class Permission extends SpatiePermission
{
    use PermissionRelationship,
        PermissionScope;
}
 