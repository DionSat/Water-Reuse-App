@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("sourceView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
                Manage </a>
        </div>
    </div>
    <form method="POST" action="{{route('modifySourceSubmit')}}">
        {{ csrf_field() }}
        <div class="container">
            <div class="row mt-3 mb-5">
                <div class="card h-100 shadow  mx-auto text-center">
                    <div class="card-header">
                        <h3>Current Node</h3>
                        <h4>{{$source->node_name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">New Name</span>
                                </div>
                                <input type="text" name="newSourceValue" class="form-control" aria-label="Default"
                                       aria-describedby="inputGroup-sizing-default" value="{{$source->node_name}}">
                                <input type="text" name="node_id" value="{{$source->node_id}}" hidden>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <div class="form-check form-check-inline">
                                    @if($source->is_source === true)
                                        <input class="form-check-input" id="is_source_checkbox" type="checkbox" name="is_source" checked>
                                    @else
                                        <input class="form-check-input" id="is_source_checkbox" type="checkbox" name="is_source">
                                    @endif
                                    <label class="form-check-label" for="is_source_checkbox">Source</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    @if($source->is_destination === true)
                                        <input class="form-check-input" id="is_destination_checkbox" type="checkbox" name="is_destination" checked>
                                    @else
                                        <input class="form-check-input" id="is_destination_checkbox" type="checkbox" name="is_destination">
                                    @endif
                                    <label class="form-check-label" for="is_destination_checkbox">Destination</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    @if($source->is_fixture === true)
                                        <input class="form-check-input" id="is_fixture_checkbox" type="checkbox" name="is_fixture" checked>
                                    @else
                                        <input class="form-check-input" id="is_fixture_checkbox" type="checkbox" name="is_fixture">
                                    @endif
                                    <label class="form-check-label" for="is_fixture_checkbox">Fixture</label>
                                </div>
                            </div>
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
