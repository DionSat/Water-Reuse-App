@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("linkView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
                Manage </a>
        </div>
    </div>
    <form method="POST" action="{{route('modifyLinkSubmit')}}">
        {{ csrf_field() }}
        <div class="container">
            <div class="row mt-3 mb-5">
                <div class="card h-100 shadow  mx-auto text-center">
                    <div class="card-header">
                        <h3>Current Link</h3>
                        <h4>{{$link->linkText}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">New Name</span>
                                </div>
                                <input type="text" name="newLinkValue" class="form-control" aria-label="Default"
                                       aria-describedby="inputGroup-sizing-default" value="{{$link->linkText}}">
                            </div>
                            <input type="text" name="link_id" value="{{$link->link_id}}" hidden>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-large btn-block"><i class="fas fa-edit"></i> Edit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
