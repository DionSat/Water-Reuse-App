@extends('layouts.master')

@section('body')
    <script src="{{ URL::asset('/libraries/orgchart.js') }}"></script>
    <div class="container">
        <div class="navbar">
            <a href="{{route("search")}}" class="btn btn-primary col-md-2 mb-4 float-left"> <i class="fas fa-arrow-circle-left"></i>
                Search Again
            </a>
            <a href="{{route("search-submit")}}?state_id={{$request->state_id}}&county_id={{$request->county_id}}&city_id={{$request->city_id}}&searchType={{$request->searchType}}" class="btn btn-primary col-md-2 mb-4 float-right">
                <i class="fas fa-clipboard-list"></i> List Option
            </a>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div style="width:100%; height:700px;" id="orgchart"/>
                <script>
                    OrgChart.templates.myTemplate = Object.assign({}, OrgChart.templates.ana);
                    OrgChart.templates.myTemplate.size = [200, 200];
                    OrgChart.templates.myTemplate.node = '<circle cx="100" cy="100" r="100" fill="#4D4D4D" stroke-width="1" stroke="#1C1C1C"></circle>';

                    OrgChart.templates.myTemplate.ripple = {
                        radius: 100,
                        color: "#0890D3",
                        rect: null
                    };

                    OrgChart.templates.myTemplate.link =
                        '<path stroke="#aeaeae" stroke-width="3px" fill="none" link-id="[{id}][{child-id}]" d="M{xa},{ya} C{xb},{yb} {xc},{yc} {xd},{yd}" />';

                    OrgChart.templates.myTemplate.field_0 = '<text style="font-size: 18px;" fill="#ffffff" x="100" y="90" text-anchor="middle">{val}</text>';
                    OrgChart.templates.myTemplate.field_1 = '<text style="font-size: 12px;" fill="#ffffff" x="100" y="60" text-anchor="middle">{val}</text>';

                    OrgChart.templates.myTemplate.img_0 = '<clipPath id="ulaImg"><circle cx="100" cy="150" r="40"></circle></clipPath><image preserveAspectRatio="xMidYMid slice" clip-path="url(#ulaImg)" xlink:href="{val}" x="60" y="110"  width="80" height="80"></image>';

                    OrgChart.templates.myTemplate.edge = '<path  stroke="#686868" stroke-width="1px" fill="none" edge-id="[{id}][{child-id}]" d="M{xa},{ya} C{xb},{yb} {xc},{yc} {xd},{yd}"/>';

                    OrgChart.templates.myTemplate.plus =
                        '<rect x="0" y="0" width="36" height="36" rx="12" ry="12" fill="#2E2E2E" stroke="#aeaeae" stroke-width="1"></rect>'
                        + '<line x1="4" y1="18" x2="32" y2="18" stroke-width="1" stroke="#aeaeae"></line>'
                        + '<line x1="18" y1="4" x2="18" y2="32" stroke-width="1" stroke="#aeaeae"></line>';

                    OrgChart.templates.myTemplate.minus =
                        '<rect x="0" y="0" width="36" height="36" rx="12" ry="12" fill="#2E2E2E" stroke="#aeaeae" stroke-width="1"></rect>'
                        + '<line x1="4" y1="18" x2="32" y2="18" stroke-width="1" stroke="#aeaeae"></line>';

                    OrgChart.templates.myTemplate.expandCollapseSize = 36;

                    OrgChart.templates.myTemplate.nodeMenuButton = '<g style="cursor:pointer;" transform="matrix(1,0,0,1,93,15)" control-node-menu-id="{id}"><rect x="-4" y="-10" fill="#000000" fill-opacity="0" width="22" height="22"></rect><line x1="0" y1="0" x2="0" y2="10" stroke-width="2" stroke="#0890D3" /><line x1="7" y1="0" x2="7" y2="10" stroke-width="2" stroke="#0890D3" /><line x1="14" y1="0" x2="14" y2="10" stroke-width="2" stroke="#0890D3" /></g>';

                    OrgChart.templates.myTemplate.exportMenuButton = '<div style="position:absolute;right:{p}px;top:{p}px; width:40px;height:50px;cursor:pointer;" control-export-menu=""><hr style="background-color: #0890D3; height: 3px; border: none;"><hr style="background-color: #0890D3; height: 3px; border: none;"><hr style="background-color: #0890D3; height: 3px; border: none;"></div>';

                    OrgChart.templates.myTemplate.pointer = '<g data-pointer="pointer" transform="matrix(0,0,0,0,100,100)"><g transform="matrix(0.3,0,0,0.3,-17,-17)"><polygon fill="#0890D3" points="53.004,173.004 53.004,66.996 0,120"/><polygon fill="#0890D3" points="186.996,66.996 186.996,173.004 240,120"/><polygon fill="#0890D3" points="66.996,53.004 173.004,53.004 120,0"/><polygon fill="#0890D3" points="120,240 173.004,186.996 66.996,186.996"/><circle fill="#0890D3" cx="120" cy="120" r="30"/></g></g>';

                    var chart = new OrgChart(document.getElementById("orgchart"), {
                        template: "myTemplate",
                        enableSearch: false,
                        nodeMenu:{
                            add:{text: "Add"},
                            edit:{text: "Edit"},
                            remove:{text: "Remove"}
                        },
                        nodeMenu:{
                            svg:{text: "Add"},
                            csv:{text: "Edit"},
                            remove:{text: "Remove"}
                        },
                        nodeBinding: {
                            field_0: "name",
                            field_1: "title",
                            img_0: "img"
                        },
                        nodes: [
                            {id: 1, name: "Condensate", img: "{{ URL::asset('img/water sources_1.jpg') }}"},
                            {id: 2, pid: 1, name: "Kitchen Sink", img: "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}"},
                            {id: 3, pid: 1, name: "Kitchen Sink + Disposer", img: "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}"},
                            {id: 4, pid: 1, name: "Dishwasher", img: "{{ URL::asset('img/app_DISHWASHER.jpg') }}"},
                            {id: 5, pid: 1, name: "Lavatory", img: "{{ URL::asset('img/app_LAVATORY.jpg') }}"},
                            {id: 6, pid: 1, name: "Tub + Shower", img: "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}"},
                            {id: 7, pid: 1, name: "Fire Suppression", img: "{{ URL::asset('img/app_FIRE.jpg') }}"},
                            {id: 8, pid: 1, name: "Clothes Washer", img: "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}"},
                            {id: 9, pid: 1, name: "Toilet", img: "{{ URL::asset('img/toilet.png') }}"},
                            {id: 10, pid: 1, name: "Composting Toilet", img: "{{ URL::asset('img/toilet.png') }}"},
                            {id: 11, pid: 1, name: "Urinal", img: "{{ URL::asset('img/app_LAVATORY.jpg') }}"}
                        ]
                    });
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
        }

        #tree {
            width: 100%;
            height: 100%;
            position: relative;
        }


        [node-id] circle {
            fill: #0991d0;
        }

        .field_0 {
            font-family: Impact;
            text-transform: uppercase;
            fill: #a3a3a3;
        }

        .field_1 {
            fill: #a3a3a3;
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

        .bg-search-table {
            background-color: #2E2E2E !important;
        }

        .bg-search-table input {
            background-color: #2E2E2E !important;
        }
    </style>
@endpush
