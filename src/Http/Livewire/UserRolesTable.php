<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\Role;
use Teckipro\Admin\Models\User;

use Teckipro\Admin\Models\ModelHasRoles;
use Illuminate\Support\Facades\DB;

class UserRolesTable extends DataTableComponent
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
            Column::make('Role Name','role_id')->searchable()->sortable()
            ->searchable()
            ->format(
                function($value, $row, Column $column){

                 return DB::table('roles')->where('id',$value)->value('name');
           
                 
                }  
             )
             ->html()
             ,
        ];

    }


    public function builder():Builder
    {
     

       
        $roles = ModelHasRoles::query()
        ->where('model_id','=',$this->user_id);
        return $roles;
       

       

    }


    

}
