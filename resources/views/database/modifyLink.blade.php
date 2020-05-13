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
                <div class="col-md-4 mx-auto">
                    <div class="card h-100 shadow  mx-auto text-center">
                        <div class="card-header">
                            <h3>Current Link URL</h3>
                            <h4>{{$link->linkText}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Name</label>
                                    </div>
                                    <input type="text" name="newLinkName" class="form-control" aria-label="Default"
                                           aria-describedby="inputGroup-sizing-default" value="{{$link->name}}">
                                </div>
                                <input type="text" name="link_id" value="{{$link->link_id}}" hidden>
                            </div>
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Link URL </label>
                                    </div>
                                    <input type="text" name="newLinkText" class="form-control" aria-label="Default"
                                           aria-describedby="inputGroup-sizing-default" value="{{$link->linkText}}">
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Link Status</label>
                                </div>
                                <select class="custom-select" name="newLinkStatus">
                                    <option @if($link->status === 'valid') selected @endif value="valid">Valid</option>
                                    <option @if($link->status === 'broken') selected @endif value="broken">Broken
                                    </option>
                                    <option @if($link->status === 'unknown' || $link->status === NULL) selected
                                            @endif value="unknown">Unknown
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-large btn-block"><i
                                            class="fas fa-edit"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
@endsection
