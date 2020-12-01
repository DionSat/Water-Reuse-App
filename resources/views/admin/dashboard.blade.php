@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <h2 class="text-center text-light my-4">Dashboard</h2>
    <hr>

    <div class="container" id="dbStatsPage">
      <h3 class="mt-4 text-light">Locations</h3>
      <hr>
      <div class="row">
        @foreach($locationCards as $card)
          <div class="col-md-4">
            <div class="card h-100 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-lg-2 mr-xl-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                  </div>
                  <div>
                    <h1 class="my-3 mx-md-2 mx-xl-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <div class="row">
                  <div class="col-xl-6 col-lg-7">
                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i>
                      Manage </a>
                  </div>
                  <div class="col-xl-6 col-lg-5">
                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i>
                      Add </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <h3 class="mt-5 text-light">Nodes, Types, and Links</h3>
      <hr>

      <div class="row mt-3">
        @foreach($sourcesAndDestinations as $card)
          <div class="col-md-4">
            <div class="card h-100 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-lg-2 mr-xl-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                  </div>
                  <div>
                    <h1 class="my-3 mx-md-2 mx-xl-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <div class="row">
                  <div class="col-xl-6 col-lg-7">
                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i>
                      Manage </a>
                  </div>
                  <div class="col-xl-6 col-lg-5">
                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i>
                      Add </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        @foreach($allowedTypes as $card)
          <div class="col-md-4">
            <div class="card h-100 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-lg-2 mr-xl-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                  </div>
                  <div>
                    <h1 class="my-3 mx-md-2 mx-xl-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <div class="row">
                  <div class="col-xl-6 col-lg-7">
                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i>
                      Manage </a>
                  </div>
                  <div class="col-xl-6 col-lg-5">
                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i>
                      Add </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        @foreach($linksAndOther as $card)
          <div class="col-md-4">
            <div class="card h-100 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-lg-2 mr-xl-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                  </div>
                  <div>
                    <h1 class="my-3 mx-md-2 mx-xl-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <div class="row">
                  <div class="col-xl-6 col-lg-7">
                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i>
                      Manage </a>
                  </div>
                  <div class="col-xl-6 col-lg-5">
                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i>
                      Add </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>


    <div class="container" id="statsPage">
      <h3 class="mt-4 text-light">User Management</h3>
      <hr>

      <div class="row">
        @foreach($userAndEmail as $card)
          <div class="col-md-6 col-xl-3 ">
            <div class="card h-80 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                  </div>
                  <div>
                    <h1 class="m-3 flex-grow-1 w-100 text-muted"> {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="form-row mt-3 justify-content-center">
                  <div class="col-lg-8 col-xl-6">
                    <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-eye"></i> View </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        @foreach($userAndCanEmail as $card)
          <div class="col-md-6 col-xl-3">
            <div class="card h-80 shadow">
              <div class="card-body">
                <div class="d-flex">
                  <div class="p-2 mr-3 w-75">
                    <h4 class="card-title">{{$card["title"]}}</h4>
                  </div>
                  <div>
                    <h1 class="m-3 flex-grow-1 w-100 text-muted"> {{$card["count"]}}</h1>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="form-row mt-3 justify-content-center">
                  <div class="col-lg-8 col-xl-6">
                    <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-eye"></i> View </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>

  </div>

@endsection

@push("js")
