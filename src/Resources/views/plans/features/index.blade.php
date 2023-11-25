
@extends('teckiproadmin::layouts.app')

@section('title', __('Plans Features'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('Features')  }}
   </x-slot>

   <x-slot name="body">



    <div class="row">

        <div class="col-6 text-center">
            <h5><strong>View</strong> features</h5>
            <br>

            <x-teckiproadmin::backend.form-group-select id="viewPlanSelectOption"   :options="$plans" optionsreverseorder="true"></x-teckiproadmin::backend.form-group-select>
       </div>

        <div class="col-6 text-center">
             <h5><strong>Add/remove</strong> features</h5>
             <br>

             <x-teckiproadmin::backend.form-group-select id="addPlanSelectOption"   :options="$plans" optionsreverseorder="true"></x-teckiproadmin::backend.form-group-select>
        </div>
    </div>

    <div class="row" id="container">




    </div>

</form>
   </x-slot>
</x-teckiproadmin::backend.card>


@push('after-scripts')
<script>
$(function(){


    $(document).on('change','#addPlanSelectOption',function(e){

        if(!e.target.value){ $('#container').hide(); return false; }

        document.location = "{{ url('admin/plan/features/create/') }}"+ '?id='+ e.target.value;

    })

})
</script>
@endpush


@endsection
