@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row my-3">
      <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back
      </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card h-100 mt-5 shadow mx-auto">
          <h2 class="card-header text-center"> Add Source, Destination, & Fixture </h2>
          <form method="POST" action="{{ route('reuseNodeAddSubmit') }}">
            {{ csrf_field() }}
            <div class="card-body mt-3">
              <div class="row justify-content-center">
                <div class="col-md-8">
                  <div class="form-row">
                    <label class="col-md-6 col-form-label text-md-right" for="source">
                      Source/Destination/Fixture </label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="source" name="source" placeholder="Name">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row mt-3 justify-content-center">
                <div class="col-md-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="is_source_checkbox" type="checkbox" name="is_source">
                    <label class="form-check-label" for="is_source_checkbox">Source</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="is_destination_checkbox" type="checkbox" name="is_destination">
                    <label class="form-check-label" for="is_destination_checkbox">Destination</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="is_fixture_checkbox" type="checkbox" name="is_fixture">
                    <label class="form-check-label" for="is_fixture_checkbox">Fixture</label>
                  </div>
                </div>
              </div>
              <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Add</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
