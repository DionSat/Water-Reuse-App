@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-6">
                        <div class="flex-row flex-wrap">
                            <ul class="list-group">
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Name</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Email</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Primary Street Address</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Secondary Street Address</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">City</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">State</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Zip Code</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Job Title</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Company</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Phone number</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Reason for using Recode</li>
                                <li class="list-group-item p-3 font-weight-bold list-group-item-light">Allow us to contact you</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="flex-row flex-wrap">
                            <ul class="list-group">
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->name}}</li>
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->email}}</li>
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->streetAddress}}</li>
                                @isset(Auth::user()->address2)
                                    <li class="list-group-item p-3 list-group-item-info"> {{Auth::user()->address21}} </li>
                                @endisset
                                    @empty(Auth::user()->address2)
                                    <li class="list-group-item p-3 list-group-item-info font-weight-bold list-group-item-info:w">N/A</li>
                                        @endempty
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->city}}</li>
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->state}}</li>
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->zipCode}}</li>
                                @isset(Auth::user()->jobTitle)
                                    <li class="list-group-item p-3 list-group-item-info"> {{Auth::user()->jobTitle}} </li>
                                @endisset
                                @empty(Auth::user()->jobTitle)
                                    <li class="list-group-item p-3 font-weight-bold list-group-item-info">N/A</li>
                                @endempty
                                @isset(Auth::user()->company)
                                    <li class="list-group-item p-3 list-group-item-info"> {{Auth::user()->company}} </li>
                                @endisset
                                @empty(Auth::user()->company)
                                    <li class="list-group-item p-3 list-group-item-info font-weight-bold">N/A</li>
                                @endempty
                                <li class="list-group-item p-3 list-group-item-info">{{Auth::user()->phoneNumber}}</li>
                                @isset(Auth::user()->reason)
                                    <li class="list-group-item p-3 list-group-item-info"> {{Auth::user()->reason}} </li>
                                @endisset
                                @empty(Auth::user()->reason)
                                    <li class="list-group-item p-3 list-group-item-info font-weight-bold">N/A</li>
                                @endempty
                                @if(Auth::user()->contactList === True)
                                    <li class="list-group-item p-3 list-group-item-info">Yes</li>
                                    @else
                                    <li class="list-group-item p-3 list-group-item-info">No</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group row col-md-6 pt-2">
                    <button type="button" onclick="window.location='{{ route("updatePage") }}'"
                            class="btn btn-primary"> Edit Account Information
                    </button>
                    <button type="button" onclick="window.location='{{ route("password") }}'" class="btn btn-primary">
                        Change password
                    </button>
                </div>
            </div>
        </div>
@endsection
