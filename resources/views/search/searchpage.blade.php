@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="type-selector">
            <h3 class="text-center mt-5"> Select the property type: </h3>
            <div class="row justify-content-center mt-0 mt-md-5">
                <div class="col-md-4">
                    <div class="card text-center selection-card commercial border-dark">
                        <div class="card-body">
                            <i class="display-icon fas fa-industry"></i>
                            <h1> Commercial </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center selection-card residential border-dark">
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
                <div class="search-col col-md-8">
                    <div class="card">
                        <div class="card-header text-center"><h3 id="search-title">Search for Location </h3></div>
                        <div class="card-body">
                            <form method="POST" action="{{route("search-submit")}}" class="w-75 mx-auto text-right">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="stateSelect" class="col-md-4 col-form-label"> <strong> State </strong> </label>
                                    <div class="col-md-6 text-center">
                                        <select id="stateSelect" name="state_id" class="form-control">
                                            <option value="" disabled selected>Select a state</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->state_id}}">{{$state->stateName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="countySelect" class="col-md-4 col-form-label"> <strong> County </strong> </label>
                                    <div class="col-md-6 text-center">
                                        <i id="countySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                        <select id="countySelect" name="county_id" class="form-control">
                                            <option value="" disabled selected>Select a state first</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="citySelect" class="col-md-4 col-form-label"> <strong> City </strong> </label>
                                    <div class="col-md-6 text-center">
                                        <i id="citySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                        <select id="citySelect" name="city_id" class="form-control">
                                            <option value="" disabled selected>Select a county first</option>
                                        </select>
                                    </div>
                                </div>
                                <input id="searchType" name="searchType" class="d-none" type="text" value="residential">
                                <button id="searchButton" class="btn btn-primary mx-auto btn-block w-50 mt-4" type="submit"> <i class="fas fa-search"></i> Search </button>
                             </form>
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
            font-size: 100px;
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

        $(".selection-card").hover(function () {
            $(this).removeClass("border-dark");
            $(this).addClass("shadow border border-info");
        },
        function () {
            $(this).removeClass("shadow border border-info");
            $(this).addClass("border-dark");
        });

        $(".selection-card").click(function () {
            $(".type-selector").hide();
            $("#search-page").show();
            if($(this).hasClass("commercial")) {
                $("#searchType").val("commercial");
                $("#search-title").text("Search for Commercial Locations");
            } else {
                $("#searchType").val("residential");
                $("#search-title").text("Search for Residential Locations");
            }
        });

        function disableSearch() {
            $("#searchButton").attr("disabled", true);
        }

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
            showCountySpinner();
            disableSearch();
            axios.get("{{route("counties-api")}}"+"/"+stateSelect.value)
                .then(function (response) {
                    hideCountySpinner();
                    enableSearch();
                    $("#countySelect").html(response.data.map(obj => "<option value='"+obj.county_id+"'>"+obj.countyName+"</option>").join("\n"));
                    $("#countySelect").change();
                })
                .catch(function (error) {
                    console.log(error);
                    alert("A error occurred! Please try refreshing the page.")
                })
        });
        $( "#countySelect" ).change(function() {
            showCitySpinner();
            disableSearch();
            axios.get("{{route("cities-api")}}"+"/"+countySelect.value)
                .then(function (response) {
                    hideCitySpinner();
                    enableSearch();
                    console.log(response.data);
                    console.log(response.data.length);
                    if(response.data.length != 0){
                        $("#citySelect").html(response.data.map(obj => "<option value='"+obj.city_id+"'>"+obj.cityName+"</option>").join("\n"));
                    } else {
                        $("#citySelect").html("<option value='' disabled selected>No cities found in county</option>");
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    alert("A error occurred! Please try refreshing the page.")
                })
        });
  </script>
@endpush

