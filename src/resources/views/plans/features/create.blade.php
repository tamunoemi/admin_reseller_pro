
@extends('teckiproadmin::layouts.app')

@section('title', __('Plans Features'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    <ul>
        <li><strong>PLAN</strong>: <strong class="text-info">{{ $details['name'] }}</strong></li>
        <li> <strong>PRICE</strong>: <strong class="text-primary">{{ $details['price'] }}</strong></li>
        <li> <strong>DESCRIPTION</strong>: <strong class="text-success">{{ $details['description'] }}</strong></li>
    </ul>

   </x-slot>

   <x-slot name="body">
    <form action="{{ route('admin.plan.features.add') }}" method="post">
        @csrf



    <div class="row">
        <div class="col-12 text-center">
             <strong>Add/remove</strong> features <br><br>
        </div>

        <div class="col-6 text-center">
            @include('teckiproadmin::flash-message')

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Please fix the following errors <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>




    </div>

    <div class="row" id="container">

        <div class="col-6">


            <x-teckiproadmin::backend.card>

                <x-slot name="header">
                    {{ __('Add')  }}
                </x-slot>

                <x-slot name="body">



                        <div class="row">
                            {{-- hidden plan id --}}
                            <x-teckiproadmin::backend.form-group-text type="hidden" name="id" value="{{ $planId }}"></x-teckiproadmin::backend.form-group-text>

                            <div class="col-md-12 col-xs-12">

                                <x-teckiproadmin::backend.form-group-text value="{{ old('code') }}" name="code" id="code" label="Feature *"></x-teckiproadmin::backend.form-group-text>
                            </div>

                            <div class="col-md-12 col-xs-12">

                                <x-teckiproadmin::backend.form-group-text value="{{ old('value') }}" name="value" id="value" label="Value *"></x-teckiproadmin::backend.form-group-text>
                            </div>

                        </div>


                </x-slot>

                <x-slot name="footer">
                    <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save</button>
                   </x-slot>

            </x-teckiproadmin::backend.card>

        </div>





        <div class="col-6">
            <x-teckiproadmin::backend.card>
                <x-slot name="header">
                    {{ __('Features List')  }}
                </x-slot>

                <x-slot name="body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                        <th>Description</th>
                                        <th>Value</th>
                                        <th></th>
                                </thead>
                                <tbody id="featurestable">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </x-slot>


            </x-teckiproadmin::backend.card>
        </div>



    </div>

</form>
   </x-slot>
</x-teckiproadmin::backend.card>


@push('after-scripts')
<script>

function getFeatures(){

    $.ajax({
            type:'GET',
            data: {id: '{{ $planId }}'},
            url: "{{ route('admin.plan.features.getPlanFeaturesTablerows') }}",
            success: (data) =>
            {
            var response = JSON.parse(data);

            if(response.status=='success'){

               $("#featurestable").html(response.message);
               $('#container').show();
            }else{
               alert(response.message);
               return false;

            }

            }
            })
}
$(function(){

    getFeatures();



            $(document).on('click','.remove',function(e){
                 var id = $(this).attr('id');
                   var token = document.getElementsByName('_token');
                    $.ajax({
                        type:'POST',
                        data: {id: id,_token: token[0].value},
                        url: "{{ route('admin.plan.features.delete') }}",
                        success: (data) =>
                        {
                        var response = JSON.parse(data);

                         alert("deleted successfully");
                         location.reload(1);

                        }
                    })
            });

})
</script>
@endpush


@endsection
