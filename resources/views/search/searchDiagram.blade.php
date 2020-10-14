@extends('layouts.master')

@section('body')
    <script src="{{ URL::asset('/libraries/orgchart.js') }}"></script>
    <div class="container">
        <div class="navbar">
            <a href="{{route("search")}}" class="btn btn-primary col-md-2 mb-4 float-left"> <i class="fas fa-arrow-circle-left"></i>
                Search Again
            </a>
            <a href="{{route("search-submit")}}?state_id=1&county_id=1&city_id=1&searchType=residential" class="btn btn-primary col-md-2 mb-4 float-right">
                <i class="fas fa-clipboard-list"></i> List Option
            </a>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div style="width:100%; height:700px;" id="orgchart"/>
                <script>

                    var chart = new OrgChart(document.getElementById("orgchart"), {
                        //template: "myTemplate",
                        template: "ana",
                        enableSearch: false,
                        menu: {
                            pdf: {
                                text: "Export PDF",
                                onClick: preview
                            },
                            png: { text: "Export PNG" },
                            svg: { text: "Export SVG" },
                            csv: { text: "Export CSV" }
                        },
                        nodeMenu:{
                            pdf: { text: "Export PDF" },
                            png: { text: "Export PNG" },
                            svg: { text: "Export SVG" }
                        },
                        nodeBinding: {
                            field_0: "Name",
                            img_0: "img"
                        },
                        nodes: [
                            {id: 1, Name: "Condensate", img: "{{ URL::asset('img/water sources_1.jpg') }}"},
                            {id: 2, pid: 1, Name: "Kitchen Sink", img: "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}"},
                            {id: 3, pid: 1, Name: "Kitchen Sink + Disposer", img: "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}"},
                            {id: 4, pid: 1, Name: "Dishwasher", img: "{{ URL::asset('img/app_DISHWASHER.jpg') }}"},
                            {id: 5, pid: 1, Name: "Lavatory", img: "{{ URL::asset('img/app_LAVATORY.jpg') }}"},
                            {id: 6, pid: 1, Name: "Tub + Shower", img: "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}"},
                            {id: 7, pid: 1, Name: "Fire Suppression", img: "{{ URL::asset('img/app_FIRE.jpg') }}"},
                            {id: 8, pid: 1, Name: "Clothes Washer", img: "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}"},
                            {id: 9, pid: 1, Name: "Toilet", img: "{{ URL::asset('img/toilet.png') }}"},
                            {id: 10, pid: 1, Name: "Composting Toilet", img: "{{ URL::asset('img/toilet.png') }}"},
                            {id: 11, pid: 1, Name: "Urinal", img: "{{ URL::asset('img/app_LAVATORY.jpg') }}"}
                        ]
                    });

                    function preview(){
                        OrgChart.pdfPrevUI.show(chart, {
                            format: 'A4'
                        });
                    }

                </script>
            </div>
        </div>

    </div>
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
            overflow-y: scroll;
        }

        [node-id] circle {
            fill: #0991d0;
        }

        [link-id] path {
            stroke: #0991d0;
        }

        [link-id='[1][2]'] path {
            stroke: #750000;
        }

        [link-id='[1][3]'] path {
            stroke: #750000;
        }

        [link-id='[1][4]'] path {
            stroke: #750000;
        }

        [link-id='[1][5]'] path {
            stroke: #750000;
        }

        [link-id='[1][6]'] path {
            stroke: #750000;
        }

        [control-expcoll-id] circle {
            fill: #750000;
        }

        [control-expcoll-id='3'] circle {
            fill: #016e25;
        }

        [control-node-menu-id] circle {
            fill: #bfbfbf;
        }

        #tree>svg {
            background-color: #2E2E2E;
        }

        .bg-search-table input {
            background-color: #2E2E2E !important;
        }
    </style>
@endpush
