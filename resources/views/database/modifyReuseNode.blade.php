@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row my-3">
      <a href="{{route("reuseNodeView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Manage </a>
    </div>
  </div>
  <form method="POST" action="{{route('modifyReuseNodeSubmit')}}">
    {{ csrf_field() }}
    <div class="container">
      <div class="row mt-3 mb-5">
        <div class="col-md-6 mx-auto">
          <div class="card h-100 shadow  mx-auto text-center">
            <div class="card-header">
              <h3>{{$node->node_name}}</h3>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-center">
                <div class="row mb-3">
                  <label class="col-form-label" for="reuseName">Name</label>
                  <div class="col">
                    <input type="text" name="newValue" class="form-control" id="reuseName" aria-label="Default"
                           aria-describedby="inputGroup-sizing-default" value="{{$node->node_name}}">
                  </div>
                  <input type="text" name="node_id" value="{{$node->node_id}}" hidden>
                </div>
              </div>
              <div class="input-group d-flex justify-content-around my-3">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" id="is_source_checkbox" type="checkbox" name="is_source"
                         @if($node->is_source === true) checked @endif>
                  <label class="form-check-label" for="is_source_checkbox">Source</label>
                </div>
                <div class="form-check form-check-inline">

                  <input class="form-check-input" id="is_destination_checkbox" type="checkbox" name="is_destination"
                         @if($node->is_destination === true) checked @endif>
                  <label class="form-check-label" for="is_destination_checkbox">Destination</label>
                </div>
                <div class="form-check form-check-inline">

                  <input class="form-check-input" id="is_fixture_checkbox" type="checkbox" name="is_fixture"
                         @if($node->is_fixture === true) checked @endif>
                  <label class="form-check-label" for="is_fixture_checkbox">Fixture</label>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-8 mx-auto">
                  <button type="submit" class="btn btn-success btn-large btn-block mx-auto"><i class="fas fa-edit"></i>
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
