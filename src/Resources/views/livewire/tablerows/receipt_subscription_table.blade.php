@inject('packageservice', 'Teckipro\Admin\Services\PackageService')

<x-livewire-tables::bs4.table.cell>
    {{ $packageservice->getBillableUserName($row->billable_id) }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->paddle_subscription_id }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    <x-teckiproadmin::utils.link
                    :href="$row->receipt_url"
                    target="_blank"
                    :text="__('View Receipt')"
                    />


</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->paid_at }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->order_id }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->amount }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->tax }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->currency }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->ends_at }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->created_at }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->updated_at }}
</x-livewire-tables::bs4.table.cell>




