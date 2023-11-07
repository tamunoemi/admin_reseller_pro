<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;


use Teckipro\Admin\Models\Permission;
use Teckipro\Admin\Models\ModelHasPermissions;
use Illuminate\Support\Facades\DB;





class UserPermissionTable extends DataTableComponent
{


    public bool $singleColumnSorting = true;

    
    public string $defaultSortDirection = 'desc';
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }



    public array $sortNames = [
        'name' => 'name',
    ];


    public function configure(): void {
        $this->setPrimaryKey('id');

        $this->setEmptyMessage('No results found'); //Set the message displayed when the table is filtered but there are no results to show.


    }



    public function columns(): array
    {
        return [
            Column::make('Permission Name','permission_id')->searchable()->sortable()
            ->format(
                function($value, $row, Column $column){
                 return DB::table('permissions')->where('id',$value)->value('name');
                }  
             )
             ->html()
             ,

             Column::make('Permission Description','permission_id')->searchable()->sortable()
            ->format(
                function($value, $row, Column $column){
                 return DB::table('permissions')->where('id',$value)->value('description');
                }  
             )
             ->html()
             ,
        ];

    }


    public function builder():Builder
    {
    
        return ModelHasPermissions::query()
        ->where('model_id',$this->user_id);
        
       

    }


    

}
