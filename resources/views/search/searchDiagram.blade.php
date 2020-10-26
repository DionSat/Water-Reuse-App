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
        <div class="container">
            <div class="tree-navbar">
                    <script src="https://balkangraph.com/js/latest/OrgChart.js"></script>
                    <button class="btn btn-primary fas search-btn" value="2" title="Kitchen Sink"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="3" title="Kitchen Sink + Disposer"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="4" title="Dishwasher"><img src="/img/app_DISHWASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="5" title="Lavatory"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="6" title="Tub + Shower"><img src="/img/app_TUB-SHOWER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="7" title="Fire Suppression"><img src="/img/app_FIRE.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="8" title="Mechanical Cooling"><img src="/img/app_MECHANICAL.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="9" title="Clothes Washer"><img src="/img/app_CLOTHS WASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="10" title="Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="11" title="Composting Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="12" title="Urinal"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <div id="tree"></div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="legend-content">
                    <div>
                        <div style="background-color:#00cdcd;"></div>  First Use Water
                    </div>
                    <div>
                        <div style="background-color:#c6c6c6"></div>  Greywater
                    </div>
                    <div>
                        <div style="background-color:#666666;"></div>  Sewage
                    </div>
                    <div>
                        <div style="background-color:#69d500;"></div>  No Permit Required
                    </div>
                    <div>
                        <div style="background-color:#ff8c00;"></div>  Pathway Not Addressed
                    </div>
                    <div>
                        <div style="background-color:#ff0000;"></div>  Pathway Blocked
                    </div>
                </div>

                <div style="width:100%; height:700px;" id="orgchart"/>
                <script>
                    //Load all the icon images into an array
                    var icons = new Array();
                    icons[0] = new Image();
                    icons[0].src = "{{ asset('img/water sources_1.jpg') }}";
                    icons[1] = new Image();
                    icons[1].src = "{{ asset('img/water-source_condensate.jpg') }}";
                    icons[2] = new Image();
                    icons[2].src = "{{ asset('img/water-source_precipitation.jpg') }}";
                    icons[3] = new Image();
                    icons[3].src = "{{ asset('img/water-source_stormwater.jpg') }}";
                    icons[4] = new Image();
                    icons[4].src = "{{ asset('img/water-source_surface-water.jpg') }}";
                    icons[5] = new Image();
                    icons[5].src = "{{ asset('img/water-source_well-water.jpg') }}";
                    icons[6] = new Image();
                    icons[6].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[7] = new Image();
                    icons[7].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[8] = new Image();
                    icons[8].src = "{{ URL::asset('img/app_DISHWASHER.jpg') }}";
                    icons[9] = new Image();
                    icons[9].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
                    icons[10] = new Image();
                    icons[10].src = "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}";
                    icons[11] = new Image();
                    icons[11].src = "{{ URL::asset('img/app_FIRE.jpg') }}";
                    icons[12] = new Image();
                    icons[12].src = "{{ URL::asset('img/app_MECHANICAL.jpg') }}";
                    icons[13] = new Image();
                    icons[13].src = "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}";
                    icons[14] = new Image();
                    icons[14].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[15] = new Image();
                    icons[15].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[16] = new Image();
                    icons[16].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
                    var imageCount = icons.length;
                    var imagesLoaded = 0;

                    //Use a for loop to load all the images one by one till all them are loaded
                    //Then call the allLoaded function to execute your script
                    for(var i=0; i<imageCount; i++){
                        icons[i].onload = function(){
                            imagesLoaded++;
                            if(imagesLoaded == imageCount){
                                allLoaded(icons, imageCount);
                            }
                        }
                    }

                    //This function runs when all the images are loaded and passes in the icons array and the number of icons
                    function allLoaded(icons, imageCount){
                        var string_icons = new Array();
                        for(var i=0; i<imageCount; i++){
                            var canvas = document.createElement('canvas'),
                                ctx = canvas.getContext('2d');

                            canvas.height = icons[i].naturalHeight;
                            canvas.width = icons[i].naturalWidth;
                            ctx.drawImage(icons[i], 0, 0);

                            // Unfortunately, we cannot keep the original image type, so all images will be converted to PNG
                            // For this reason, we cannot get the original Base64 string
                            var uri = canvas.toDataURL('image/png'),
                                b64 = uri.replace(/^data:image.+;base64,/, '');
                            string_icons[i] = b64;
                        }

                        /* Zoom Toolbar Icons */
                        OrgChart.toolbarUI.fitIcon = '<i class="tb fas fa-expand fa-2x fa-fw" title="Auto Fit Diagram"></i>';
                        OrgChart.toolbarUI.zoomOutIcon = '<i class="tb fas fa-search-minus fa-2x fa-fw" title="Zoom Out"></i>';
                        OrgChart.toolbarUI.zoomInIcon = '<i class="tb fas fa-search-plus fa-2x fa-fw" title="Zoom In"></i>';

                        /* Link Animations */
                        OrgChart.templates.ana.link = '<path class="backgroundPath" stroke-linejoin="round" stroke="#00cdcd" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                            '<path class="dashPath" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

                        /* Chart */
                        let chart = new OrgChart(document.getElementById("orgchart"), {
                            template: "ana",
                            enableSearch: false,
                            align: OrgChart.ORIENTATION,
                            menu: {
                                pdf: {
                                    text: "Export PDF",
                                    icon: OrgChart.icon.pdf(24, 24, '#7A7A7A'),
                                    onClick: preview
                                },
                                png: {text: "Export PNG"},
                                svg: {text: "Export SVG"},
                                csv: {text: "Export CSV"}
                            },
                            nodeMenu: {
                                pdf: {text: "Export PDF"},
                                png: {text: "Export PNG"},
                                svg: {text: "Export SVG"},
                                csv: {text: "Export CSV"}
                            },
                            toolbar: {
                                zoom: true,
                                fit: true,
                            },
                            nodeBinding: {
                                field_0: "Name",
                                field_1: "Links",
                                img_0: "img"
                            },
                            collapse: {
                                level: 2,
                                allChildren: true
                            },
                            nodes: [
                                /* Water Sources Root */
                                {id: 0, Name: "Water Sources", img: "data:image/jpeg;base64," + string_icons[0]},
                                /* Level 2 Water Sources */
                                {id: 1, pid: 0, Name: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[1]},
                                {id: 2, pid: 0, Name: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[2]},
                                {id: 3, pid: 0, Name: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[3]},
                                {id: 4, pid: 0, Name: "Surface / Shallow Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[4]},
                                {id: 5, pid: 0, Name: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[5]},

                                /* Level 3 Child Nodes */
                                /* Condensate Child Nodes */
                                {id: 6, pid: 1, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 7, pid: 1, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},
                                {id: 8, pid: 1, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 9, pid: 1, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 10, pid: 1, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 11, pid: 1, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 12, pid: 1, Name: "Mechanical Cooling", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 13, pid: 1, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 14, pid: 1, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 15, pid: 1, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 16, pid: 1, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                                /* Precipitation Child Nodes */
                                {id: 17, pid: 2, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 18, pid: 2, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},
                                {id: 19, pid: 2, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 20, pid: 2, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 21, pid: 2, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 22, pid: 2, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 23, pid: 2, Name: "Mechanical Cooling", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 24, pid: 2, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 25, pid: 2, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 26, pid: 2, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 27, pid: 2, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                                /* Stormwater Runoff Child Nodes */
                                {id: 28, pid: 3, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 29, pid: 3, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},
                                {id: 30, pid: 3, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 31, pid: 3, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 32, pid: 3, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 33, pid: 3, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 34, pid: 3, Name: "Mechanical Cooling", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 35, pid: 3, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 36, pid: 3, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 37, pid: 3, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 38, pid: 3, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                                /* Surface / Shallow Ground Water Child Nodes */
                                {id: 39, pid: 4, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 40, pid: 4, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},
                                {id: 41, pid: 4, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 42, pid: 4, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 43, pid: 4, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 44, pid: 4, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 45, pid: 4, Name: "Mechanical Cooling", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 46, pid: 4, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 47, pid: 4, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 48, pid: 4, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 49, pid: 4, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                                /* Ground Water Child Nodes */
                                {id: 50, pid: 5, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 51, pid: 5, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},
                                {id: 52, pid: 5, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 53, pid: 5, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 54, pid: 5, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 54, pid: 5, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 55, pid: 5, Name: "Mechanical Cooling", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 56, pid: 5, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 57, pid: 5, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 58, pid: 5, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 59, pid: 5, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[16]}
                            ]
                        });

                        /* Node Details Button Links */
                        chart.editUI.on('field', function(sender, args){
                            if (args.type == 'details' && args.name == 'Links') {

                               var txt = args.field.querySelector('input');
                                if (txt) {
                                    var linkLabels = ["Code", "Permit", "Incentive", "More Info"];
                                    var parent = args.field.querySelector('div');
                                    var br = document.createElement("br");
                                    parent.appendChild(br);

                                    linkLabels.forEach((linkName) => {
                                        var a = document.createElement('a');
                                        var linkText = document.createTextNode(linkName);
                                        a.appendChild(linkText);
                                        a.className = "btn btn-primary";
                                        a.style.cssText = "margin: 15px 6px 0 6px;";
                                        a.title = linkName;
                                        a.href = "";
                                        a.target = "_blank";
                                        parent.appendChild(a);
                                    });

                                    txt.remove();
                                }
                            }
                        });

                        /* PDF Export Preview */
                        function preview(){

                            OrgChart.pdfPrevUI.show(chart, {
                                format: 'A4'
                            });
                        }

                        /* Link the buttons to the chart */
                        var elements = document.getElementsByClassName("search-btn");
                        for (var i = 0; i < elements.length; i++) {
                            elements[i].addEventListener("click", function () {
                                chart.center(this.value);
                            });
                        }
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
            overflow-y: auto;
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

        /* Pathway Not Addressed Paths Animation */
        /* Note that .backgroundPath must be kept in, however intelliJ will note it as unused but the class for the path animations is created on page load */
            /* Condensation (None) */
            /* Precipitation */
        [link-id='[2][23]'] .backgroundPath,
        [link-id='[2][24]'] .backgroundPath,
            /* Stormwater Runoff */
        [link-id='[3][33]'] .backgroundPath,
        [link-id='[3][35]'] .backgroundPath
            /* Surface / Shallow Ground Water (None) */
            /* Ground Water (None) */
        {
            stroke: #ff8c00;
        }

        /* Blocked Paths Animation */
        /* Note that .backgroundPath must be kept in, however intelliJ will note it as unused but the class for the path animations is created on page load */
            /* Condensation */
        [link-id='[1][6]'] .backgroundPath,
        [link-id='[1][7]'] .backgroundPath,
        [link-id='[1][8]'] .backgroundPath,
        [link-id='[1][9]'] .backgroundPath,
        [link-id='[1][10]'] .backgroundPath,
            /* Precipitation ( No Blocks ) */
            /* Stormwater Runoff */
        [link-id='[3][28]'] .backgroundPath,
        [link-id='[3][29]'] .backgroundPath,
        [link-id='[3][30]'] .backgroundPath,
        [link-id='[3][31]'] .backgroundPath,
        [link-id='[3][32]'] .backgroundPath
            /* Surface / Shallow Ground Water ( No Blocks ) */
            /* Ground Water ( No Blocks ) */
        {
            stroke: #ff0000;
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
