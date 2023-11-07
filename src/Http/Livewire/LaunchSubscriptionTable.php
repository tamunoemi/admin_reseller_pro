<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Teckipro\Admin\Services\PackageService;

use Teckipro\Admin\Models\LaunchSubscriptionModel;

class LaunchSubscriptionTable extends DataTableComponent
{


    protected $model = LaunchSubscriptionModel::class;
    public bool $singleColumnSorting = true;


    public string $defaultSortDirection = 'desc';
    private $packageservice;

    public function __construct(){
    $this->packageservice = new PackageService();
    }

    public $columnSearch = [
        'name' => null
    ];

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

            SelectFilter::make('Active Subscription', 'is_active')
                ->setFilterPillTitle('Active Subscription')
                ->options([
                    '' => 'Any',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                   $builder->where('is_active',$value);
                }),

            SelectFilter::make('Cancelled Subscriptions', 'is_cancelled')
            ->setFilterPillTitle('Cancelled Subscriptions')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('is_cancelled',$value);
            }),

            SelectFilter::make('Refunded Subscriptions', 'is_refunded')
            ->setFilterPillTitle('Refunded Subscriptions')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('is_refunded',$value);
            }),

            SelectFilter::make('Expired Subscriptions', 'is_expired')
            ->setFilterPillTitle('Expired Subscriptions')
            ->options([
                '' => 'Any',
                '1' => 'Yes',
                '0' => 'No',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('is_refunded',$value);
            }),


        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Plan Name','package_id')->searchable()->sortable()
            ->format(fn($package_id)=> $this->packageservice->getPackageName($package_id)),




            Column::make('Amount Paid','amount')->searchable()->sortable(),

            Column::make('Transaction ID','transactionId')->searchable()->sortable(),

            Column::make('Expiry Date','expires')->searchable()->sortable(),

            Column::make('Active','is_active')
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




             Column::make('Actions','id')
             ->format(
                 function($value, $row, Column $column){
                     $row = LaunchSubscriptionModel::find($value);
                     return view('teckiproadmin::livewire.tablerows.userlaunchsubactions')->withRow($row);
                 }
              ),

        ];
    }

    public function query(): Builder
    {
        return LaunchSubscriptionModel::query();

    }




}
