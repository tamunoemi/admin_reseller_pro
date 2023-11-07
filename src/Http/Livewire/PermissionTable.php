<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\Permission;

class PermissionTable extends DataTableComponent
{

    protected $model = Permission::class;
    
    public bool $singleColumnSorting = true;
    public bool $responsive = true;

    public string $defaultSortDirection = 'desc';



    public array $sortNames = [
       
    ];




    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }

    public array $filterNames = [
       
    ];





    public function columns(): array
    {
        return [
            Column::make('Name','name')->searchable()->sortable(),


            Column::make('Type','type')->searchable()->sortable(),

            Column::make('Guard Name','guard_name'),

            Column::make('description','description')->searchable(),

            Column::make('Sort','sort'),

            Column::make('Parent Id','parent_id'),

            Column::make('Created At','created_at'),

            Column::make('Updated At','updated_at'),




             Column::make('Actions','id')->sortable()
             ->format(
                 function($value, $row, Column $column){
                  
                    return view('teckiproadmin::livewire.tablerows.permission_action')->withRow($row);
                    
                 }  
              )
              ->html() ,

             

         
        ];
    }



}
