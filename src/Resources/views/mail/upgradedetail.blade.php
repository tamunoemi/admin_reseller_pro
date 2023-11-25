@component('mail::message')
Hello,<br><br>


@component('mail::panel')
{{ $body }}
@endcomponent


<br><br>
@component('mail::button', ['url' => $url])
Click here to sign
@endcomponent

<br>

Thanks,<br>
<b>{{ env("PRODUCT_CREATOR") }}</b>
@endcomponent
