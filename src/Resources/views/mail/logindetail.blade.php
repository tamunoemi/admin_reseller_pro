@component('mail::message')
Hello,<br><br>

Thank you for your patronage.<br>
Below are your login details.<br>


@component('mail::panel')
@component('mail::table')
    <tr>
        <td><b>Email:</b></td> <td>{{ $email }}</td>
    </tr>
    <tr>
        <td><b>Password:</b></td> <td>{{ $password }}</td>
    </tr>

@endcomponent

@endcomponent


<br><br>
@component('mail::button', ['url' => $url])
Click here to sign
@endcomponent

<br>

Thanks,<br>
<b>{{ env("PRODUCT_CREATOR") }}</b>
@endcomponent
