@inject('packageservice', 'Teckipro\Admin\Services\PackageService')

<x-livewire-tables::bs4.table.cell>
    {{ $packageservice->getBillableUserName($row->billable_id) }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->trial_ends_at }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->created_at }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->updated_at }}
</x-livewire-tables::bs4.table.cell>




