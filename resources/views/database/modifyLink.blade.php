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
@push("css")
  <style>

    body::before {
      content: "";
      position: fixed;
      width: 200%;
      height: 200%;
      top: -50%;
      left: -50%;
      z-index: -1;
      background-size: cover;
      background-image: url('https\3a //scontent.fhio2-1.fna.fbcdn.net/v/t15.5256-10/cp0/e15/q65/p600x600/20505009_401019313628316_6647662209365180416_n.jpg?_nc_cat\3d 102\26 ccb\3d 2\26 _nc_sid\3d ccf8b3\26 _nc_ohc\3d XdbCgFERuygAX-1bAXs\26 _nc_ht\3d scontent.fhio2-1.fna\26 oh\3d 11dfc9e7c7ba03c61b70c4b3b4f3bd0c\26 oe\3d 5FD1716B');
      no-repeat fixed center center;
      background-size: cover;
      transform: scaleY(-1);
      filter: brightness(80%);
    }
  </style>
@endpush
