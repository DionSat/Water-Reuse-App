@extends('layouts.master')

@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                        <h3>Heres what you submitted:</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Submission #</th>
                                <th scope="col">State</th>
                                <th scope="col">Source</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Time Submitted</th>
                                <th scope="col">Approved</th>
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