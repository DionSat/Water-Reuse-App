@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back
      </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card h-100 mt-5 shadow mx-auto">
          <h2 class="card-header text-center"> Add Link </h2>
          <form method="POST" action="{{ route('linkAddSubmit') }}">
            {{ csrf_field() }}
            <div class="card-body mt-3">
              <div class="row justify-content-center">
                <div class="form-row">
                  <label class="col-md-4 col-form-label text-md-right" for="name"> Link Name </label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" id="name" name="name" placeholder="New link Name">
                  </div>
                </div>
              </div>
              <div class="row justify-content-center mt-2 mt-md-4">
                <div class="form-row">
                  <label class="col-md-4 col-form-label text-md-right" for="link"> Link URL </label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" id="link" name="link" placeholder="New link URL">
                  </div>
                </div>
              </div>
              <div class="form-row mt-5 justify-content-center">
                <div class="col-sm-5">
                  <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Add Link
                  </button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
