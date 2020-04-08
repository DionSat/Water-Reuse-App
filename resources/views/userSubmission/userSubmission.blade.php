@extends('layouts.master')

@section('body')
    <h2 class="text-center my-3"> User Submissions</h2>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                    <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Submission #</th>
                                <th scope="col">Source</th>
                                <th scope="col">Destination</th>
                                <th scope="col">
                                <button type="submit" class="btn btn-primary"> view </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                    <tr>
        
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection