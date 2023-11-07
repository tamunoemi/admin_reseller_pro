<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;


use Tamunoemi\Laraplans\Models\Plan;
use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;



class PlanTable extends DataTableComponent
{

    protected $model = Plan::class;
    public bool $singleColumnSorting = true;


    public string $defaultSortDirection = 'desc';



    public array $sortNames = [
        'name' => 'name',
    ];



    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }



    public function filters(): array
    {
        return [

            SelectFilter::make('Plan Type', 'type')
                ->setFilterPillTitle('Plan Type')
                ->options([
                    '' => 'Any',
                    ''.PlanController::TYPE_LAUNCH.'' => 'Launch Plans',
                    ''.PlanController::TYPE_SAAS.'' => 'Sass Plans',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('type',$value);
                }),

            SelectFilter::make('Deleted Plans', 'deleted')
            ->setFilterPillTitle('Deleted Plans')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('deleted',$value);
            }),

            SelectFilter::make('Visible Plans', 'visible')
            ->setFilterPillTitle('Visible Plans')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('visible',$value);
            }),

            SelectFilter::make('Highlighted Plans', 'highlight')
            ->setFilterPillTitle('Highlighted Plans')
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
            Column::make('Plan Name','name')->searchable()->sortable(),


            Column::make('Price - USD','price')->searchable()->sortable(),
            //Column::make('Role IDs','role_ids'),
            //Column::make('Monthly Limit','monthly_limit'),
            //Column::make('Bulk Limit(Total limit)','bulk_limit'),
             //Column::make('Validity-Days','validity')->searchable()->sortable(),

            Column::make('JVZOO ID','jvzoo_id'),
            Column::make('WPLUS ID','warriorplus_id'),
            Column::make('APPSUMO ID','appsumo_id'),
            Column::make('CLICKBANK ID','clickbank_id'),



/**
            Column::make('Default Plan','is_default')
            ->format(
                function($value, $row, Column $column){
                    if($value=='1'){
                     return '<span class="badge badge-success">'. __("Yes").' </span>';
                    }else{
                        return '<span class="badge badge-warning">'. __("No").' </span>';
                    }
                }
             )
             ->html()
             ,
              */

              Column::make('Can Resell?','user_can_resell')
              ->format(
                  function($value, $row, Column $column){
                      if($value=='1'){
                       return '<span class="badge badge-danger">'. __("Yes").' </span>';
                      }else{
                          return '<span class="badge badge-info">'. __("No").' </span>';
                      }
                  }
               )
               ->html()
               ,

            Column::make('Actions','id')
            ->format(
            function($value, $row, Column $column){
                $Plan = Plan::find($value);
                return view('teckiproadmin::livewire.tablerows.plan_actions')->withRow($Plan);
            }
            ),

        ];
    }


    public function bulkActions(): array
    {
        return [
            'visible' => 'Make all visible'
        ];
    }

    public function visible()
    {
        Plan::whereIn('id', $this->getSelected())->update(['visible' => '1']);

        $this->clearSelected();
    }


}
