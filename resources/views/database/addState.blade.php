@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back
      </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card h-100 mt-5 shadow mx-auto">
          <h2 class="card-header text-center"> Add State </h2>
          <form method="POST" action="{{ route('stateAddSubmit') }}">
            {{ csrf_field() }}
            <div class="card-body mt-3">
              <div class="row justify-content-center">
                <div class="form-row">
                  <label class="col-md-5 col-form-label text-md-right" for="state"> State Name </label>
                  <div class="col-md-7 pl-md-0 pr-md-1">
                    <input type="text" class="form-control" id="state" name="state" placeholder="New state name...">
                  </div>
                </div>
              </div>
              <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Add State
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
            transform: scaleY(-1);
            filter: brightness(80%);
        }
    </style>
@endpush
