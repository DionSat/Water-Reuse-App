@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="type-selector">
            <h3 class="text-center mt-5"> Select the property type: </h3>
            <div class="row justify-content-center mt-0 mt-md-5">
                <div class="col-md-4">
                    <div class="card text-center selection-card commercial border-dark initial-selection">
                        <div class="card-body" title="Search commercial regulations">
                            <img class="display-icon" src="{{url('/img/commercial-icon.png')}}" alt="Commercial Icon"/>
                            <h1> Commercial </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="card text-center selection-card residential border-dark initial-selection">
                        <div class="card-body" title="Search residential regulations">
                            <img class="display-icon" src="{{url('/img/residential-icon.png')}}" alt="Residential Icon"/>
                            <h1> Residential </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="search-page" class="mt-0 mt-md-5">
            <div class="row d-flex justify-content-center">
                <div class="search-col col-md-8 card p-5 shadow shadow-lg">
                    <div class="d-flex justify-content-center">
                        <div class="mr-2">
                            <div class="card text-center selection-card commercial">
                                <div class="card-body py-0 px-3" title="Search commercial regulations">
                                    <img class="display-icon-small mt-2" src="{{url('/img/commercial-icon.png')}}" alt="Commercial Icon"/>
                                    <h5> Commercial </h5>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card text-center selection-card residential">
                                <div class="card-body py-0 px-3" title="Search residential regulations">
                                    <img class="display-icon-small mt-2" src="{{url('/img/residential-icon.png')}}" alt="Residential Icon"/>
                                    <h5> Residential </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search mt-3">
                        <h3 id="search-title" class="text-center">Search for Location </h3>
                        <hr>
                        <div class="col-md-12">
                            <div class="accordion" id="accordionExample">
                                <!--Search by S.C.C.-->
                                <div class="card" style="border: none; ">
                                    <!--button name-->
                                    <div class="card" id="headingOne">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" style="font-size: 20px; color: black; text-decoration:none">
                                            <strong>Search by State County City</strong>
                                        </button>
                                    </div>
                                    <!--search page-->
                                    <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card" style="margin-top: 40px; border: none">
                                            <form method="GET" action="{{route("search-submit")}}" class="text-center">
                                                {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <label for="stateSelect" class="col-md-3 col-form-label col-form-label-lg"> <strong> State </strong> </label>
                                                    <div class="col-md-8">
                                                        <select id="stateSelect" name="state_id" class="form-control form-control-lg">
                                                            <option value="-1" disabled selected>Select a state</option>
                                                            @foreach($states as $state)
                                                                @if($state->is_approved)
                                                                    <option value="{{$state->state_id}}">{{$state->stateName}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="countySelect" class="col-md-3 col-form-label col-form-label-lg"> <strong> County </strong> </label>
                                                    <div class="col-md-8">
                                                        <i id="countySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                                        <select id="countySelect" name="county_id" class="form-control form-control-lg">
                                                            <option value="-1" disabled selected>Select a state first</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="citySelect" class="col-md-3 col-form-label col-form-label-lg"> <strong> City </strong> </label>
                                                    <div class="col-md-8">
                                                        <i id="citySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                                        <select id="citySelect" name="city_id" class="form-control form-control-lg">
                                                            <option value="-1" disabled selected>Select a county first</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input id="searchType" name="searchType" class="d-none" type="text" value="residential">
                                                <button id="searchButton" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;margin-bottom: 20px;" type="submit" disabled="true"> <i class="fas fa-search"></i> Search </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--Search by Address-->
                                <div class="card" style="border: none">
                                    <!--button name-->
                                    <div class="card" id="headingTwo">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" style="font-size: 20px; color:black; text-decoration:none">
                                            <strong>Search by Address</strong>
                                        </button>
                                    </div>
                                    <!--Address Search page-->
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample" >
                                        <form class="card" style="border: none;margin-top: 40px">
                                            <form method="GET" action="{{route("search-submit")}}" class="text-center">
                                            {{ csrf_field() }}
                                            <!--Address Form-->
                                                <form>
                                                    <div class="form-group row">
                                                        <label for="StreetAddressInput" class="col-md-4 col-form-label col-form-label-lg"><strong>Street Address</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="StreetAddressInput" placeholder="Type the Street Address">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="RouteInput" class="col-md-4 col-form-label col-form-label-lg"><strong>Route</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="RouteInput" placeholder="Type the Route">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="CityInput" class="col-md-4 col-form-label col-form-label-lg"><strong>City</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="CityInput" placeholder="Type the City">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="StateInput" class="col-md-4 col-form-label col-form-label-lg"><strong>State</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="StateInput" placeholder="Type the State">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="ZipCodeInput" class="col-md-4 col-form-label col-form-label-lg"><strong>Zip Code</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="ZipCodeInput" placeholder="Type the Zip Code">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="CountryInput" class="col-md-4 col-form-label col-form-label-lg"><strong>Country</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" id="CountryInput" placeholder="Type the Country">
                                                        </div>
                                                    </div>
                                                </form>
                                            </form>
                                        </form>
                                        <input id="searchType" name="searchType" class="d-none" type="text" value="residential">
                                        <button id="searchAddressButton" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;margin-bottom: 20px;" type="submit" disabled="true"> <i class="fas fa-search"></i> Search </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("css")
    <style>
        .display-icon {
            height: 165px;
        }
        .display-icon-small{
            height: 65px;
        }
        .fa-pulse {
            font-size: 25px;
        }
        .selection-card{
            transition: 0.25s;
            cursor: pointer;
        }
        #search-page {
            display: none;
        }
    </style>
@endpush


@push("js")
    <script src="{{ URL::asset('/libraries/axios.min.js') }}"></script>
    <script>

        $(".initial-selection").hover(function () {
                $(this).removeClass("border-dark");
                $(this).addClass("shadow bg-primary text-light border-none");
            },
            function () {
                $(this).removeClass("shadow bg-primary text-light border-none");
                $(this).addClass("border-dark");
            });

        $(".selection-card").click(function () {
            $(".type-selector").hide();
            $("#search-page").show();
            if($(this).hasClass("commercial")) {
                $(".commercial").removeClass("border-dark");
                $(".commercial").addClass("bg-primary text-light border-none");
                $(".residential").removeClass("bg-primary text-light");
                $(".residential").addClass("border-dark");
                $("#searchType").attr("value","commercial");
                $("#search-title").text("Searching for Commercial Locations");
            } else {
                $(".residential").removeClass("border-dark");
                $(".residential").addClass("bg-primary text-light border-none");
                $(".commercial").removeClass("bg-primary text-light");
                $(".commercial").addClass("border-dark");
                $("#searchType").attr("value","residential");
                $("#search-title").text("Searching for Residential Locations");
            }
        });

        //if type something in text area, init the search button
        $("#AddressInput").on('input',function (){
            initSearch();
        });
        function initSearch() {
            $("#searchAddressButton").removeAttr("disabled");
        }
        $("#searchAddressButton").click(function (){
            //need to work
            //when click the searchAddressButton, ...
        });

        function enableSearch() {
            $("#searchButton").removeAttr("disabled");
        }

        function showCountySpinner() {
            $("#countySpinner").removeClass("d-none");
            $("#countySelect").addClass("d-none");
        }

        function hideCountySpinner() {
            $("#countySpinner").addClass("d-none");
            $("#countySelect").removeClass("d-none");
        }

        function showCitySpinner() {
            $("#citySpinner").removeClass("d-none");
            $("#citySelect").addClass("d-none");
        }

        function hideCitySpinner() {
            $("#citySpinner").addClass("d-none");
            $("#citySelect").removeClass("d-none");
        }


        $( "#stateSelect" ).change(function() {
            enableSearch();
            showCountySpinner();
            axios.get("{{route("counties-api")}}"+"/"+stateSelect.value)
                .then(function (response) {
                    hideCountySpinner();
                    if(response.data.length != 0){
                        $("#countySelect").html('<option id="chooseCounty" value="-1" disabled selected>Choose...</option>'+
                            response.data.sort(function (a,b) {
                                if(a.countyName < b.countyName) { return -1; }
                                if(a.countyName > b.countyName) { return 1; }
                                else {return 0;}
                            }).map(obj => obj.is_approved && "<option value='"+obj.county_id+"'>"+obj.countyName+"</option>").join("\n"));
                    } else {
                        $("#countySelect").html("<option value='' disabled selected>No counties found in state</option>");
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    alert("A error occurred! Please try refreshing the page.")
                })
        });
        $( "#countySelect" ).change(function() {
            showCitySpinner();
            axios.get("{{route("cities-api")}}"+"/"+countySelect.value)
                .then(function (response) {
                    hideCitySpinner();
                    console.log(response.data);
                    console.log(response.data.length);
                    if(response.data.length != 0){
                        $("#citySelect").html('<option id="chooseCounty" value="-1" disabled selected>Choose...</option>'+
                            response.data.sort(function (a,b) {
                                if(a.cityName < b.cityName) { return -1; }
                                if(a.cityName > b.cityName) { return 1;}
                                else {return 0;}
                            }).map(obj => obj.is_approved && "<option value='"+obj.city_id+"'>"+obj.cityName+"</option>").join("\n")); //TODO: Check if this is correct after approving a city
                    } else {
                        $("#citySelect").html("<option value='' disabled selected>No cities found in county</option>");
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    alert("A error occurred! Please try refreshing the page.")
                })
        });

        $("#searchButton").click(function () {
            $(this).html("<i class=\"fas fa-spinner fa-pulse \"></i>");
        });

    </script>
@endpush

