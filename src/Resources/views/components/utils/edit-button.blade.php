@props(['href' => '#', 'permission' => false])

<x-teckiproadmin::utils.link :href="$href" class="btn btn-primary btn-sm" icon="fas fa-pencil-alt" :text="__('Edit')" permission="{{ $permission }}" />
