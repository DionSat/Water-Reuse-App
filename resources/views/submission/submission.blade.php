@extends('layouts.master')

@section('body')
    <div class="container">
        <h3 class="text-center">Heres what you submitted:</h3>
        <table class="table w-75 mt-4 mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">View</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <body>
            @php
            $a = 1
            @endphp
                @foreach($stateSubmissions as $state)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$state->source->sourceName}}</td>
                        <td>{{$state->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('stateSubmission')."/".$state->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($citySubmissions as $city)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$city->source->sourceName}}</td>
                        <td>{{$city->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('citySubmission')."/".$city->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($countySubmissions as $county)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$county->source->sourceName}}</td>
                        <td>{{$county->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('countySubmission')."/".$county->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($stateApproved as $stateAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$stateAp->source->sourceName}}</td>
                        <td>{{$stateAp->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('stateApprove')."/".$stateAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
                @foreach($cityApproved as $cityAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$cityAp->source->sourceName}}</td>
                        <td>{{$cityAp->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('cityApprove')."/".$cityAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
                @foreach($countyApproved as $countyAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$countyAp->source->sourceName}}</td>
                        <td>{{$countyAp->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('countyApprove')."/".$countyAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection