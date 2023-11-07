<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;


use Teckipro\Admin\Models\LaunchSubscriptionModel;
use Teckipro\Admin\Models\Package;


class UserLaunchSubscriptionTable extends DataTableComponent
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
                $builder->where('is_expired',$value);
            }),


        ];
    }


    public function columns(): array
    {
        return [

            Column::make('Package Name','package_id')->searchable()->sortable()
            ->format(
                function($value, $row, Column $column){
                    return Package::where('id',$value)->value('name');

                }
             )
             ->html()
             ,



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


            Column::make('Is Cancelled','is_cancelled')
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

            Column::make('Is Refunded','is_refunded')
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

            Column::make('Is Expired','is_expired')
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

    public function builder(): Builder
    {

        return LaunchSubscriptionModel::query()->where('user_id','=',$this->user_id);
    }




}
