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
                    <button class="btn btn-primary fas search-btn" value="Kitchen Sink" title="Kitchen Sink"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Kitchen Sink + Disposer" title="Kitchen Sink + Disposer"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Dishwasher" title="Dishwasher"><img src="/img/app_DISHWASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Lavatory" title="Lavatory"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Tub + Shower" title="Tub + Shower"><img src="/img/app_TUB-SHOWER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Fire Suppression" title="Fire Suppression"><img src="/img/app_FIRE.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Mechanical Cooling" title="Mechanical Cooling"><img src="/img/app_MECHANICAL.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Clothes Washer" title="Clothes Washer"><img src="/img/app_CLOTHS WASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet" title="Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Composting Toilet" title="Composting Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Urinal" title="Urinal"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
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
                    icons[5].src = "{{ asset('img/water-sources_shallow-groundwater.jpg') }}";
                    icons[6] = new Image();
                    icons[6].src = "{{ asset('img/water-source_well-water.jpg') }}";
                    icons[7] = new Image();
                    icons[7].src = "{{ asset('img/water-supplier.jpg') }}";
                    icons[8] = new Image();
                    icons[8].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[9] = new Image();
                    icons[9].src = "{{ URL::asset('img/app_KITCHEN SINK.jpg') }}";
                    icons[10] = new Image();
                    icons[10].src = "{{ URL::asset('img/app_DISHWASHER.jpg') }}";
                    icons[11] = new Image();
                    icons[11].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
                    icons[12] = new Image();
                    icons[12].src = "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}";
                    icons[13] = new Image();
                    icons[13].src = "{{ URL::asset('img/app_FIRE.jpg') }}";
                    icons[14] = new Image();
                    icons[14].src = "{{ URL::asset('img/app_MECHANICAL.jpg') }}";
                    icons[15] = new Image();
                    icons[15].src = "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}";
                    icons[16] = new Image();
                    icons[16].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[17] = new Image();
                    icons[17].src = "{{ URL::asset('img/toilet.png') }}";
                    icons[18] = new Image();
                    icons[18].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
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
                            enableSearch: true,
                            searchFields: ["Name", "ParentName", "img"],
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
                                img_0: "img",
                                alt_0: "ParentName"
                            },
                            collapse: {
                                level: 2,
                                allChildren: true
                            },
                            nodes: [
                                /* Water Sources Root */
                                {id: 0, Name: "Water Sources", img: "data:image/jpeg;base64," + string_icons[0]},
                                /* Level 2 Water Sources */
                                {id: 1, pid: 0, Name: "Condensate", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[1]},
                                {id: 2, pid: 0, Name: "Precipitation", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[2]},
                                {id: 3, pid: 0, Name: "Stormwater Runoff", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[3]},
                                {id: 4, pid: 0, Name: "Surface Water", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[4]},
                                {id: 5, pid: 0, Name: "Shallow Groundwater", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[5]},
                                {id: 6, pid: 0, Name: "Ground Water", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                                {id: 7, pid: 0, Name: "Water Facility/ Purveyor", ParentName: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},

                                /* Level 3 Child Nodes */
                                /* Condensate Child Nodes */
                                {id: 8, pid: 1, Name: "Kitchen Sink", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 9, pid: 1, Name: "Kitchen Sink + Disposer", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 10, pid: 1, Name: "Dishwasher", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 11, pid: 1, Name: "Lavatory", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 12, pid: 1, Name: "Tub + Shower", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 13, pid: 1, Name: "Fire Suppression", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 14, pid: 1, Name: "Mechanical Cooling", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 15, pid: 1, Name: "Clothes Washer", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 16, pid: 1, Name: "Toilet", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 17, pid: 1, Name: "Composting Toilet", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 18, pid: 1, Name: "Urinal", ParentName: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},

                                /* Precipitation Child Nodes */
                                {id: 19, pid: 2, Name: "Kitchen Sink", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 20, pid: 2, Name: "Kitchen Sink + Disposer", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 21, pid: 2, Name: "Dishwasher", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 22, pid: 2, Name: "Lavatory", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 23, pid: 2, Name: "Tub + Shower", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 24, pid: 2, Name: "Fire Suppression", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 25, pid: 2, Name: "Mechanical Cooling", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 26, pid: 2, Name: "Clothes Washer", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 27, pid: 2, Name: "Toilet", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 28, pid: 2, Name: "Composting Toilet", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 29, pid: 2, Name: "Urinal", ParentName: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},

                                /* Stormwater Runoff Child Nodes */
                                {id: 30, pid: 3, Name: "Kitchen Sink", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 31, pid: 3, Name: "Kitchen Sink + Disposer", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 32, pid: 3, Name: "Dishwasher", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 33, pid: 3, Name: "Lavatory", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 34, pid: 3, Name: "Tub + Shower", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 35, pid: 3, Name: "Fire Suppression", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 36, pid: 3, Name: "Mechanical Cooling", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 37, pid: 3, Name: "Clothes Washer", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 38, pid: 3, Name: "Toilet", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 39, pid: 3, Name: "Composting Toilet", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 40, pid: 3, Name: "Urinal", ParentName: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},

                                /* Surface Water Child Nodes */
                                {id: 41, pid: 4, Name: "Kitchen Sink", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 42, pid: 4, Name: "Kitchen Sink + Disposer", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 43, pid: 4, Name: "Dishwasher", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 44, pid: 4, Name: "Lavatory", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 45, pid: 4, Name: "Tub + Shower", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 46, pid: 4, Name: "Fire Suppression", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 47, pid: 4, Name: "Mechanical Cooling", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 48, pid: 4, Name: "Clothes Washer", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 49, pid: 4, Name: "Toilet", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 50, pid: 4, Name: "Composting Toilet", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 51, pid: 4, Name: "Urinal", ParentName: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},

                                /* Shallow Groundwater Child Nodes */
                                {id: 52, pid: 5, Name: "Kitchen Sink", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 53, pid: 5, Name: "Kitchen Sink + Disposer", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 54, pid: 5, Name: "Dishwasher", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 55, pid: 5, Name: "Lavatory", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 56, pid: 5, Name: "Tub + Shower", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 57, pid: 5, Name: "Fire Suppression", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 58, pid: 5, Name: "Mechanical Cooling", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 59, pid: 5, Name: "Clothes Washer", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 60, pid: 5, Name: "Toilet", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 61, pid: 5, Name: "Composting Toilet", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 62, pid: 5, Name: "Urinal", ParentName: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},

                                /* Ground Water Child Nodes */
                                {id: 63, pid: 6, Name: "Kitchen Sink", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                                {id: 64, pid: 6, Name: "Kitchen Sink + Disposer", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                                {id: 65, pid: 6, Name: "Dishwasher", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                                {id: 66, pid: 6, Name: "Lavatory", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                                {id: 67, pid: 6, Name: "Tub + Shower", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                                {id: 68, pid: 6, Name: "Fire Suppression", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                                {id: 69, pid: 6, Name: "Mechanical Cooling", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                                {id: 70, pid: 6, Name: "Clothes Washer", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                                {id: 71, pid: 6, Name: "Toilet", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                                {id: 72, pid: 6, Name: "Composting Toilet", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                                {id: 73, pid: 6, Name: "Urinal", ParentName: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[18]}

                                /* Water Facility Child Nodes ( None ) */
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
                        for (let i = 0; i < elements.length; i++) {
                            elements[i].addEventListener("click", function () {
                                let searchname = this.value;
                                let result = chart.find(searchname);

                                if (result.length > 1) {
                                    chart.searchUI.find(searchname);
                                }
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
        [link-id='[2][25]'] .backgroundPath,
        [link-id='[2][26]'] .backgroundPath,
            /* Stormwater Runoff */
        [link-id='[3][35]'] .backgroundPath,
        [link-id='[3][37]'] .backgroundPath
            /* Surface Water (None) */
            /* Shallow Ground Water (None) */
            /* Ground Water (None) */
            /* Water Facility (None) */
        {
            stroke: #ff8c00;
        }

        /* Blocked Paths Animation */
        /* Note that .backgroundPath must be kept in, however intelliJ will note it as unused but the class for the path animations is created on page load */
            /* Condensation */
        [link-id='[1][8]'] .backgroundPath,
        [link-id='[1][9]'] .backgroundPath,
        [link-id='[1][10]'] .backgroundPath,
        [link-id='[1][11]'] .backgroundPath,
        [link-id='[1][12]'] .backgroundPath,
            /* Precipitation ( No Blocks ) */
            /* Stormwater Runoff */
        [link-id='[3][30]'] .backgroundPath,
        [link-id='[3][31]'] .backgroundPath,
        [link-id='[3][32]'] .backgroundPath,
        [link-id='[3][33]'] .backgroundPath,
        [link-id='[3][34]'] .backgroundPath
            /* Surface Water ( No Blocks ) */
            /* Shallow Ground Water */
        [link-id='[5][52]'] .backgroundPath,
        [link-id='[5][53]'] .backgroundPath,
        [link-id='[5][54]'] .backgroundPath,
        [link-id='[5][55]'] .backgroundPath,
        [link-id='[5][56]'] .backgroundPath,
        [link-id='[5][57]'] .backgroundPath,
        [link-id='[5][58]'] .backgroundPath,
        [link-id='[5][59]'] .backgroundPath,
        [link-id='[5][60]'] .backgroundPath,
        [link-id='[5][61]'] .backgroundPath,
        [link-id='[5][62]'] .backgroundPath
            /* Ground Water ( No Blocks ) */
            /* Water Facility (None) */
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
