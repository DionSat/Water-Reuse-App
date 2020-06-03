@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        <h1 id="h">Information</h1>
        @guest
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="container">
                    <h2>How Search For A Regulation</h2>
                    <p>1. Navigate to the <a href="{{ route('search') }}"> Search </a>page</p>
                    <p>2. Select either 'Commercial' or 'Residential'</p>
                    <img src="img/searchExample.png"></img>
                    <p>3. First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu.</p>
                    <img src="img/searchExample1.png"></img>
                    <p>4. After selecting the region you wish to search for, click on the 'Search' button.</p>
                    <img src="img/searchExample2.png"></img>
                    <p>5. At this point, you can either scroll through the search results, or narrow them down by selecting a source and destination in the dropdown menues.</p>
                    <img src="img/searchExample3.png"></img>
                    <h4>Disclaimer</h4>
                    <p>If the state, county or city does not have any water reuse information, or if the state, county or city is not present in the search dropdown menus, this does not mean there are no regulations. It just means they have not been added to this site. Please search your local government web pages to find the water reuse information you need.</p>
                </div>
            </div>
        </div>
        @else
            <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="container">
                    <h2>How Search For A Regulation</h2>
                    <p>1. Navigate to the <a href="{{ route('search') }}"> Search </a>page</p>
                    <p>2. Select either 'Commercial' or 'Residential'</p>
                    <img src="img/searchExample.png"></img>
                    <p>3. First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu.</p>
                    <img src="img/searchExample1.png"></img>
                    <p>4. After selecting the region you wish to search for, click on the 'Search' button.</p>
                    <img src="img/searchExample2.png"></img>
                    <p>5. At this point, you can either scroll through the search results, or narrow them down by selecting a source and destination in the dropdown menues.</p>
                    <img src="img/searchExample3.png"></img>
                    <h4>Disclaimer</h4>
                    <p>If the state, county or city does not have any water reuse information, or if the state, county or city is not present in the search dropdown menus, this does not mean there are no regulations. It just means they have not been added to this site. Please search your local government web pages to find the water reuse information you need.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                    <h2>Add a New Regulation</h2>
                    <p>1. Navigate to the <a href="{{ route('userSubmission') }}">'Submit New Regulation' </a>page</p>
                    <p>2. At the very least, enter the State you wish to submit a regulation for. You can also select a County and City, but that is not a requirement.</p>
                    <p>3. You may also enter a new county or city by clicking the 'Add A New State, County or City' button, and entering the new county and / or city name.</p>
                    <p>3. Select a source and a destination, and select the water reuse allowance (is allowed, not allowed, maybe allowed).</p>
                    <p>4. Add optional links to the water reuse regulation.
                    <p>5. Either click "Submit" if you only have one source and destination, or click the "Add another regulation" button, and repeat steps 3 - 4.</p></p>
            </div>
        </div>
        <div class="row justify-content-center @if (Route::current()->getName() == "admin") active @endif"  style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Administrator Functionality</div>

                    <div class="card-body">
                    <h3>Add or Delete a User</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris max
                        imus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu.
                        </p>
                    <h3>Give a User 'Administrator' Access</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
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
            text-align: center;
        }
        p {
            margin-top: 3em;
        }
        img{
            width: 485px;
            height: 300px;
        }
        .col-md-8{
            border-bottom: 1px solid black;
            margin-bottom: 1em;
            padding: 1em;
        }
        h2{
            margin-bottom: 2em !important;
        }
    </style>
@endpush
