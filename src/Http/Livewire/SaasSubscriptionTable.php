<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\PaddleModel;
use Teckipro\Admin\Services\PackageService;

class SaasSubscriptionTable extends DataTableComponent
{

    protected $model = PaddleModel::class;
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
        $packageservice = new PackageService();

        return [
            Column::make('User','billable_id')
            ->format(
                fn($value, $row, Column $column) => $packageservice->getBillableUserName($row->billable_id)
            )
            ->searchable()->sortable(),


            Column::make('Paddle Plan','paddle_plan')->searchable()->sortable(),

            Column::make('Paddle Id','paddle_id')->searchable()->sortable(),

            Column::make('Status','paddle_status')->searchable()->sortable(),
            Column::make('Quantity','quantity')->searchable()->sortable(),
            Column::make('Trial Ends At','trial_ends_at')->searchable()->sortable(),
            Column::make('Paused From','paused_from')->searchable()->sortable(),
            Column::make('Ends At','ends_at')->searchable()->sortable(),
            Column::make('Created At','created_at')->searchable()->sortable(),
            Column::make('Updated At','updated_at')->searchable()->sortable(),

        ];
    }

    public function query(): Builder
    {
        return PaddleModel::query();
    }



}
