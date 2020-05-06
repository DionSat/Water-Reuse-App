@extends("layouts.master")

@section('body')
    <div class="container">
        <a href="{{url()->previous()}}" class="btn btn-primary col-md-2 mb-4"> <i class="fas fa-arrow-circle-left"></i>
            Search Again
        </a>

        <div class="list-group">
            @if($lowestLevel == "city")
                <div class="list-group-item">
                    <div id="cityHeader" class="d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#cityCollapse">
                    <span class="font-25">
                        <i id="cityGroupIcon" class="fas fa-chevron-right fa-rotate-90 p-1"></i> {{$city->cityName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$cityRules->count()}} Reuse Rules</span> </h3>
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
                    <div id="countyHeader" class="d-flex justify-content-between align-items-center {{$lowestLevel == "county" ? "" : "collapsed"}}" data-toggle="collapse" data-target="#countyCollapse">
                    <span class="font-25">
                        <i id="countyGroupIcon" class="fas fa-chevron-right {{$lowestLevel == "county" ? "fa-rotate-90" : ""}} p-1"></i> {{$county->countyName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$countyRules->count()}} Reuse Rules</span> </h3>
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
                    <div id="stateHeader" class="d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#stateCollapse">
                    <span class="font-25">
                        <i id="stateGroupIcon" class="fas fa-chevron-right {{$lowestLevel == "state" ? "fa-rotate-90" : ""}} p-1"></i> {{$state->stateName}}
                    </span>

                        <h3><span class="badge badge-primary">{{$stateRules->count()}} Reuse Rules</span> </h3>
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

        .fa-chevron-right {
            transition: 0.3s;
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
    })


</script>


@endpush