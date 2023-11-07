<?php

namespace Teckipro\Admin\Services;

use Teckipro\Admin\Events\Role\RoleCreated;
use Teckipro\Admin\Events\Role\RoleDeleted;
use Teckipro\Admin\Events\Role\RoleUpdated;
use Teckipro\Admin\Models\Role;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleService.
 */
class RoleService extends BaseService
{
    /**
     * RoleService constructor.
     *
     * @param  Role  $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param  array  $data
     * @return Role
     *
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Role
    {
        DB::beginTransaction();

        try {
            $role = $this->model::create(['type' => $data['type'], 'name' => $data['name']]);
            $role->syncPermissions($data['permissions'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating the role.'));
        }

        event(new RoleCreated($role));

        DB::commit();

        return $role;
    }

    /**
     * @param  Role  $role
     * @param  array  $data
     * @return Role
     *
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Role $role, array $data = []): Role
    {
        DB::beginTransaction();

        try {
            $role->update(['type' => $data['type'], 'name' => $data['name']]);
            $role->syncPermissions($data['permissions'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating the role.'));
        }

        event(new RoleUpdated($role));

        DB::commit();

        return $role;
    }

    /**
     * @param  Role  $role
     * @return bool
     *
     * @throws GeneralException
     */
    public function destroy(Role $role): bool
    {
        if ($role->users()->count()) {
            throw new GeneralException(__('You can not delete a role with associated users.'));
        }

        if ($this->deleteById($role->id)) {
            event(new RoleDeleted($role));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the role.'));
    }


    /**
     * 
     */
    public function getUserRolesByUserId($id){
        return $this->model::where('type','=','user')->get();
    }

    /**
     * Get all roles that belongs to users
     */
    public function getRolesForUsers(){
        return $this->model::where('type','=','user')->get();
    }
}
