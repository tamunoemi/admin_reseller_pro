@extends('teckiproadmin::layouts.app')


@section('title', __('Mail Settings'))

@section('content')


    <div class="row">
        <div class="col-md-8">
            <x-teckiproadmin::backend.card>
                <x-slot name="body">

                    <form action="{{ route('admin.setting.mail') }}" method="post">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif


                        <div class="row">

                            <div class="col-md-8 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_HOST') }}" name="MAIL_HOST"
                                    label="MAIL HOST" placeholder="{{ __('Enter smtp mail host') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_PORT') }}" name="MAIL_PORT"
                                    label="MAIL PORT" placeholder="{{ __('Enter smtp port') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-md-8 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_USERNAME') }}" name="MAIL_USERNAME"
                                    label="MAIL USERNAME" placeholder="{{ __('Enter smtp username') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_PASSWORD') }}" name="MAIL_PASSWORD"
                                    label="MAIL PASSWORD" placeholder="{{ __('Enter smtp password') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-md-4 col-xs-5">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_ENCRYPTION') }}" name="MAIL_ENCRYPTION"
                                    label="MAIL ENCRYPTION" placeholder="{{ __('Enter smtp encryption') }}">
                                </x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-8 col-xs-7">
                                <x-teckiproadmin::backend.form-group-text value="{{ env('MAIL_FROM_ADDRESS') }}" name="MAIL_FROM_ADDRESS"
                                    label="MAIL FROM ADDRESS" placeholder="{{ __('Mail from address') }}">
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
