@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back
      </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card h-100 mt-5 shadow mx-auto">
          <h2 class="card-header text-center"> Add Allowed Type </h2>
          <form method="POST" action="{{ route('allowedAddSubmit') }}">
            {{ csrf_field() }}
            <div class="card-body mt-3">
              <div class="row justify-content-center">
                <div class="form-row">
                  <label class="col-md-4 col-form-label text-md-right" for="allowedText"> Allowed Text </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" id="allowedText" name="allowedText"
                           placeholder="Yes...No...Sometimes...">
                  </div>
                </div>
              </div>
              <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4 col-sm-5">
                  <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Add Allowed
                    Type
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
