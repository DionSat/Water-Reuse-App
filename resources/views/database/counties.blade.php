@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("database")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Counties </h2>
        <table class="table w-75 mt-4 mx-auto">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">County</th>
                <th scope="col">State</th>
                <th scope="col" colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($counties as $county)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$county->countyName}}</td>
                    <td>{{$county->state->stateName}}</td>
                    <td>
                        <form method="POST" action="{{ route('deleteCounty') }}">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="countyId-{{$county->county_id}}" name="county_id" value="{{$county->county_id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{route('modifyCounties', ['county_id' => $county->county_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
