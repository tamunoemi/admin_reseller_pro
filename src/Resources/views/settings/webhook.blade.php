@extends('teckiproadmin::layouts.app')


@section('title', __('Webhook URL List'))

@section('content')


    <div class="row">

        
        <div class="col-md-8">

       
            <x-teckiproadmin::backend.card>
               
                <x-slot name="body">

                       @php
                       $host = request()->getSchemeAndHttpHost(); 
                       @endphp
               
                        <div class="row">

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ $host }}/api/jvzipn"
                                    label="JVZOO IPN URL" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ $host }}/api/wplusipn"
                                    label="WARRIORPLUS IPN URL" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>


                         


                        </div>

                      

                  
                      



                </x-slot>

                <x-slot name="footer">
                    <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                        Save</button>
                </x-slot>
              
            </x-teckiproadmin::backend.card>

        </div>


       
    </div>



@endsection
