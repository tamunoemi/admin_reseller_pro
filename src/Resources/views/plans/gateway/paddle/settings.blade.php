@extends('teckiproadmin::layouts.app')


@section('title', __('Paddle Settings'))

@section('content')


    <div class="row">


        <div class="col-md-8">


            <x-teckiproadmin::backend.card>

              <x-slot name="header">
                <h4>Paddle Settings</h4>
              </x-slot>

                <x-slot name="body">

                    @include('teckiproadmin::flash-message')

                    <form action="{{ route('admin.plan.gateway.savepaddlesettings') }}" method="post">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif


                        <div class="row">

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('PADDLE_VENDOR_ID') }}" name="PADDLE_VENDOR_ID"
                                    label="Paddle vendor id">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text  value="{{ env('PADDLE_VENDOR_AUTH_CODE') }}" name="PADDLE_VENDOR_AUTH_CODE"
                                    label="Paddle vendor auth code" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text  value="{{ env('PADDLE_PUBLIC_KEY') }}" name="PADDLE_PUBLIC_KEY"
                                    label="Paddle public key" >
                                </x-teckiproadmin::backend.form-group-text>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4">

                              <div class="form-group">
                                <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Sandbox Mode </label>

                                  <div class="form-group">

                                    <label class="custom-switch mt-2">
                                      <input type="checkbox" name="PADDLE_SANDBOX"  class="custom-switch-input" {{ env('PADDLE_SANDBOX')=='true' ? 'checked' : '' }}>
                                      <span class="custom-switch-indicator"></span>
                                      <span class="custom-switch-description">Yes</span>



                                    </label>
                                  </div>
                              </div>
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
