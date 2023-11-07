<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\PaddleCustomersModel;

class SaasCustomersTable extends DataTableComponent
{

    protected $model = PaddleCustomersModel::class;
    public bool $singleColumnSorting = true;

  
    public string $defaultSortDirection = 'desc';



    public array $sortNames = [
        'billable_id' => 'billable_id',
    ];



    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }



    public function columns(): array
    {
        return [
            Column::make('User','billable_id')->searchable()->sortable(),

            Column::make('Trail Ends At','trial_ends_at')->searchable()->sortable(),

            Column::make('Created At','created_at')->searchable()->sortable(),
            Column::make('Updated At','updated_at')->searchable()->sortable(),

        ];
    }


    public function query(): Builder
    {
        return PaddleCustomersModel::query();
    }


    public function rowView(): string
    {
         return 'teckiproadmin::livewire.tablerows.customer_subscription_table';
    }


}
