@extends("layouts.master")

@section('body')
    <div class="container">
        <a href="{{url()->previous()}}" class="btn btn-primary col-md-2 mb-4"> <i class="fas fa-arrow-circle-left"></i>
            Search Again
        </a>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="text-center"> Search Results </h3>
                <div class="text-center">To narrow down results to just the reuse paths that you are intrested in, you can use the filter options below.</div>
                <div class="mt-3 row d-flex justify-content-center">
                    <div class="form-group col-md-4 text-center">
                        <label for="sourceSelect"> <strong> Source </strong> </label>
                        <select id="sourceSelect" class="form-control">
                            <option value="all" selected>Any</option>
                            @foreach($sources as $source)
                                <option value="{{$source->node_id}}">{{$source->node_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="p-3">
                        <i class="fas fa-arrow-right font-35"></i>
                    </div>
                    <div class="form-group col-md-4 text-center">
                        <label for="destinationSelect"> <strong> Destination </strong> </label>
                        <select id="destinationSelect" class="form-control">
                            <option value="all" selected>Any</option>
                            @foreach($destinations as $destination)
                                <option value="{{$destination->node_id}}">{{$destination->node_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="list-group">
            @if($lowestLevel == "city")
                <div class="list-group-item">
                    <div id="cityHeader" class="d-flex justify-content-between align-items-center pointer" data-toggle="collapse" data-target="#cityCollapse">
                    <span class="font-25">
                        <i id="cityGroupIcon" class="fas fa-chevron-right fa-rotate-90 p-1"></i> {{$city->cityName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$cityRules->count()}} {{$cityRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="cityCollapse" class="collapsible collapse p-4 overflow-auto show" data-level="city">
                        @if($cityRules->count() == 0)
                            <h2 class="text-center">No reuse rules stored for {{$city->cityName}}!</h2>
                        @else
                            @include("search/searchResultTable", ["rules" => $cityRules])
                        @endif
                    </div>
                </div>
            @endif
            @if($lowestLevel == "county" || $lowestLevel == "city")
                <div class="list-group-item">
                    <div id="countyHeader" class="d-flex justify-content-between align-items-center pointer {{$lowestLevel == "county" ? "" : "collapsed"}}" data-toggle="collapse" data-target="#countyCollapse">
                    <span class="font-25">
                        <i id="countyGroupIcon" class="fas fa-chevron-right {{$lowestLevel == "county" ? "fa-rotate-90" : ""}} p-1"></i> {{$county->countyName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$countyRules->count()}} {{$countyRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="countyCollapse" class="collapsible collapse p-4 overflow-auto {{$lowestLevel == "county" ? "show" : ""}}" data-level="county">
                        @if($countyRules->count() == 0)
                            <h2 class="text-center">No reuse rules stored for {{$county->countyName}} county!</h2>
                        @else
                            @include("search/searchResultTable", ["rules" => $countyRules])
                        @endif
                    </div>
                </div>
            @endif
                <div class="list-group-item">
                    <div id="stateHeader" class="d-flex justify-content-between align-items-center pointer" data-toggle="collapse" data-target="#stateCollapse">
                    <span class="font-25">
                        <i id="stateGroupIcon" class="fas fa-chevron-right {{$lowestLevel == "state" ? "fa-rotate-90" : ""}} p-1"></i> {{$state->stateName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$stateRules->count()}} {{$stateRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="stateCollapse" class="collapsible collapse p-4 overflow-auto {{$lowestLevel == "state" ? "show" : ""}}" data-level="state">
                        @if($stateRules->count() == 0)
                            <h2 class="text-center">No reuse rules stored for {{$state->stateName}}!</h2>
                        @else
                            @include("search/searchResultTable", ["rules" => $stateRules])
                        @endif
                    </div>
                </div>
        </div>
  
    </div>
@endsection

@push("css")

    <style>

        .font-25{
            font-size: 25px;
        }

        .font-35{
            font-size: 35px;
        }

        .fa-chevron-right {
            transition: 0.3s;
        }

        .pointer{
            cursor: pointer;
        }

    </style>
@endpush


@push("js")
<script>

    $('.collapsible').on('hide.bs.collapse', function () {
        $("#"+$(this).attr("data-level")+"Header").find("i").removeClass("fa-rotate-90");
    });

    $('.collapsible').on('show.bs.collapse', function () {
        $("#"+$(this).attr("data-level")+"Header").find("i").addClass("fa-rotate-90");
    });

    var sourceSelect = $("#sourceSelect");
    var destinationSelect = $("#destinationSelect");
    var cityCollapse = $("#cityCollapse");
    var countyCollapse = $("#countyCollapse");
    var stateCollapse = $("#stateCollapse");

    sourceSelect.change(filterResults);
    destinationSelect.change(filterResults);

    function filterResults() {
        let source = sourceSelect.val();
        let destination = destinationSelect.val();

        if(source === "all")
            $(".reuse-row[data-source][data-destination='"+destination+"']").show();
        else
            $(".reuse-row[data-source!='"+source+"']").hide();

        if(destination === "all")
            $(".reuse-row[data-destination][data-source='"+source+"']").show();
        else
            $(".reuse-row[data-destination!='"+destination+"']").hide();

        if(source === "all" && destination === "all")
            $(".reuse-row").show();

        showHiddenMessage();
    }

    function showHiddenMessage(){
        let numberOfCityRows = cityCollapse.find("tr:visible").not(".hidden-rows-row").not(".table-head").length;
        let cityMessageRowDisplayed = cityCollapse.find(".hidden-rows-row").length === 1;

        let numberOfCountyRows = countyCollapse.find("tr:visible").not(".hidden-rows-row").not(".table-head").length;
        let countyMessageRowDisplayed = countyCollapse.find(".hidden-rows-row").length === 1;

        let numberOfStateRows = stateCollapse.find("tr:visible").not(".hidden-rows-row").not(".table-head").length;
        let stateMessageRowDisplayed = stateCollapse.find(".hidden-rows-row").length === 1;

        var rowsHiddenMessage = "<tr class='hidden-rows-row'><td colspan='12'> <h1> <span class='badge badge-secondary'> Rows hidden by filter </span></td></tr>";

        if(numberOfCityRows === 0 && !cityMessageRowDisplayed){
            cityCollapse.find("tbody").append(rowsHiddenMessage)
        } else if(numberOfCityRows > 0) {
            cityCollapse.find(".hidden-rows-row").remove();
        }

        if(numberOfCountyRows === 0 && !countyMessageRowDisplayed){
            countyCollapse.find("tbody").append(rowsHiddenMessage)
        } else if(numberOfCountyRows > 0) {
            countyCollapse.find(".hidden-rows-row").remove();
        }

        if(numberOfStateRows === 0 && !stateMessageRowDisplayed){
            stateCollapse.find("tbody").append(rowsHiddenMessage)
        } else if(numberOfStateRows > 0) {
            stateCollapse.find(".hidden-rows-row").remove();
        }
    }

</script>


@endpush