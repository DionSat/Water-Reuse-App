@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{route("linkView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Manage </a>
    </div>
  </div>
  <div class="container">
    <div class="row mt-3 mb-5">
      <div class="col-md-6 col-xl-5 mx-auto">
        <div class="card h-100 shadow  mx-auto">
          <div class="card-header text-center">
            <h3>Current Link URL</h3>
            <h4>{{$link->linkText}}</h4>
          </div>
          <form method="POST" action="{{route('modifyLinkSubmit')}}">
            {{ csrf_field() }}
            <div class="card-body">
              <label for="linkName">Name</label>
              <input type="text" name="newLinkName" class="form-control" id="linkName" aria-label="Default"
                     aria-describedby="inputGroup-sizing-default" value="{{$link->name}}">
              <input type="text" name="link_id" value="{{$link->link_id}}" hidden>
              <label for="linkText">Link URL </label>
              <input type="text" name="newLinkText" class="form-control" id="linkText" aria-label="Default"
                     aria-describedby="inputGroup-sizing-default" value="{{$link->linkText}}">
              <label for="linkStatus">Link Status</label>
              <select class="custom-select" name="newLinkStatus" id="linkStatus">
                <option @if($link->status === 'valid') selected @endif value="valid">Valid</option>
                <option @if($link->status === 'broken') selected @endif value="broken">Broken
                </option>
                <option @if($link->status === 'unknown' || $link->status === NULL) selected
                        @endif value="unknown">Unknown
                </option>
              </select>
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
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
