<?php

namespace Teckipro\Admin\Http\Livewire;

use Teckipro\Admin\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Teckipro\Admin\Models\User;

/**
 * Class RolesTable.
 */
class RolesTable extends DataTableComponent
{
    protected $model = Role::class;
    private $role;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Role::with('permissions:id,name,description')
            ->withCount('users')
            ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    { 
        return [
            Column::make(__('Type'))
                ->sortable()
                ->searchable()
                ->format(
                    function($type){
                      if($type==User::TYPE_ADMIN){
                        return __('Administrator');
                      }elseif($type ==User::TYPE_USER)
                      {
                        return __('User');
                      }else{
                        return 'N/A';
                      }
                    }
                ),
            Column::make(__('Name'))
            ->searchable()
                ->sortable(),

            Column::make(__('Permissions'), 'id')
            ->searchable()
            ->format(function($id){ 
                $row = Role::find($id);
                $this->role = $row;
                return $row->permissions_label;
            }),

            /***
             * Column::make(__('Number of Users'), 'users_count')
            ->sortable(),
             */
            
            
           

            Column::make(__('Actions'),'id')
            ->format(function(){
              return view('teckiproadmin::auth.role.includes.actions')->withModel($this->role);
            }
           ),
            
        ];
    }

    public function rowView(): string
    {
        return 'teckiproadmin::auth.role.includes.row';
    }
}
