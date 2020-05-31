@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        <h1 id="h">Information</h1>
        @guest
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">How to Navigate the Website</div>
                    <div class="card-body">
                    <h2>How to Search For a Regulation</h2>
                        <p class="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris maximus aliquam mi,
                        sed egestas libero feugiat vel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Basic Website Functionality</div>
                    <h2>How to Search For a Regulation</h2>
                    <div class="card-body">
                        <p class="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris maximus aliquam mi,
                        sed egestas libero feugiat vel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registered User Functionality</div>

                    <div class="card-body">
                    <h3>Add a New Regulation</h3>
                    <p class="p">1. Navigate to the <a href="{{ route('userSubmission') }}">'Submit New Regulation' </a>page</p>
                    <p class="p">2. At the very least, enter the State you wish to submit a regulation for. You can also add County and City, but that is not a requirement.</p>
                    <p class="p">3. Enter any other required information, and then click 'Submit'. Your regulation will be reviewed by an administrator.</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center @if (Route::current()->getName() == "admin") active @endif"  style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Administrator Functionality</div>

                    <div class="card-body">
                    <h2>User Manipulation</h2>
                    <h3>Add or Delete a User</h3>
                    <p class="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris max
                        imus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu.
                        </p>
                    <h3>Give a User 'Administrator' Access</h3>
                    <p class="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris max
                        imus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endguest

    </div>


@endsection

@push("css")
    <style>
        .py-4 {
            background: rgb(2,0,36);
            text-align: center;
        }
        h1{
            color: white;
            font-family: 'Lobster';
        }
        p {
            margin-top: 3em;
            font-family: 'Lato';
        }
        #back, #font {
            color: white;
        }
    </style>
@endpush
