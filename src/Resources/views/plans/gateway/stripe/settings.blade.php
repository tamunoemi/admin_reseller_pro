@extends('teckiproadmin::layouts.app')


@section('title', __('Stripe Settings'))

@section('content')


    <div class="row">


        <div class="col-md-8">


            <x-teckiproadmin::backend.card>

              <x-slot name="header">
                <h4>Stripe Settings</h4>
              </x-slot>

                <x-slot name="body">

                    @include('teckiproadmin::flash-message')

                    <form action="{{ route('admin.plan.gateway.savestripesettings') }}" method="post">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif


                        <div class="row">

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('STRIPE_KEY') }}" name="STRIPE_KEY"
                                    label="Stripe Key">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text  value="{{ env('STRIPE_SECRET') }}" name="STRIPE_SECRET"
                                    label="Stripe Secret" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text  value="{{ env('STRIPE_WEBHOOK_SECRET') }}" name="STRIPE_WEBHOOK_SECRET"
                                    label="Stripe Webhook Secret" >
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
