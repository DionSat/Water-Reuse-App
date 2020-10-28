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
                    <button class="btn btn-primary fas search-btn" value="8" title="Clothes Washer"><img src="/img/app_CLOTHS WASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="9" title="Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="10" title="Composting Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="11" title="Urinal"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
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
                    icons[1].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[2] = new Image();
                    icons[2].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[3] = new Image();
                    icons[3].src = "{{ URL::asset('img/app_DISHWASHER.jpg') }}";
                    icons[4] = new Image();
                    icons[4].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
                    icons[5] = new Image();
                    icons[5].src = "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}";
                    icons[6] = new Image();
                    icons[6].src = "{{ URL::asset('img/app_FIRE.jpg') }}";
                    icons[7] = new Image();
                    icons[7].src = "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}";
                    icons[8] = new Image();
                    icons[8].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[9] = new Image();
                    icons[9].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[10] = new Image();
                    icons[10].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
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
                        OrgChart.toolbarUI.expandAllIcon = '<i  class="tb fas fa-layer-group fa-2x fa-fw" title="Expand Diagram"></i>';
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
                                expandAll: true
                            },
                            nodeBinding: {
                                field_0: "Name",
                                field_1: "Links",
                                img_0: "img"
                            },
                            nodes: [
                                {id: 1, Name: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[0]},
                                {id: 2, pid: 1, Name: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[1]                              },
                                {id: 3, pid: 1, Name: "Kitchen Sink + Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[2]},
                                {id: 4, pid: 1, Name: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[3]},
                                {id: 5, pid: 1, Name: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[4]},
                                {id: 6, pid: 1, Name: "Tub + Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[5]},
                                {id: 7, pid: 1, Name: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 8, pid: 1, Name: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[7]                                },
                                {id: 9, pid: 1, Name: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 10, pid: 1, Name: "Composting Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 11, pid: 1, Name: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[10]}
                            ]
                        });


                        /* Node Details Button Links */
                        chart.editUI.on('field', function(sender, args){
                            if (args.type == 'details' && args.name == 'Links'){

                                var txt = args.field.querySelector('input');
                                if (txt){
                                   
                                    var parent = args.field.querySelector('div');
                                    var br = document.createElement("br");
                                    parent.appendChild(br);

                                    var a = document.createElement('a');
                                    var linkText = document.createTextNode("Code")
                                    a.appendChild(linkText);
                                    a.className = "btn btn-primary";
                                    a.style.cssText = "margin: 15px 6px 0 6px;";
                                    a.title = "Code";
                                    if (<?php echo $cityRules->count()?> == 0){
                                        a.href = "";
                                    }
                                    else
                                    {
                                        a.href = "<?php echo $cityRules[0]->codesObj->linkText ?>";
                                    }
                                    a.target = "_blank";
                                    parent.appendChild(a);

                                    var a = document.createElement('a');
                                    var linkText = document.createTextNode("Permit")
                                    a.appendChild(linkText);
                                    a.className = "btn btn-primary";
                                    a.style.cssText = "margin: 15px 6px 0 6px;";
                                    a.title = "Permit";
                                   if (<?php echo $cityRules->count()?> == 0){
                                        a.href = "";
                                    }
                                    else
                                    {
                                        a.href = "<?php echo $cityRules[0]->permitObj->linkText ?>";
                                    }
                                    a.target = "_blank";
                                    parent.appendChild(a);

                                    var a = document.createElement('a');
                                    var linkText = document.createTextNode("Incentive")
                                    a.appendChild(linkText);
                                    a.className = "btn btn-primary";
                                    a.style.cssText = "margin: 15px 6px 0 6px;";
                                    a.title = "Incentive";
                                    if (<?php echo $cityRules->count()?> == 0){
                                        a.href = "";
                                    }
                                    else
                                    {
                                        a.href = "<?php echo $cityRules[0]->incentivesObj->linkText ?>";
                                    }
                                    a.target = "_blank";
                                    parent.appendChild(a);

                                    parent.appendChild(a);
                                    var a = document.createElement('a');
                                    var linkText = document.createTextNode("More Info")
                                    a.appendChild(linkText);
                                    a.className = "btn btn-primary";
                                    a.style.cssText = "margin: 15px 6px 0 6px;";
                                    a.title = "More Info";
                                   if (<?php echo $cityRules->count()?> == 0){
                                        a.href = "";
                                    }
                                    else
                                    {
                                        a.href = "<?php echo $cityRules[0]->moreInfoObj->linkText ?>";
                                    }
                                    a.target = "_blank";
                                    parent.appendChild(a);

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

        /* Blocked Paths Animation */
        [link-id='[1][2]'] .backgroundPath,
        [link-id='[1][3]'] .backgroundPath,
        [link-id='[1][4]'] .backgroundPath,
        [link-id='[1][5]'] .backgroundPath,
        [link-id='[1][6]'] .backgroundPath {
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
