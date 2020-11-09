@extends('layouts.master')

@section('body')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card col-8 mx-auto" style="border: none; text-align: center; background-color: transparent; color: white;" >
            <h2>Account page</h2>
            <br/>
        </div>
        <div class="card col-8 mx-auto">
            <div class="card-body">
                <table class="table table-responsive">
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
                            <td>{{$user->formatPhoneNumber()}}</td>
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
                        <th scope="row">Email</th>
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
                        @if ($user->can_contact === True)
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
                <div class="bd-example">
                    <button type="button" onclick="window.location='{{ route("updatePage") }}'"
                            class="btn btn-primary"> Edit Account Information
                    </button>
                    <button type="button" onclick="window.location='{{ route("password") }}'"
                            class="btn btn-primary">
                        Change PASSWORD
                    </button>
                </div>
            </div>
        </div>

@endsection
