@extends('teckiproadmin::layouts.app')


@section('title', __('Database Settings'))

@section('content')


    <div class="row">

        
        <div class="col-md-8">

            <div class="card-header text-danger">Avoid changing this values as you might lose connection to your site.</div>
            <x-teckiproadmin::backend.card>
               
                <x-slot name="body">

                    <form action="{{ route('admin.setting.database') }}" method="post">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif


                        <div class="row">

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('DB_HOST') }}" name="DB_HOST"
                                    label="DB HOST" placeholder="{{ __('Enter database host') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text type="number" value="{{ env('DB_PORT') }}" name="DB_PORT"
                                    label="DB PORT" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text  value="{{ env('DB_DATABASE') }}" name="DB_DATABASE"
                                    label="DATABASE NAME" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('DB_USERNAME') }}" name="DB_USERNAME"
                                    label="DATABASE USERNAME" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('DB_PASSWORD') }}" name="DB_PASSWORD"
                                    label="DATABASE PASSWORD">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>
                        </div>

                  
                      



                </x-slot>

                <x-slot name="footer">
                    <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                        Save</button>
                </x-slot>
                </form>
            </x-teckiproadmin::backend.card>

        </div>


       
    </div>



@endsection
