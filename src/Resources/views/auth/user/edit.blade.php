@inject('model', '\Teckipro\Admin\Models\User')
@inject('PlanController','Teckipro\Admin\Http\Controllers\PlanController')
@inject('launchSubscriptionmodel', 'Teckipro\Admin\Models\LaunchSubscriptionModel')

@extends('teckiproadmin::layouts.app')

@section('title', __('Update User'))

@section('content')
    <x-teckiproadmin::forms.patch :action="route('admin.auth.user.update', $user)">
        <x-teckiproadmin::backend.card>
            <x-slot name="header">
                @lang('Update User')
            </x-slot>

            <x-slot name="headerActions">
                <x-teckiproadmin::utils.link class="card-header-action" :href="route('admin.auth.user.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">


           <x-teckiproadmin::backend.form-group-text name="name" label="Fullname" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $user->name }}" maxlength="100" required></x-teckiproadmin::backend.form-group-text>

           <div class="row">

            <div class="col-6">

                <x-teckiproadmin::backend.form-group-text name="email" label="{{ __('Email address') }}"  value="{{ old('email') ?? $user->email }}" maxlength="100" required></x-teckiproadmin::backend.form-group-text>

            </div>

            <div class="col-6">
                <x-teckiproadmin::backend.form-group-text name="phone" label="{{ __('Phone Number') }}"  value="{{ old('phone') ?? $user->phone }}" maxlength="100"></x-teckiproadmin::backend.form-group-text>

            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <x-teckiproadmin::backend.textarea name="address" label="Address">{{ old('address') ?? $user->address }}</x-teckiproadmin::backend.textarea>
            </div>
          </div>


          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="user_type" > User Type</label>
                  <div class="custom-switches-stacked mt-2">
                    <div class="row">
                      <div class="col-6 col-md-4">
                        <label class="custom-switch">
                          <input type="radio" name="type" value="{{ $model::TYPE_USER }}"  {{ $user->type == $model::TYPE_USER ? 'checked' : '' }} class="user_type custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Member</span>
                        </label>
                      </div>
                      <div class="col-6 col-md-4">
                        <label class="custom-switch">
                          <input type="radio" name="type" value="{{ $model::TYPE_ADMIN }}" {{ $user->type == $model::TYPE_ADMIN ? 'checked' : '' }} class="user_type custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Admin</span>
                        </label>
                      </div>
                    </div>
                  </div>
                  @error('type')
                      <span class="in-valid">{{ $message }}</span>
                  @enderror

              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="status" > Status </label><br>
                <label class="custom-switch mt-2">
                  <input type="checkbox" name="active" value="{{ old('active') ?? $user->active }}" class="custom-switch-input" {{ $user->active=='1' ? 'checked' : '' }}>
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>

                  @error('active')
                      <span class="invalid">{{ $message }}</span>
                  @enderror

                </label>
              </div>
            </div>
          </div>



        @if (!$user->isMasterAdmin() && $user->isAdmin())
            @include('teckiproadmin::auth.includes.roles')

            @if (!config('boilerplate.access.user.only_roles'))
                @include('teckiproadmin::auth.includes.permissions')
            @endif
        @endif





            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update User')</button>
            </x-slot>
        </x-teckiproadmin::backend.card>
    </x-teckiproadmin::forms.patch>


    <x-teckiproadmin::backend.card>

            <x-slot name="header">
                @lang('Roles & Permissions')
            </x-slot>


            <x-slot name="body">

                <div class="row">
                    <div class="col-md-6">
                        <h6>Roles</h6>
                        <br>
                        @livewire('user-roles-table',['user_id'=>$user->id])
                    </div>

                    <div class="col-md-6">
                        <h6>Permissions</h6>
                        <br>
                        @livewire('user-permission-table',['user_id'=>$user->id])
                    </div>

                </div>



            </x-slot>


        </x-teckiproadmin::backend.card>



        <!--
        Upgrade/Downgrade User Plans
        -->
        <x-teckiproadmin::forms.patch :action="route('admin.auth.user.updatesubscription', $user)">
            <x-teckiproadmin::backend.card>
                <x-slot name="header">
                    @lang('Update User Package/Plan')
                </x-slot>

                <x-slot name="body" >

                    <div class="row"  x-data="{
                        type:'{{ $PlanController::TYPE_LAUNCH }}',
                        launch_package_type:'{{ $launchSubscriptionmodel::TYPE_JVZOO }}'
                      }">

                        <div class="col-md-6 col-6" >
                            <x-teckiproadmin::backend.form-group-select id="type" x-model="type" x-on:change="onChangeType"   name="type" label="Package Type" :options="$packageOptions" selectedValue="{{ $PlanController::TYPE_LAUNCH }}"></x-teckiproadmin::backend.form-group-select>

                        </div>

                        <!-- If launch package, then provide launch options -->
                        <div class="col-md-6 col-6" >
                        </div>


                        <div class="clear-both"></div>



                        <template x-if="type==='{{ $PlanController::TYPE_SAAS }}'">
                            <div class="col-4">
                                <x-teckiproadmin::backend.form-group-select  id="package_id" name="package_id" label="Saas Packages *" :options="$saasPackages"></x-teckiproadmin::backend.form-group-select>

                            </div>
                        </template>

                        <template x-if="type==='{{ $PlanController::TYPE_LAUNCH }}'">
                            <div class="col-4">
                                <x-teckiproadmin::backend.form-group-select class="select2" id="package_id" name="package_id" label="Launch Packages *" :options="$launchPackages"></x-teckiproadmin::backend.form-group-select>
                            </div>
                        </template>

                        <template x-if="type==='{{ $PlanController::TYPE_LAUNCH }}'">
                            <div class="col-4">
                                <x-teckiproadmin::backend.form-group-select   x-model="launch_package_type" id="launch_package_type" name="launch_package_type" label="Launch Package Type *" :options="$launchPackageTypes"></x-teckiproadmin::backend.form-group-select>
                            </div>
                        </template>



                        <div class="col-4">
                            <x-teckiproadmin::backend.form-group-text name="expired_date" value="{{ old('expired_date') }}" id="datepicker" autocomplete="off" label="Expired Date *"></x-teckiproadmin::backend.form-group-text>
                        </div>

                        <div class="clear-both"></div>

                        <template x-if="type==='{{ $PlanController::TYPE_LAUNCH }}'">
                        <div class="col-6 col-md-6">
                            <x-teckiproadmin::backend.form-group-text placeholder="Required if user paid amount <> package cost" name="amount" value="{{ old('amount') }}"  label="Amount Paid *"></x-teckiproadmin::backend.form-group-text>
                        </div>
                    </template>

                        <template x-if="type==='{{ $PlanController::TYPE_LAUNCH }}' && launch_package_type!=='{{ $launchSubscriptionmodel::TYPE_CUSTOM }}'">
                        <div class="col-6 col-md-6">
                            <x-teckiproadmin::backend.form-group-text placeholder="Payment Transaction ID" name="transactionId" value="{{ old('transactionId') }}"  label="Transaction ID *"></x-teckiproadmin::backend.form-group-text>
                        </div>
                    </template>


                    </div>


                </x-slot>


                <x-slot name="footer">
                    <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Package')</button>
                </x-slot>

            </x-teckiproadmin::backend.card>
        </x-teckiproadmin::forms.patch>


         <!--
        List User Plans, refund, pause, cancel
        -->

        <x-teckiproadmin::backend.card>

            <x-slot name="header">
                @lang('Manage User Subscriptions')
            </x-slot>


            <x-slot name="body">

                @livewire('user-launch-subscription-table',['user_id'=>$user->id])



            </x-slot>


        </x-teckiproadmin::backend.card>



@endsection

@push('after-styles')
<!-- datetimepicker -->
<link href="{{ mix('css/jquery.datetimepicker.css') }}" rel="stylesheet">

<!-- select2 -->
<link href="{{ mix('css/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ mix('css/select2/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush


@push('after-scripts')

<!-- datetimepicker -->
<script src="{{ mix('js/php-date-formatter.min.js') }}"></script>
<script src="{{ mix('js/jquery.mousewheel.js') }}"></script>
<script src="{{ mix('js/jquery.datetimepicker.js') }}"></script>


<script>
$('#datepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
startDate:	new Date(),
format:'Y-m-d h:i:s',
formatDate:'Y-m-d h:i:s',
});

</script>

<!-- select2 -->
<script src="{{ mix('js/select2/select2.min.js') }}"></script>
<script src="{{ mix('js/select2/select2_custom.js') }}"></script>

@endpush
