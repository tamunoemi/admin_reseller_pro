@if (!$model->isAdmin())
    <x-teckiproadmin::utils.edit-button :href="route('admin.auth.role.edit', $model)" />
    <x-teckiproadmin::utils.delete-button :href="route('admin.auth.role.destroy', $model)" />
@endif
