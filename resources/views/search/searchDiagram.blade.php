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
                    <button class="btn btn-primary fas search-btn" value="Food Disposer" title="Food Disposer"><img src="/img/app_KITCHEN SINK.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Dishwasher" title="Dishwasher"><img src="/img/app_DISHWASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Lavatory" title="Lavatory"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Tub & Shower" title="Tub & Shower"><img src="/img/app_TUB-SHOWER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Fire Suppression" title="Fire Suppression"><img src="/img/app_FIRE.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Mechanical Cooling / P-Trap Prime" title="Mechanical Cooling / P-Trap Prime"><img src="/img/app_MECHANICAL.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Clothes Washer" title="Clothes Washer"><img src="/img/app_CLOTHS WASHER.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet" title="Toilet"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Toilet (Composting)" title="Toilet (Composting)"><img src="/img/toilet.png" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Urinal" title="Urinal"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
                    <button class="btn btn-primary fas search-btn" value="Urinal (Waterless / Diverted)" title="Urinal (Waterless / Diverted)"><img src="/img/app_LAVATORY.jpg" height=30px width=30px/></button>
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
                        <div style="background-color:#ff0000;"></div>  Pathway Blocked / No Regulations
                    </div>
                </div>
                <div style="width:100%; height:700px;" id="orgchart"/>
                <script>
                    var state_dest = [];
                    var county_dest = [];
                    var city_dest = [];
                    var stateRules = {!! json_encode($stateRules, JSON_HEX_TAG) !!};            // get the state regulations that are allowed
                    var countyRules = {!! json_encode($countyRules, JSON_HEX_TAG) !!};          // get the county regulations that are allowed
                    var cityRules = {!! json_encode($cityRules, JSON_HEX_TAG) !!};              // get the city regulations that are allowed
                    var sources = {!! json_encode($sources, JSON_HEX_TAG) !!};                  // get the source nodes from the database
                    var destinations = {!! json_encode($destinations, JSON_HEX_TAG) !!};        // get the destination nodes from the database
                    var reusenode = [];                                                         //array to hold all the node names
                    /* Add the destination nodes not in sources into the sources array */
                    for(var i = 0; i < destinations.length; i++) {
                        if(destinations[i].node_id > 15){
                            sources.push(destinations[i])
                        }
                    }
                    /* Add all the node names to an array */
                    for(var i = 0; i < sources.length; i++) {
                        reusenode.push(sources[i].node_name);
                    }

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
                    icons[9].src = "{{ URL::asset('img/app_DISHWASHER.jpg') }}";
                    icons[10] = new Image();
                    icons[10].src = "{{ URL::asset('img/app_LAVATORY.jpg') }}";
                    icons[11] = new Image();
                    icons[11].src = "{{ URL::asset('img/app_TUB-SHOWER.jpg') }}";
                    icons[12] = new Image();
                    icons[12].src = "{{ URL::asset('img/app_FIRE.jpg') }}";
                    icons[13] = new Image();
                    icons[13].src = "{{ URL::asset('img/app_MECHANICAL.jpg') }}";
                    icons[14] = new Image();
                    icons[14].src = "{{ URL::asset('img/app_CLOTHS WASHER.jpg') }}";
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
                        OrgChart.templates.ana.link = '<path class="backgroundPath" stroke-linejoin="round" stroke="#00cc99" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                            '<path class="dashPath" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

                        /* Custom Template to not available nodes*/
                        OrgChart.templates.no_regulation = Object.assign({}, OrgChart.templates.ana);

                        OrgChart.templates.no_regulation.node =
                            '<rect x="0" y="0" height="120" width="250" fill="#ff0000" stroke-width="1" stroke="#808080" rx="5" ry="5"></rect>'

                        OrgChart.templates.no_regulation.link = '<path class="backgroundPath" stroke-linejoin="round" stroke="#00cc99" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                            '<path class="dashPath" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

                        /* Custom template for nodes that may have path */
                        OrgChart.templates.possible_pathway = Object.assign({}, OrgChart.templates.ana);

                        //ff8c00

                        OrgChart.templates.possible_pathway.node =
                            '<rect x="0" y="0" height="120" width="250" fill="#ff8c00" stroke-width="1" stroke="#808080" rx="5" ry="5"></rect>'

                        OrgChart.templates.possible_pathway.link = '<path class="backgroundPath" stroke-linejoin="round" stroke="#00cc99" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                            '<path class="dashPath" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

                        var nodes = [
                            /* Water Sources Root */
                            {id: 0, Name: "Water Sources", img: "data:image/jpeg;base64," + string_icons[0]},
                            /* Level 2 Water Sources */
                            {id: 1, pid: 0, Name: "Condensate", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[1]},
                            {id: 2, pid: 0, Name: "Precipitation", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[2]},
                            {id: 3, pid: 0, Name: "Storm Water Runoff", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[3]},
                            {id: 4, pid: 0, Name: "Surface Water", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[4]},
                            {id: 5, pid: 0, Name: "Shallow Ground Water", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[5]},
                            {id: 6, pid: 0, Name: "Ground Water", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[6]},
                            {id: 7, pid: 0, Name: "Water Facility/ Purveyor", Source: "Water Sources", Links: "", img: "data:image/jpeg;base64," + string_icons[7]},

                            /* Level 3 Child Nodes */
                            /* Condensate Child Nodes */
                            {id: 8, pid: 1, Name: "Kitchen Sink", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 9, pid: 1, Name: "Food Disposer", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 10, pid: 1, Name: "Dishwasher", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 11, pid: 1, Name: "Lavatory", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 12, pid: 1, Name: "Tub & Shower", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 13, pid: 1, Name: "Fire Suppression", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 14, pid: 1, Name: "Mechanical Cooling / P-Trap Prime", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 15, pid: 1, Name: "Clothes Washer", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 16, pid: 1, Name: "Toilet", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 17, pid: 1, Name: "Toilet (Composting)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 18, pid: 1, Name: "Urinal", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 19, pid: 1, Name: "Urinal (Waterless / Diverted)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                            /* Precipitation Child Nodes */
                            {id: 20, pid: 2, Name: "Kitchen Sink", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 21, pid: 2, Name: "Food Disposer", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 22, pid: 2, Name: "Dishwasher", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 23, pid: 2, Name: "Lavatory", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 24, pid: 2, Name: "Tub & Shower", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 25, pid: 2, Name: "Fire Suppression", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 26, pid: 2, Name: "Mechanical Cooling / P-Trap Prime", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 27, pid: 2, Name: "Clothes Washer", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 28, pid: 2, Name: "Toilet", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 29, pid: 2, Name: "Toilet (Composting)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 30, pid: 2, Name: "Urinal", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 31, pid: 2, Name: "Urinal (Waterless / Diverted)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                            /* Stormwater Runoff Child Nodes */
                            {id: 32, pid: 3, Name: "Kitchen Sink", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 33, pid: 3, Name: "Food Disposer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 34, pid: 3, Name: "Dishwasher", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 35, pid: 3, Name: "Lavatory", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 36, pid: 3, Name: "Tub & Shower", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 37, pid: 3, Name: "Fire Suppression", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 38, pid: 3, Name: "Mechanical Cooling / P-Trap Prime", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 39, pid: 3, Name: "Clothes Washer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 40, pid: 3, Name: "Toilet", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 41, pid: 3, Name: "Toilet (Composting)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 42, pid: 3, Name: "Urinal", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 43, pid: 3, Name: "Urinal (Waterless / Diverted)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                            /* Surface Water Child Nodes */
                            {id: 44, pid: 4, Name: "Kitchen Sink", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 45, pid: 4, Name: "Food Disposer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 46, pid: 4, Name: "Dishwasher", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 47, pid: 4, Name: "Lavatory", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 48, pid: 4, Name: "Tub & Shower", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 49, pid: 4, Name: "Fire Suppression", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 50, pid: 4, Name: "Mechanical Cooling / P-Trap Prime", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 51, pid: 4, Name: "Clothes Washer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 52, pid: 4, Name: "Toilet", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 53, pid: 4, Name: "Toilet (Composting)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 54, pid: 4, Name: "Urinal", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 55, pid: 4, Name: "Urinal (Waterless / Diverted)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                            /* Shallow Groundwater Child Nodes */
                            {id: 56, pid: 5, Name: "Kitchen Sink", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 57, pid: 5, Name: "Food Disposer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 58, pid: 5, Name: "Dishwasher", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 59, pid: 5, Name: "Lavatory", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 60, pid: 5, Name: "Tub & Shower", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 61, pid: 5, Name: "Fire Suppression", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 62, pid: 5, Name: "Mechanical Cooling / P-Trap Prime", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 63, pid: 5, Name: "Clothes Washer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 64, pid: 5, Name: "Toilet", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 65, pid: 5, Name: "Toilet (Composting)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 66, pid: 5, Name: "Urinal", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 67, pid: 5, Name: "Urinal (Waterless / Diverted)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                            /* Ground Water Child Nodes */
                            {id: 68, pid: 6, Name: "Kitchen Sink", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 69, pid: 6, Name: "Food Disposer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                            {id: 70, pid: 6, Name: "Dishwasher", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                            {id: 71, pid: 6, Name: "Lavatory", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                            {id: 72, pid: 6, Name: "Tub & Shower", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                            {id: 73, pid: 6, Name: "Fire Suppression", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                            {id: 74, pid: 6, Name: "Mechanical Cooling / P-Trap Prime", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                            {id: 75, pid: 6, Name: "Clothes Washer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                            {id: 76, pid: 6, Name: "Toilet", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 77, pid: 6, Name: "Toilet (Composting)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                            {id: 78, pid: 6, Name: "Urinal", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                            {id: 79, pid: 6, Name: "Urinal (Waterless / Diverted)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]}

                            /* Water Facility Child Nodes ( None ) */
                        ]

                        /* Variables for the state, county, city allowed and blocked reusenodes */
                        var stateSurfaceWaterAllowed = [];
                        var stateShallowGroundWaterAllowed = [];
                        var stateGroundWaterAllowed = [];
                        var stateStormWaterAllowed = [];
                        var stateprecipitationAllowed = [];
                        var stateCondensateAllowed = [];
                        var stateSurfaceWaterBlocked = [];
                        var stateShallowGroundWaterBlocked = [];
                        var stateGroundWaterBlocked = [];
                        var stateStormWaterBlocked = [];
                        var stateprecipitationBlocked = [];
                        var stateCondensateBlocked = [];

                        /* Look at the allowed nodes for the state depending on the water source */
                        for(var i = 0; i < stateRules.length; i++) {
                            if(stateRules[i].source.node_name === 'Surface Water') {
                                stateSurfaceWaterAllowed.push(stateRules[i].destination.node_name);
                            }
                            if(stateRules[i].source.node_name === 'Shallow Groundwater') {
                                stateShallowGroundWaterAllowed.push(stateRules[i].destination.node_name);
                            }
                            if(stateRules[i].source.node_name === 'Ground Water') {
                                stateGroundWaterAllowed.push(stateRules[i].destination.node_name);
                            }
                            if(stateRules[i].source.node_name === 'Stormwater Runoff') {
                                stateStormWaterAllowed.push(stateRules[i].destination.node_name);
                            }
                            if(stateRules[i].source.node_name === 'Precipitation') {
                                stateprecipitationAllowed.push(stateRules[i].destination.node_name);
                            }
                            if(stateRules[i].source.node_name === 'Condensate') {
                                stateCondensateAllowed.push(stateRules[i].destination.node_name);
                            }
                        }

                        /* Look at complete list of reusenode and find nodes that are not allowed */
                        for(var i = 0; i < reusenode.length; i++) {
                            if(stateSurfaceWaterAllowed.includes(reusenode[i]) !== true) {
                                stateSurfaceWaterBlocked.push(reusenode[i]);
                            }
                            if(stateShallowGroundWaterAllowed.includes(reusenode[i]) !== true) {
                                stateShallowGroundWaterBlocked.push(reusenode[i]);
                            }
                            if(stateGroundWaterAllowed.includes(reusenode[i]) !== true) {
                                stateGroundWaterBlocked.push(reusenode[i]);
                            }
                            if(stateStormWaterAllowed.includes(reusenode[i]) !== true) {
                                stateStormWaterBlocked.push(reusenode[i]);
                            }
                            if(stateprecipitationAllowed.includes(reusenode[i]) !== true) {
                                stateprecipitationBlocked.push(reusenode[i]);
                            }
                            if(stateCondensateAllowed.includes(reusenode[i]) !== true) {
                                stateCondensateBlocked.push(reusenode[i]);
                            }
                        }

                        surfaceWaterNotAllowedNodes = []
                        shallowGroundWaterNotAllowedNodes = []
                        groundWaterNotAllowedNodes = []
                        stormWaterNotAllowedNodes = []
                        precipitationNotAllowedNodes = []
                        condensateNotAllowedNodes = []
                        for(var i = 0; i < reusenode.length; i++) {
                            if(stateSurfaceWaterBlocked.includes(reusenode[i])) {
                                surfaceWaterNotAllowedNodes.push(reusenode[i]);
                            }
                            if(stateShallowGroundWaterBlocked.includes(reusenode[i])) {
                                shallowGroundWaterNotAllowedNodes.push(reusenode[i]);
                            }
                            if(stateGroundWaterBlocked.includes(reusenode[i])) {
                                groundWaterNotAllowedNodes.push(reusenode[i]);
                            }
                            if(stateStormWaterBlocked.includes(reusenode[i])) {
                                stormWaterNotAllowedNodes.push(reusenode[i]);
                            }
                            if(stateprecipitationBlocked.includes(reusenode[i])) {
                                precipitationNotAllowedNodes.push(reusenode[i]);
                            }
                            if(stateCondensateBlocked.includes(reusenode[i])) {
                                condensateNotAllowedNodes.push(reusenode[i]);
                            }
                        }

                        /* Switch all the nodes from each source to grey if it is in the NotAllowedNodes */
                        for(var i = 8; i < nodes.length; i++) {
                            if(nodes[i].pid === 1) {
                                for(var j = 0; j < condensateNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === condensateNotAllowedNodes[j]) {
                                        nodes[i].tags = ['no_regulation']
                                    }
                                }
                            }
                            if(nodes[i].pid === 2) {
                                for(var j = 0; j < precipitationNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === precipitationNotAllowedNodes[j]) {
                                        nodes[i].tags = ['PathwayBlocked']
                                    }
                                }
                            }
                            if(nodes[i].pid === 3) {
                                for(var j = 0; j < stormWaterNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === stormWaterNotAllowedNodes[j]) {
                                        nodes[i].tags = ['PathwayBlocked']
                                    }
                                }
                            }
                            if(nodes[i].pid === 4) {
                                for(var j = 0; j < surfaceWaterNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === surfaceWaterNotAllowedNodes[j]) {
                                        nodes[i].tags = ['PathwayBlocked']
                                    }
                                }
                            }
                            if(nodes[i].pid === 5) {
                                for(var j = 0; j < shallowGroundWaterNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === shallowGroundWaterNotAllowedNodes[j]) {
                                        nodes[i].tags = ['PathwayBlocked']
                                    }
                                }
                            }
                            if(nodes[i].pid === 6) {
                                for(var j = 0; j < groundWaterNotAllowedNodes.length; j++){
                                    if(nodes[i].Name === groundWaterNotAllowedNodes[j]) {
                                        nodes[i].tags = ['PathwayBlocked']
                                    }
                                }
                            }
                        }
                        console.log(stateRules);

                        for(var i = 0; i < stateRules.length; i++) {
                            if(stateRules[i].allowed.allowed_id === 2) {
                                for(var j = 0; j < nodes.length; j++) {
                                    if(stateRules[i].source.node_name === nodes[j].Source && stateRules[i].destination.node_name === nodes[j].Name) {
                                        nodes[j].tags = ['PathwayNotAddressed']
                                    }
                                }
                            }
                        }


                        /* Chart */
                        let chart = new OrgChart(document.getElementById("orgchart"), {
                            template: "ana",
                            enableSearch: true,
                            searchFields: ["Name", "Source", "img"],
                            align: OrgChart.ORIENTATION,
                            tags: {
                                PathwayBlocked: {
                                    template: "no_regulation"
                                },
                                PathwayNotAddressed: {
                                    template: "possible_pathway"
                                }
                            },
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
                                field_1: "Source",
                                field_2: "Links",
                                img_0: "img",
                            },
                            collapse: {
                                level: 2,
                                allChildren: true
                            },

                            nodes: nodes
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
        #tree {
            width: 100%;
            height: 100%;
            position: relative;
        }
       /*color*/
        .node.available rect{
            stroke: blue;
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
