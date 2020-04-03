@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="card col-8 mx-auto">
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone Number</th>
                        @if($user->countryCode)
                            <td>{{$user->countryCode}}-{{$user->phoneNumber}}</td>
                        @else
                            <td>{{$user->phoneNumber}}</td>
                        @endif
                    </tr>
                    <tr>
                        <th scope="row">Street Address</th>
                        <td>{{$user->streetAddress}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Secondary Street Address</th>
                        <td>{{$user->address2}}</td>
                    </tr>
                    <tr>
                        <th scope="row">City</th>
                        <td>{{$user->city}}</td>
                    </tr>
                    <tr>
                        <th scope="row">State</th>
                        <td>{{$user->state}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Zip Code</th>
                        <td>{{$user->zipCode}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Job Title</th>
                        <td>{{$user->jobTitle}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Company</th>
                        <td>{{$user->company}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Reason for Using Recode</th>
                        <td>{{$user->reason}}</td>
                    </tr>
                    <tr>
                        <th scope="row">We can contact you</th>
                        @if ($user->canContact === 'True')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
@endsection
