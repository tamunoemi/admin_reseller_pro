  @extends('teckiproadmin::layouts.app')


  @section('title', __('Brand Settings'))

  @section('content')



   <div class="row">
    <div class="col-md-12 btn btn">
      
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            Please fix the following errors
        </div>
        @endif
    
        <div>
   </div>

      <div class="row">
          <div class="col-md-6">
            <form action="{{ route('admin.setting.brand') }}" method="post" enctype="multipart/form-data">
                @csrf
             
              <x-teckiproadmin::backend.card>
                  <x-slot name="body">

                     

                       

                          <div class="row">

                              <div class="col-md-6 col-xs-12">
                                  <x-teckiproadmin::backend.form-group-text value="{{ env('APP_URL') }}" name="APP_URL"
                                      label="APP URL" placeholder="{{ __('Enter domain url for this app') }}">
                                  </x-teckiproadmin::backend.form-group-text>
                              </div>

                              <div class="col-md-6 col-xs-12">
                                  <x-teckiproadmin::backend.form-group-text value="{{ env('APP_NAME') }}" name="APP_NAME"
                                      label="APP NAME" placeholder="{{ __('Enter name of app') }}">
                                  </x-teckiproadmin::backend.form-group-text>
                              </div>


                          </div>



                  </x-slot>

                  <x-slot name="footer">
                      <button name="submit" type="submit" name="general" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                          Save</button>
                  </x-slot>
                  </form>
              </x-teckiproadmin::backend.card>

          </div>


          <div class="col-md-6">
            <form action="{{ route('admin.setting.brand') }}" method="post" enctype="multipart/form-data">
                @csrf
              
            
              <x-teckiproadmin::backend.card>
                  <x-slot name="body">

                


                          <div class="row">

                              <div class="col-md-6 col-xs-6">
                                  <x-teckiproadmin::backend.form-group-text type="file" value="{{ asset('logo.png') }}"
                                      name="logo" label="APP LOGO" placeholder="{{ __('Replace app logo') }}">
                                  </x-teckiproadmin::backend.form-group-text>
                              </div>

                              <div class="col-md-2 col-xs-6">
                                  <img src="{{ asset('logo.png') }}" style="max-width: 100%">
                              </div>


                          </div>




                  </x-slot>

                  <x-slot name="footer">
                      <button name="submit" type="submit" name="logo" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                          Save</button>
                  </x-slot>
                  </form>
              </x-teckiproadmin::backend.card>




              <x-teckiproadmin::backend.card>
                <form action="{{ route('admin.setting.brand') }}" method="post" enctype="multipart/form-data">
                    @csrf
               
                  <x-slot name="body">

                     

                       

                          <div class="row">

                              <div class="col-md-6 col-xs-6">
                                  <x-teckiproadmin::backend.form-group-text type="file"
                                      value="{{ asset('favicon.ico') }}" name="favicon" label="APP FAVICON"
                                      placeholder="{{ __('Replace app favicon. Must be .ico') }}">
                                  </x-teckiproadmin::backend.form-group-text>
                              </div>

                              <div class="col-md-2 col-xs-6">
                                <img src="{{ asset('favicon.ico') }}" style="max-width: 100%">
                            </div>




                          </div>



                  </x-slot>

                  <x-slot name="footer">
                      <button name="submit" type="submit" name="favicon" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                          Save</button>
                  </x-slot>
                  </form>
              </x-teckiproadmin::backend.card>



          </div>
      </div>



  @endsection
