<?php

namespace Teckipro\Admin\Http\Livewire;

use Teckipro\Admin\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

/**
 * Class UsersTable.
 */
class UsersTable extends DataTableComponent
{ 
    /**
     * @var
     */
    public $status;
    protected $model = User::class;
    public bool $responsive = true;
    //public $search;
    private $user;

    public $columnSearch = [
        'name' => null,
        'email' => null,
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    /**
     * @var array|string[]
     */
    public array $sortNames = [
        'email_verified_at' => 'Verified',
        'two_factor_auth_count' => '2FA',
    ];

    /**
     * @var array|string[]
     */
    public array $filterNames = [
        'type' => 'User Type',
        'verified' => 'E-mail Verified',
    ];

    /**
     * @param  string  $status
     */
    public function mount($status = 'active'): void
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        //$query = User::with('roles', 'twoFactorAuth')->withCount('twoFactorAuth');
        $query = User::query();

        if ($this->status === 'deleted') {
            $query = $query->onlyTrashed();
        } elseif ($this->status === 'deactivated') {
            $query = $query->onlyDeactivated();
        } else {
            $query = $query->onlyActive();
        }

        return $query
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('email', 'like', '%' . $email . '%'))
            ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type))
            ->when($this->getFilter('active'), fn ($query, $active) => $query->where('active', $active === 'yes'))
            ->when($this->getFilter('verified'), fn ($query, $verified) => $verified === 'yes' ? $query->whereNotNull('email_verified_at') : $query->whereNull('email_verified_at'));
    }

    /**
     * @return array
     */

     public function filters(): array
    {

        return [

            SelectFilter::make('User Type', 'type')
                ->setFilterPillTitle('User Type')
                ->options([
                    ''    => 'Any',
                    User::TYPE_ADMIN => 'Administrators',
                    User::TYPE_USER => 'Users',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('type',$value);
                }),


            SelectFilter::make('Active', 'active')
                ->setFilterPillTitle('Active')
                ->options([
                    ''    => 'Any',
                    'yes' => 'Yes',
                    'no' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('active',$value);
                }),


            SelectFilter::make('E-mail Verified', 'email_verified_at')
                ->setFilterPillTitle('E-mail Verified')
                ->options([
                    ''    => 'Any',
                    'yes' => 'Yes',
                    'no' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'yes') {
                        $builder->whereNotNull('email_verified_at');
                    } elseif ($value === 'no') {
                        $builder->whereNull('email_verified_at');
                    }
                   
                }),

        ];
    }

   

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('Type'),'id')
                ->sortable()
                ->format(
                    function($value, $row, Column $column){
                        $user = User::find($value);
                        $this->user = $user;
                        return view('teckiproadmin::auth.user.includes.type')->withUser($user);
                    }  
                 ),
                

            Column::make(__('Name'))
                ->sortable()
                ->searchable(),

            Column::make(__('E-mail'), 'email')
                ->sortable()
                ->searchable(),

            Column::make(__('Verified'), 'id')
                ->sortable()
                ->format(
                    function($value, $row, Column $column){
                        return view('teckiproadmin::auth.user.includes.verified')->withUser($this->user);
                    }  
                 ),
                

            Column::make(__('2FA'), 'id') 
            ->sortable()
            ->format(
                function($value, $row, Column $column){
                    return view('teckiproadmin::auth.user.includes.2fa')->withUser($this->user);
                }  
             ),

            Column::make(__('Roles'),'id')
            ->format(
                function($value, $row, Column $column){
                    return $this->user->roles_label;
                }  
             ),

            Column::make(__('Additional Permissions'),'id')
            ->format(
                    fn()=>  $this->user->permissions_label
             ),

            Column::make('Actions','id')
            ->format(
            function($value, $row, Column $column){
               
                return view('teckiproadmin::auth.user.includes.actions')->withUser($this->user);
            }  
            ),
 

            Column::make(__('Registered'), 'created_at')
            ->searchable()
            ->format(
                fn($created_at)=>  timezone()->convertToLocal($created_at)
            ),

            Column::make(__('Last Login'),'last_login_at')
            ->searchable()
            ->format(
                fn($last_login_at)=>  timezone()->convertToLocal($last_login_at)
            ),

            Column::make(__('Last IP'), 'last_login_ip')
            ->searchable()
            ->format(
                fn($last_login_ip)=>  $last_login_ip
            ),

        ];
    }


   
}
