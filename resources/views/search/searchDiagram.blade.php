@extends('layouts.master')

@section('body')
    <script src="{{ URL::asset('/libraries/orgchart.js') }}"></script>
    <div class="container">
      <div class="row justify-content-center mb-4">
        <h1 class="font-weight-bold text-light">Water Reuse Map</h1>
      </div>
        <div class="navbar">
            <a href="{{route("search")}}" class="btn btn-primary col-md-2 mb-4 float-left"> <i class="fas fa-arrow-circle-left"></i>
                Search Again
            </a>
            <a class="btn btn-warning col-md-2 float-center mb-4" target="_blank" href="{{route("info")}}">
                Tutorial
            </a>
            <a href="{{route("search-submit")}}?state_id={{$request->state_id}}&county_id={{$request->county_id}}&city_id={{$request->city_id}}&searchType={{$request->searchType}}" class="btn btn-primary col-md-2 mb-4 float-right">
                <i class="fas fa-clipboard-list"></i> List Option
            </a>
        </div>
        <div class="container"  style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
            <div class="tree-navbar">
                    <script src="https://balkangraph.com/js/latest/OrgChart.js"></script>
                    <button class="btn btn-primary fas search-btn" value="Kitchen Sink" title="Kitchen Sink"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Food Disposer" title="Food Disposer"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Dishwasher" title="Dishwasher"><img src="/img/app_DISHWASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Lavatory" title="Lavatory"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Tub & Shower" title="Tub & Shower"><img src="/img/app_TUB-SHOWER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Fire Suppression" title="Fire Suppression"><img src="/img/app_FIRE.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Mechanical Cooling / P-Trap Prime" title="Mechanical Cooling / P-Trap Prime"><img src="/img/app_MECHANICAL.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Clothes Washer" title="Clothes Washer"><img src="/img/app_CLOTHS WASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet" title="Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet (Composting)" title="Toilet (Composting)"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet (Source Separated)" title="Toilet (Source Separated)"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Urinal" title="Urinal"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Urinal (Waterless / Diverted)" title="Urinal (Waterless / Diverted)"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
            </div>
        </div>
        @include("search/searchResultDiagram")

@endsection

@push("css")
    <style>
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            text-align: center;
            font-family: Helvetica;
            overflow-y: auto;
        }
        #tree {
            width: 100%;
            height: 100%;
            position: relative;
        }
       /*color*/
        .node.available rect{
            stroke: #00cdcd;
        }
        .node.not_avail rect{
            stroke: #808080;
        }

        /* Zoom Icons CSS */
        i.tb {
            border: 2px solid #6c757d;
            line-height: inherit;
        }

        /* Legend Key Outer Container */
        .legend-content{
            position: absolute;
            bottom: 0;
            left: 0;
            margin: 0 0 50px 20px;
        }

        /* Legend Key Inner Container */
        .legend-content > div > div {
            display: inline-block;
            width: 30px;
            height:8px;
            margin-bottom: 2px;
        }

        /* Water Use Paths Animation */
        .dashPath {
            animation: dash 5s linear infinite;
        }

        /* Link Animation ~ Dash Type */
        @keyframes dash {
            from {
                stroke-dashoffset: 100;
                opacity: 1;
            }
            to {
                stroke-dashoffset: 0;
                opacity: 1;
            }
        }

        [control-node-menu-id] circle {
            fill: #bfbfbf;
        }

        #tree>svg {
            background-color: #2E2E2E;
        }

        .bg-search-table {
            background-color: #2E2E2E !important;
        }

        .bg-search-table input {
            background-color: #2E2E2E !important;
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
    </script>


@endpush
