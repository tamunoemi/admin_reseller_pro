<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\Subscription\PaddleModel;

class PaddleTable extends DataTableComponent
{


    protected $model = Package::class;
    public bool $singleColumnSorting = true;

    public string $defaultSortDirection = 'desc';



    public array $sortNames = [
        'name' => 'name',
    ];

    public array $filterNames = [
        'type' => 'Package Type',
        'deleted' => 'Deleted',
        'visible' => 'Visible',
        'highlight' => 'highlight',
    ];


    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }


    public function filters(): array
    {
        return [

            SelectFilter::make('Package Type', 'type')
                ->setFilterPillTitle('Package Type')
                ->options([
                    '' => 'Any',
                    ''.PlanController::TYPE_LAUNCH.'' => 'Launch Packages',
                    ''.PlanController::TYPE_SAAS.'' => 'Sass Packages',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('type',$value);
                }),

            SelectFilter::make('Deleted Packages', 'deleted')
            ->setFilterPillTitle('Deleted Packages')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('deleted',$value);
            }),

            SelectFilter::make('Visible Packages', 'visible')
            ->setFilterPillTitle('Visible Packages')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('visible',$value);
            }),

            SelectFilter::make('Highlighted Packages', 'highlight')
            ->setFilterPillTitle('Highlighted Packages')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('highlight',$value);
            }),


        ];
    }



    public function columns(): array
    {
        return [
            Column::make('Package Name','name')->searchable()->sortable(),


            Column::make('Price - USD','price')->searchable()->sortable(),

            Column::make('Modules','module_ids'),

            Column::make('Validity-Days','validity')->searchable()->sortable(),


            Column::make('Default Package','is_default'),

            Column::make('Actions')

        ];
    }

    public function query(): Builder
    {
        return Package::query();
    }




}
