@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="type-selector">
            <h3 class="text-center mt-5"> Select the property type: </h3>
            <div class="row justify-content-center mt-0 mt-md-5">
                <div class="col-md-4">
                    <div class="card text-center selection-card commercial border-dark initial-selection">
                        <div class="card-body">
                            <i class="display-icon fas fa-store"></i>
                            <h1> Commercial </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="card text-center selection-card residential border-dark initial-selection">
                        <div class="card-body">
                            <i class="display-icon fas fa-home"></i>
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
                                <div class="card-body py-0 px-3">
                                    <i class="display-icon-small fas fa-store mt-2"></i>
                                    <h5> Commercial </h5>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card text-center selection-card residential">
                                <div class="card-body py-0 px-3">
                                    <i class="display-icon-small fas fa-home mt-2"></i>
                                    <h5> Residential </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search mt-3">
                        <h3 id="search-title" class="text-center">Search for Location </h3>
                        <hr>
                        <form method="GET" action="{{route("search-submit")}}" class="text-center">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="stateSelect" class="col-md-3 col-form-label col-form-label-lg"> <strong> State </strong> </label>
                                <div class="col-md-9">
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
                                <div class="col-md-9">
                                    <i id="countySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                    <select id="countySelect" name="county_id" class="form-control form-control-lg">
                                        <option value="-1" disabled selected>Select a state first</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="citySelect" class="col-md-3 col-form-label col-form-label-lg"> <strong> City </strong> </label>
                                <div class="col-md-9">
                                    <i id="citySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                    <select id="citySelect" name="city_id" class="form-control form-control-lg">
                                        <option value="-1" disabled selected>Select a county first</option>
                                    </select>
                                </div>
                            </div>
                            <input id="searchType" name="searchType" class="d-none" type="text" value="residential">
                            <button id="searchButton" class="btn btn-primary btn-lg btn-block mt-5" type="submit" disabled="true"> <i class="fas fa-search"></i> Search </button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("css")
    <style>
        .display-icon {
            font-size: 100px;
        }
        .display-icon-small{
            font-size: 25px;
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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

