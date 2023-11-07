<?php

namespace Teckipro\Admin\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

use Teckipro\Admin\Models\Tutorials;

class TutorialTable extends DataTableComponent
{

    protected $model = Tutorials::class;
    
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
            Column::make('Title','title')->searchable()->sortable(),


            Column::make('Type','type')->searchable()->sortable(),

            Column::make('Video URL','video_url'),


            Column::make('Visible','visible')->sortable()
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


             Column::make('Actions','id')->sortable()
             ->format(
                 function($value, $row, Column $column){
                  
                    return view('teckiproadmin::livewire.tablerows.tutorial_action')->withRow($row);
                    
                 }  
              )
              ->html() ,

             

         
        ];
    }

    public function query(): Builder
    {

         return Tutorials::query();

    }

}
