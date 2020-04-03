@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("database")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Cities </h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">City</th>
                <th scope="col">County</th>
                <th scope="col">State</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cities as $city)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$city->cityName}}</td>
                    <td>{{$city->county->countyName}}</td>
                    <td>{{$city->county->state->stateName}}</td>
                    <td>
                        <form method="POST" action="{{ route('deleteCity') }}">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="cityId-{{$city->id}}" name="city_id" value="{{$city->city_id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection