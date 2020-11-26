@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
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
