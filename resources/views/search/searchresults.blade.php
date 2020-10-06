@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="navbar">
            <a href="{{route("search")}}" class="btn btn-primary col-md-2 mb-4 float-left"> <i class="fas fa-arrow-circle-left"></i>
                Search Again
            </a>
            <a href="" class="btn btn-primary col-md-2 mb-4 float-right"> <i class="fas fa-sitemap"></i>
                View Diagram
            </a>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="text-center"> {{$type}} Search Results </h3>
                <div class="text-center">To narrow down results to just the reuse paths that you are interested in, you can use the filter options below.</div>
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
                        <i id="cityGroupIcon" class="fas fa-chevron-right p-1"></i> {{$city->cityName}}
                    </span>

                        <h3><span class="badge badge-primary"> <span id="cityReuseCount">{{$cityRules->count()}}</span> {{$cityRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="cityCollapse" class="collapsible collapse p-4 overflow-auto" data-level="city">
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
                        <i id="countyGroupIcon" class="fas fa-chevron-right p-1"></i> {{$county->countyName}}
                    </span>

                        <h3><span class="badge badge-primary"> <span id="countyReuseCount">{{$countyRules->count()}}</span> {{$countyRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="countyCollapse" class="collapsible collapse p-4 overflow-auto" data-level="county">
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
                        <i id="stateGroupIcon" class="fas fa-chevron-right p-1"></i> {{$state->stateName}}
                    </span>

                        <h3><span class="badge badge-primary"> <span id="stateReuseCount">{{$stateRules->count()}}</span> {{$stateRules->count() == 1 ? "Reuse Rule" : "Reuse Rules"}}</span> </h3>
                    </div>
                    <div id="stateCollapse" class="collapsible collapse p-4 overflow-auto" data-level="state">
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
<script src="{{ URL::asset('/libraries/axios.min.js') }}"></script>

<script>
    // Fire off a event as the user navigates away to check the link
    // The link is only checked if it hasn't been updated in last 14 days
    $(".link-button").click(function (event) {
        axios.post("{{route("check-link-api")}}", {
            link_id: $(this).attr("data-linkid")
        })
        .then(function (response) {
            console.log(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });
    });


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

        if(source === "all"){
            $(".reuse-row[data-source][data-destination='"+destination+"']").show();
            $(".reuse-row[data-source][data-destination='"+destination+"']").removeClass("hidden-item");
        }
        else{
            $(".reuse-row[data-source!='"+source+"']").hide();
            $(".reuse-row[data-source!='"+source+"']").addClass("hidden-item");
        }

        if(destination === "all"){
            $(".reuse-row[data-destination][data-source='"+source+"']").show();
            $(".reuse-row[data-destination][data-source='"+source+"']").removeClass("hidden-item");
        }
        else{
            $(".reuse-row[data-destination!='"+destination+"']").hide();
            $(".reuse-row[data-destination!='"+destination+"']").addClass("hidden-item");
        }

        if(source === "all" && destination === "all"){
            $(".reuse-row").show();
            $(".reuse-row").removeClass("hidden-item");
        }

        showHiddenMessage();
    }

    function showHiddenMessage(){
        let numberOfCityRows = cityCollapse.find("tr.reuse-row").not(".hidden-item").length;
        let cityMessageRowDisplayed = cityCollapse.find(".hidden-rows-row").length === 1;

        let numberOfCountyRows = countyCollapse.find("tr.reuse-row").not(".hidden-item").length;
        let countyMessageRowDisplayed = countyCollapse.find(".hidden-rows-row").length === 1;

        let numberOfStateRows = stateCollapse.find("tr.reuse-row").not(".hidden-item").length;
        let stateMessageRowDisplayed = stateCollapse.find(".hidden-rows-row").length === 1;

        //Update the section labels
        $("#cityReuseCount").html(numberOfCityRows);
        $("#countyReuseCount").html(numberOfCountyRows);
        $("#stateReuseCount").html(numberOfStateRows);

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
