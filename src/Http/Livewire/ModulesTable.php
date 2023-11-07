<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\Modules;

class ModulesTable extends DataTableComponent
{

    protected $model = Modules::class;
    public bool $singleColumnSorting = true;
    public bool $responsive = true;

    public string $defaultSortDirection = 'desc';



    public array $sortNames = [
        'module_name' => 'module_name',
        ''
    ];




    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }

    public array $filterNames = [
        'Limit Enabled' => 'limit_enabled',
        'bulk_limit_enabled' => 'Bulk limit enabled',
        'deleted' => 'Deleted Modules'
    ];



    public function filters(): array
    {
        return [

            SelectFilter::make('Limit Enabled', 'limit_enabled')
                ->setFilterPillTitle('Limit Enabled')
                ->options([
                    ''    => 'Any',
                    'yes' => 'Yes',
                    'no' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('limit_enabled',$value);
                }),


            SelectFilter::make('Bulk limit enabled', 'bulk_limit_enabled')
            ->setFilterPillTitle('Bulk limit enabled')
            ->options([
                ''    => 'Any',
                'yes' => 'Yes',
                'no' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('bulk_limit_enabled',$value);
            }),

            SelectFilter::make('Deleted Modules', 'deleted')
            ->setFilterPillTitle('Deleted Modules')
            ->options([
                ''    => 'Any',
                'yes' => 'Yes',
                'no' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('deleted',$value);
            }),



        ];
    }




    public function columns(): array
    {
        return [
            Column::make('Module Name','module_name')->searchable()->sortable(),


            Column::make('Route','route')->searchable()->sortable(),

            Column::make('Add on ids','add_ons_id'),

            Column::make('Extra Info','extra_text')->searchable()->sortable(),


            Column::make('Limit Enabled','limit_enabled')->sortable()
            ->format(
                function($value, $row, Column $column){
                    if($value=='1'){
                     return '<span class="badge badge-success">'. __("Yes").' </span>';
                    }else{
                        return '<span class="badge badge-warning">'. __("No").' </span>';
                    }
                }  
             )
             ->html() ,

            Column::make('Bulk Limit Enabled','bulk_limit_enabled')->sortable()
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

            Column::make('Deleted','deleted')->sortable()
            ->format(
                function($value, $row, Column $column){
                    if($value=='1'){
                     return '<span class="badge badge-success">'. __("Yes").' </span>';
                    }else{
                        return '<span class="badge badge-warning">'. __("No").' </span>';
                    }
                }  
             )
             ->html(),


            Column::make('Actions','id')
            ->format(function($id){
                $row = Modules::find($id);
                return view('teckiproadmin::livewire.tablerows.module_actions')->withRow($row);
            })

        ];
    }

    public function query(): Builder
    {

         return Modules::query();

    }

}
