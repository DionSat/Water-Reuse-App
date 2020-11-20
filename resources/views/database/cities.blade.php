@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
        <div class="row my-3 d-flex justify-content-between">
            <div class="col-md-3">
                <a href="{{route("admin")}}" class="btn btn-primary d-block"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
            </div>
            <div class="col-md-3">
                <a href="{{route("cityAdd")}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add New </a>
            </div>
        </div>
      <div class="card">
        <div align="center" class="card-header"><h2>Cities</h2></div>
        <table class="table table-responsive-lg">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">City</th>
                <th scope="col">County</th>
                <th scope="col">State</th>
                <th scope="col" colspan="2">Actions</th>
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
                    <td>
                        <a href="{{route('modifyCity', ['city_id' => $city->city_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
        <div class="row mt-4">
            <span class="mx-auto">
                {{ $cities->links() }}
            </span>
        </div>
    </div>

@endsection

@push("css")
    <style>


    </style>
@endpush
