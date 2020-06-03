@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        @guest
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="container">
                    <h2>How To Search For A Regulation</h2>
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
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-search-tab" data-toggle="tab" href="#nav-search" role="tab" aria-controls="nav-search" aria-selected="true">Search For A Regulation</a>
                    <a class="nav-item nav-link" id="nav-addReg-tab" data-toggle="tab" href="#nav-addReg" role="tab" aria-controls="nav-addReg" aria-selected="false">Add A New Regulation</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Administrator Information</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-search" role="tabpanel" aria-labelledby="nav-search-tab">
                <h2>How To Search For A Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('search') }}" target="_blank"> Search </a>page</p>
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
            <div class="tab-pane fade" id="nav-addReg" role="tabpanel" aria-labelledby="nav-addReg-tab">
                <h2>Add a New Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('userSubmission') }}" target="_blank">'Submit New Regulation' </a>page</p>
                <p>2. At the very least, enter the State you wish to submit a regulation for. You can also select a County and City, but that is not a requirement.</p>
                <p>3. You may also enter a new county or city by clicking the 'Add A New State, County or City' button, and entering the new county and / or city name.</p>
                <p>3. Select a source and a destination, and select the water reuse allowance (is allowed, not allowed, maybe allowed).</p>
                <p>4. Add optional links to the water reuse regulation.</p>
                <p>5. Either click "Submit" if you only have one source and destination, or click the "Add another regulation" button, and repeat steps 3 - 4.</p>

            </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                   <div class="row justify-content-center @if (Route::current()->getName() == "admin") active @endif"  style="margin: 3em">
                        <div class="container">
                            <ul>
                                <li>
                                    <a href="#userManip">User Manipulation</a>
                                </li>
                                <li>
                                    <a href="#deleteReg">Delete A Regulation</a>
                                </li>
                                <li>
                                    <a href="#deleteArea">Delete A State, County or City</a>
                                </li>
                            </ul>
                            <hr id="userManip">
                            <h2>User Manipulation</h2>
                            <hr id="deleteReg">
                            <h2>Delete A Regulation</h2>
                            <hr id="deleteArea">
                            <h2>Delete A State, County or City</h2>
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
        ul{
            text-align: left;
        }
        img{
            width: 485px;
            height: 300px;
            border: 1px solid black !important;
        }
        #nav-addReg, #nav-search, #nav-admin{
            margin: 2em 0;
        }
        #nav-addReg > *, #nav-search > *, #nav-admin > *{
            margin: 2em 0;
        }
    </style>
@endpush
