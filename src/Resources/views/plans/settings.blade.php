@extends('teckiproadmin::layouts.app')


@section('title', __('Plan Settings'))

@section('content')


    <div class="row">


        <div class="col-md-8">


            <x-teckiproadmin::backend.card>

              <x-slot name="header">
                <h4>Plan Settings</h4>
              </x-slot>

                <x-slot name="body">

                    @include('teckiproadmin::flash-message')

                    <form action="{{ route('admin.plan.saveplansettings') }}" method="post">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif


                        <div class="row">

                            <div class="col-md-6 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('CASHIER_CURRENCY') }}" name="CASHIER_CURRENCY"
                                    label="Currency">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <x-teckiproadmin::backend.form-group-select selectedValue="{{ env('DEFAULT_SUBSCRIPTION_GATEWAY') }}" name="DEFAULT_SUBSCRIPTION_GATEWAY"  label="Default subscription gateway *" :options="$subscriptionGatewayOptions"></x-teckiproadmin::backend.form-group-select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">

                              <div class="form-group">
                                <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Turn on yearly, monthly select option </label>

                                  <div class="form-group">

                                    <label class="custom-switch mt-2">
                                      <input type="checkbox" name="MONTHLY_YEARLY_PLAN_OPTION"  class="custom-switch-input" {{ env('MONTHLY_YEARLY_PLAN_OPTION')==1 ? 'checked' : '' }}>
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
