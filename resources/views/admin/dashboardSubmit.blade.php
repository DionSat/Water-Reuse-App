@extends('layouts.master')


@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Thanks for submitting that form!</h5></div>

                    <div class="card-body">
                        <h5>You submitted the following information: </h5>
                        <ul class="list-group">
                            <li class="list-group-item">Name: {{$name}}</li>
                            <li class="list-group-item">Integer 1: {{$int1}}</li>
                            <li class="list-group-item">Integer 2: {{$int2}}</li>
                        </ul>
                            <hr>
                            <h4>The sum of those integers is: {{$sum}}</h4>

                        <a href="{{route("admin")}}"> <button type="submit" class="btn btn-primary float-right mt-3">Go Back <i class="fas fa-check-circle"></i> </button></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

