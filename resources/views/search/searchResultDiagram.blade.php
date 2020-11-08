<div class="card mb-3">
    <div class="card-body">
        <div class="legend-content">
            <div>
                <div style="background-color:#00cdcd;"></div>  Pathway Allowed
            </div>
            <div>
                <div style="background-color:#ff8c00;"></div>  Pathway Not Addressed
            </div>
            <div>
                <div style="background-color:#ff0000;"></div>  Pathway Blocked / No Regulations
            </div>
            <div>
                <div style="background-color:#9a9a9a;"></div>  Greywater
            </div>
            <div>
                <div style="background-color:#373737;"></div>  Sewage
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
                OrgChart.templates.possible_pathway.node =
                    '<rect x="0" y="0" height="120" width="250" fill="#ff8c00" stroke-width="1" stroke="#808080" rx="5" ry="5"></rect>'

                OrgChart.templates.possible_pathway.link = '<path class="backgroundPath" stroke-linejoin="round" stroke="#00cc99" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                    '<path class="dashPath" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

                /* Greywater & Sewage Custom Nodes */
                OrgChart.templates.greywater = Object.assign({}, OrgChart.templates.ana);
                OrgChart.templates.greywater.node = '<rect x="0" y="0" height="125" width="255" rx="40px" fill="#9a9a9a"></rect>';
                OrgChart.templates.sewage = Object.assign({}, OrgChart.templates.ana);
                OrgChart.templates.sewage.node = '<rect x="0" y="0" height="125" width="255" rx="40px" fill="#373737"></rect>';

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
                    {id: 18, pid: 1, Name: "Toilet (Source Separated)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 19, pid: 1, Name: "Urinal", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 20, pid: 1, Name: "Urinal (Waterless / Diverted)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Precipitation Child Nodes */
                    {id: 21, pid: 2, Name: "Kitchen Sink", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 22, pid: 2, Name: "Food Disposer", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 23, pid: 2, Name: "Dishwasher", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 24, pid: 2, Name: "Lavatory", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 25, pid: 2, Name: "Tub & Shower", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 26, pid: 2, Name: "Fire Suppression", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 27, pid: 2, Name: "Mechanical Cooling / P-Trap Prime", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 28, pid: 2, Name: "Clothes Washer", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 29, pid: 2, Name: "Toilet", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 30, pid: 2, Name: "Toilet (Composting)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 31, pid: 2, Name: "Toilet (Source Separated)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 32, pid: 2, Name: "Urinal", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 33, pid: 2, Name: "Urinal (Waterless / Diverted)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Stormwater Runoff Child Nodes */
                    {id: 34, pid: 3, Name: "Kitchen Sink", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 35, pid: 3, Name: "Food Disposer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 36, pid: 3, Name: "Dishwasher", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 37, pid: 3, Name: "Lavatory", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 38, pid: 3, Name: "Tub & Shower", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 39, pid: 3, Name: "Fire Suppression", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 40, pid: 3, Name: "Mechanical Cooling / P-Trap Prime", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 41, pid: 3, Name: "Clothes Washer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 42, pid: 3, Name: "Toilet", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 43, pid: 3, Name: "Toilet (Composting)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 44, pid: 3, Name: "Toilet (Source Separated)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 45, pid: 3, Name: "Urinal", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 46, pid: 3, Name: "Urinal (Waterless / Diverted)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Surface Water Child Nodes */
                    {id: 47, pid: 4, Name: "Kitchen Sink", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 48, pid: 4, Name: "Food Disposer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 49, pid: 4, Name: "Dishwasher", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 50, pid: 4, Name: "Lavatory", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 51, pid: 4, Name: "Tub & Shower", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 52, pid: 4, Name: "Fire Suppression", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 53, pid: 4, Name: "Mechanical Cooling / P-Trap Prime", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 54, pid: 4, Name: "Clothes Washer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 55, pid: 4, Name: "Toilet", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 56, pid: 4, Name: "Toilet (Composting)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 57, pid: 4, Name: "Toilet (Source Separated)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 58, pid: 4, Name: "Urinal", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 59, pid: 4, Name: "Urinal (Waterless / Diverted)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Shallow Groundwater Child Nodes */
                    {id: 60, pid: 5, Name: "Kitchen Sink", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 61, pid: 5, Name: "Food Disposer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 62, pid: 5, Name: "Dishwasher", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 63, pid: 5, Name: "Lavatory", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 64, pid: 5, Name: "Tub & Shower", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 65, pid: 5, Name: "Fire Suppression", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 66, pid: 5, Name: "Mechanical Cooling / P-Trap Prime", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 67, pid: 5, Name: "Clothes Washer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 68, pid: 5, Name: "Toilet", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 69, pid: 5, Name: "Toilet (Composting)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 70, pid: 5, Name: "Toilet (Source Separated)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 71, pid: 5, Name: "Urinal", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 72, pid: 5, Name: "Urinal (Waterless / Diverted)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Ground Water Child Nodes */
                    {id: 73, pid: 6, Name: "Kitchen Sink", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 74, pid: 6, Name: "Food Disposer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 75, pid: 6, Name: "Dishwasher", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 76, pid: 6, Name: "Lavatory", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 77, pid: 6, Name: "Tub & Shower", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 78, pid: 6, Name: "Fire Suppression", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 79, pid: 6, Name: "Mechanical Cooling / P-Trap Prime", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 80, pid: 6, Name: "Clothes Washer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 81, pid: 6, Name: "Toilet", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 82, pid: 6, Name: "Toilet (Composting)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 83, pid: 6, Name: "Toilet (Source Separated)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 84, pid: 6, Name: "Urinal", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 85, pid: 6, Name: "Urinal (Waterless / Diverted)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /*


                    Greywater & Sewage PARENT Nodes (Children of Reuse Option Nodes)
                        Note: id's are in negative since they aren't full node options (just parent section holders)


                    */

                    /* Greywater & Sewage Parent Nodes */
                    {id: -1, pid: 8, Name: "Greywater", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -2, pid: 8, Name: "Sewage", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -3, pid: 9, Name: "Greywater", Source: "Food Disposer", Links: "", img: ""},
                    {id: -4, pid: 9, Name: "Sewage", Source: "Food Disposer", Links: "", img: ""},
                    {id: -5, pid: 10, Name: "Greywater", Source: "Dishwasher", Links: "", img: ""},
                    {id: -6, pid: 10, Name: "Sewage", Source: "Dishwasher", Links: "", img: ""},
                    {id: -7, pid: 11, Name: "Greywater", Source: "Lavatory", Links: "", img: ""},
                    {id: -8, pid: 11, Name: "Sewage", Source: "Lavatory", Links: "", img: ""},
                    {id: -9, pid: 12, Name: "Greywater", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -10, pid: 12, Name: "Sewage", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -11, pid: 13, Name: "Greywater", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -12, pid: 13, Name: "Sewage", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -13, pid: 14, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -14, pid: 14, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -15, pid: 15, Name: "Greywater", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -16, pid: 15, Name: "Sewage", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -17, pid: 16, Name: "Greywater", Source: "Toilet", Links: "", img: ""},
                    {id: -18, pid: 16, Name: "Sewage", Source: "Toilet", Links: "", img: ""},
                    {id: -19, pid: 17, Name: "Greywater", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -20, pid: 17, Name: "Sewage", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -21, pid: 18, Name: "Greywater", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -22, pid: 18, Name: "Sewage", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -23, pid: 19, Name: "Greywater", Source: "Urinal", Links: "", img: ""},
                    {id: -24, pid: 19, Name: "Sewage", Source: "Urinal", Links: "", img: ""},
                    {id: -25, pid: 20, Name: "Greywater", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},
                    {id: -26, pid: 20, Name: "Sewage", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes */
                    {id: -27, pid: 21, Name: "Greywater", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -28, pid: 21, Name: "Sewage", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -29, pid: 22, Name: "Greywater", Source: "Food Disposer", Links: "", img: ""},
                    {id: -30, pid: 22, Name: "Sewage", Source: "Food Disposer", Links: "", img: ""},
                    {id: -31, pid: 23, Name: "Greywater", Source: "Dishwasher", Links: "", img: ""},
                    {id: -32, pid: 23, Name: "Sewage", Source: "Dishwasher", Links: "", img: ""},
                    {id: -33, pid: 24, Name: "Greywater", Source: "Lavatory", Links: "", img: ""},
                    {id: -34, pid: 24, Name: "Sewage", Source: "Lavatory", Links: "", img: ""},
                    {id: -35, pid: 25, Name: "Greywater", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -36, pid: 25, Name: "Sewage", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -37, pid: 26, Name: "Greywater", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -38, pid: 26, Name: "Sewage", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -39, pid: 27, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -40, pid: 27, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -41, pid: 28, Name: "Greywater", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -42, pid: 28, Name: "Sewage", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -43, pid: 29, Name: "Greywater", Source: "Toilet", Links: "", img: ""},
                    {id: -44, pid: 29, Name: "Sewage", Source: "Toilet", Links: "", img: ""},
                    {id: -45, pid: 30, Name: "Greywater", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -46, pid: 30, Name: "Sewage", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -47, pid: 31, Name: "Greywater", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -48, pid: 31, Name: "Sewage", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -49, pid: 32, Name: "Greywater", Source: "Urinal", Links: "", img: ""},
                    {id: -50, pid: 32, Name: "Sewage", Source: "Urinal", Links: "", img: ""},
                    {id: -51, pid: 33, Name: "Greywater", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},
                    {id: -52, pid: 33, Name: "Sewage", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes */
                    {id: -53, pid: 34, Name: "Greywater", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -54, pid: 34, Name: "Sewage", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -55, pid: 35, Name: "Greywater", Source: "Food Disposer", Links: "", img: ""},
                    {id: -56, pid: 35, Name: "Sewage", Source: "Food Disposer", Links: "", img: ""},
                    {id: -57, pid: 36, Name: "Greywater", Source: "Dishwasher", Links: "", img: ""},
                    {id: -58, pid: 36, Name: "Sewage", Source: "Dishwasher", Links: "", img: ""},
                    {id: -59, pid: 37, Name: "Greywater", Source: "Lavatory", Links: "", img: ""},
                    {id: -60, pid: 37, Name: "Sewage", Source: "Lavatory", Links: "", img: ""},
                    {id: -61, pid: 38, Name: "Greywater", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -62, pid: 38, Name: "Sewage", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -63, pid: 39, Name: "Greywater", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -64, pid: 39, Name: "Sewage", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -65, pid: 40, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -66, pid: 40, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -67, pid: 41, Name: "Greywater", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -68, pid: 41, Name: "Sewage", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -69, pid: 42, Name: "Greywater", Source: "Toilet", Links: "", img: ""},
                    {id: -70, pid: 42, Name: "Sewage", Source: "Toilet", Links: "", img: ""},
                    {id: -71, pid: 43, Name: "Greywater", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -72, pid: 43, Name: "Sewage", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -73, pid: 44, Name: "Greywater", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -74, pid: 44, Name: "Sewage", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -75, pid: 45, Name: "Greywater", Source: "Urinal", Links: "", img: ""},
                    {id: -76, pid: 45, Name: "Sewage", Source: "Urinal", Links: "", img: ""},
                    {id: -77, pid: 46, Name: "Greywater", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},
                    {id: -78, pid: 46, Name: "Sewage", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes */
                    {id: -79, pid: 47, Name: "Greywater", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -80, pid: 47, Name: "Sewage", Source: "Kitchen Sink", Links: "", img: ""},
                    {id: -81, pid: 48, Name: "Greywater", Source: "Food Disposer", Links: "", img: ""},
                    {id: -82, pid: 48, Name: "Sewage", Source: "Food Disposer", Links: "", img: ""},
                    {id: -83, pid: 49, Name: "Greywater", Source: "Dishwasher", Links: "", img: ""},
                    {id: -84, pid: 49, Name: "Sewage", Source: "Dishwasher", Links: "", img: ""},
                    {id: -85, pid: 50, Name: "Greywater", Source: "Lavatory", Links: "", img: ""},
                    {id: -86, pid: 50, Name: "Sewage", Source: "Lavatory", Links: "", img: ""},
                    {id: -87, pid: 51, Name: "Greywater", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -88, pid: 51, Name: "Sewage", Source: "Tub & Shower", Links: "", img: ""},
                    {id: -89, pid: 52, Name: "Greywater", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -90, pid: 52, Name: "Sewage", Source: "Fire Suppression", Links: "", img: ""},
                    {id: -91, pid: 53, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -92, pid: 53, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: ""},
                    {id: -93, pid: 54, Name: "Greywater", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -94, pid: 54, Name: "Sewage", Source: "Clothes Washer", Links: "", img: ""},
                    {id: -95, pid: 55, Name: "Greywater", Source: "Toilet", Links: "", img: ""},
                    {id: -96, pid: 55, Name: "Sewage", Source: "Toilet", Links: "", img: ""},
                    {id: -97, pid: 56, Name: "Greywater", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -98, pid: 56, Name: "Sewage", Source: "Toilet (Composting)", Links: "", img: ""},
                    {id: -99, pid: 57, Name: "Greywater", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -100, pid: 57, Name: "Sewage", Source: "Toilet (Source Separated)", Links: "", img: ""},
                    {id: -101, pid: 58, Name: "Greywater", Source: "Urinal", Links: "", img: ""},
                    {id: -102, pid: 58, Name: "Sewage", Source: "Urinal", Links: "", img: ""},
                    {id: -103, pid: 59, Name: "Greywater", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},
                    {id: -104, pid: 59, Name: "Sewage", Source: "Urinal (Waterless / Diverted)", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Shallow Groundwater */
                    {id: -105, pid: 60, Name: "Greywater", Source: "Kitchen Sink ", Links: "", img: ""},
                    {id: -106, pid: 60, Name: "Sewage", Source: "Kitchen Sink ", Links: "", img: ""},
                    {id: -107, pid: 61, Name: "Greywater", Source: "Food Disposer ", Links: "", img: ""},
                    {id: -108, pid: 61, Name: "Sewage", Source: "Food Disposer ", Links: "", img: ""},
                    {id: -109, pid: 62, Name: "Greywater", Source: "Dishwasher ", Links: "", img: ""},
                    {id: -110, pid: 62, Name: "Sewage", Source: "Dishwasher ", Links: "", img: ""},
                    {id: -111, pid: 63, Name: "Greywater", Source: "Lavatory ", Links: "", img: ""},
                    {id: -112, pid: 63, Name: "Sewage", Source: "Lavatory ", Links: "", img: ""},
                    {id: -113, pid: 64, Name: "Greywater", Source: "Tub & Shower ", Links: "", img: ""},
                    {id: -114, pid: 64, Name: "Sewage", Source: "Tub & Shower ", Links: "", img: ""},
                    {id: -115, pid: 65, Name: "Greywater", Source: "Fire Suppression ", Links: "", img: ""},
                    {id: -116, pid: 65, Name: "Sewage", Source: "Fire Suppression ", Links: "", img: ""},
                    {id: -117, pid: 66, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ", Links: "", img: ""},
                    {id: -118, pid: 66, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ", Links: "", img: ""},
                    {id: -119, pid: 67, Name: "Greywater", Source: "Clothes Washer ", Links: "", img: ""},
                    {id: -120, pid: 67, Name: "Sewage", Source: "Clothes Washer ", Links: "", img: ""},
                    {id: -121, pid: 68, Name: "Greywater", Source: "Toilet ", Links: "", img: ""},
                    {id: -122, pid: 68, Name: "Sewage", Source: "Toilet ", Links: "", img: ""},
                    {id: -123, pid: 69, Name: "Greywater", Source: "Toilet (Composting) ", Links: "", img: ""},
                    {id: -124, pid: 69, Name: "Sewage", Source: "Toilet (Composting) ", Links: "", img: ""},
                    {id: -125, pid: 70, Name: "Greywater", Source: "Toilet (Source Separated) ", Links: "", img: ""},
                    {id: -126, pid: 70, Name: "Sewage", Source: "Toilet (Source Separated) ", Links: "", img: ""},
                    {id: -127, pid: 71, Name: "Greywater", Source: "Urinal ", Links: "", img: ""},
                    {id: -128, pid: 71, Name: "Sewage", Source: "Urinal ", Links: "", img: ""},
                    {id: -129, pid: 72, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ", Links: "", img: ""},
                    {id: -130, pid: 72, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Ground Water */
                    {id: -131, pid: 73, Name: "Greywater", Source: "Kitchen Sink ", Links: "", img: ""},
                    {id: -132, pid: 73, Name: "Sewage", Source: "Kitchen Sink ", Links: "", img: ""},
                    {id: -133, pid: 74, Name: "Greywater", Source: "Food Disposer ", Links: "", img: ""},
                    {id: -134, pid: 74, Name: "Sewage", Source: "Food Disposer ", Links: "", img: ""},
                    {id: -135, pid: 75, Name: "Greywater", Source: "Dishwasher ", Links: "", img: ""},
                    {id: -136, pid: 75, Name: "Sewage", Source: "Dishwasher ", Links: "", img: ""},
                    {id: -137, pid: 76, Name: "Greywater", Source: "Lavatory ", Links: "", img: ""},
                    {id: -138, pid: 76, Name: "Sewage", Source: "Lavatory ", Links: "", img: ""},
                    {id: -139, pid: 77, Name: "Greywater", Source: "Tub & Shower ", Links: "", img: ""},
                    {id: -140, pid: 77, Name: "Sewage", Source: "Tub & Shower ", Links: "", img: ""},
                    {id: -141, pid: 78, Name: "Greywater", Source: "Fire Suppression ", Links: "", img: ""},
                    {id: -142, pid: 78, Name: "Sewage", Source: "Fire Suppression ", Links: "", img: ""},
                    {id: -143, pid: 79, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ", Links: "", img: ""},
                    {id: -144, pid: 79, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ", Links: "", img: ""},
                    {id: -145, pid: 80, Name: "Greywater", Source: "Clothes Washer ", Links: "", img: ""},
                    {id: -146, pid: 80, Name: "Sewage", Source: "Clothes Washer ", Links: "", img: ""},
                    {id: -147, pid: 81, Name: "Greywater", Source: "Toilet ", Links: "", img: ""},
                    {id: -148, pid: 81, Name: "Sewage", Source: "Toilet ", Links: "", img: ""},
                    {id: -149, pid: 82, Name: "Greywater", Source: "Toilet (Composting) ", Links: "", img: ""},
                    {id: -150, pid: 82, Name: "Sewage", Source: "Toilet (Composting) ", Links: "", img: ""},
                    {id: -151, pid: 83, Name: "Greywater", Source: "Toilet (Source Separated) ", Links: "", img: ""},
                    {id: -152, pid: 83, Name: "Sewage", Source: "Toilet (Source Separated) ", Links: "", img: ""},
                    {id: -153, pid: 84, Name: "Greywater", Source: "Urinal ", Links: "", img: ""},
                    {id: -154, pid: 84, Name: "Sewage", Source: "Urinal ", Links: "", img: ""},
                    {id: -155, pid: 85, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ", Links: "", img: ""},
                    {id: -156, pid: 85, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ", Links: "", img: ""},

                    /*


                       Greywater & Sewage CHILD Nodes


                    */

                    /* Parcipitation */


                    /* Greywater / Sewage Child Nodes ~ Kitchen Sink */
                    {id: 86, pid: -1, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 87, pid: -1, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 88, pid: -1, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 89, pid: -1, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 90, pid: -1, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 91, pid: -1, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 92, pid: -2, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 93, pid: -2, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 94, pid: -2, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 95, pid: -2, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 96, pid: -2, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 97, pid: -2, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 98, pid: -2, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Food Disposer */
                    {id: 99, pid: -3, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 100, pid: -3, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 101, pid: -3, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 102, pid: -3, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 103, pid: -3, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 104, pid: -3, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 105, pid: -4, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 106, pid: -4, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 107, pid: -4, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 108, pid: -4, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 109, pid: -4, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 110, pid: -4, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 111, pid: -4, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Dishwasher */
                    {id: 112, pid: -5, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 113, pid: -5, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 114, pid: -5, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 115, pid: -5, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 116, pid: -5, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 117, pid: -5, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 118, pid: -6, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 119, pid: -6, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 120, pid: -6, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 121, pid: -6, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 122, pid: -6, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 123, pid: -6, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 124, pid: -6, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Lavatory */
                    {id: 125, pid: -7, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 126, pid: -7, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 127, pid: -7, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 128, pid: -7, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 129, pid: -7, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 130, pid: -7, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 131, pid: -8, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 132, pid: -8, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 133, pid: -8, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 134, pid: -8, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 135, pid: -8, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 136, pid: -8, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 137, pid: -8, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Tub & Shower */
                    {id: 138, pid: -9, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 139, pid: -9, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 140, pid: -9, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 141, pid: -9, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 142, pid: -9, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 143, pid: -9, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 144, pid: -10, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 145, pid: -10, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 146, pid: -10, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 147, pid: -10, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 148, pid: -10, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 149, pid: -10, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 150, pid: -10, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Fire Suppression */
                    {id: 151, pid: -11, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 152, pid: -11, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 153, pid: -11, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 154, pid: -11, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 155, pid: -11, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 156, pid: -11, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 157, pid: -12, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 158, pid: -12, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 159, pid: -12, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 160, pid: -12, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 161, pid: -12, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 162, pid: -12, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 163, pid: -12, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Mechanical Cooling / P-Trap Prime */
                    {id: 164, pid: -13, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 165, pid: -13, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 166, pid: -13, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 167, pid: -13, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 168, pid: -13, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 169, pid: -13, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 170, pid: -14, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 171, pid: -14, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 172, pid: -14, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 173, pid: -14, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 174, pid: -14, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 175, pid: -14, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 176, pid: -14, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Clothes Washer */
                    {id: 177, pid: -15, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 178, pid: -15, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 179, pid: -15, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 180, pid: -15, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 181, pid: -15, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 182, pid: -15, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 183, pid: -16, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 184, pid: -16, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 185, pid: -16, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 186, pid: -16, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 187, pid: -16, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 188, pid: -16, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 189, pid: -16, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Toilet */
                    {id: 190, pid: -17, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 191, pid: -17, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 192, pid: -17, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 193, pid: -17, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 194, pid: -17, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 195, pid: -17, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 196, pid: -18, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 197, pid: -18, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 198, pid: -18, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 199, pid: -18, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 200, pid: -18, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 201, pid: -18, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 202, pid: -18, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Toilet (Composting) */
                    {id: 203, pid: -19, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 204, pid: -19, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 205, pid: -19, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 206, pid: -19, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 207, pid: -19, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 208, pid: -19, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 209, pid: -20, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 210, pid: -20, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 211, pid: -20, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 212, pid: -20, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 213, pid: -20, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 214, pid: -20, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 215, pid: -20, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Toilet (Source Separated) */
                    {id: 216, pid: -21, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 217, pid: -21, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 218, pid: -21, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 219, pid: -21, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 220, pid: -21, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 221, pid: -21, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 222, pid: -22, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 223, pid: -22, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 224, pid: -22, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 225, pid: -22, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 226, pid: -22, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 227, pid: -22, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 228, pid: -22, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Urinal */
                    {id: 229, pid: -23, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 230, pid: -23, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 231, pid: -23, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 232, pid: -23, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 233, pid: -23, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 234, pid: -23, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 235, pid: -24, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 236, pid: -24, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 237, pid: -24, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 238, pid: -24, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 239, pid: -24, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 240, pid: -24, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 241, pid: -24, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes ~ Urinal (Waterless / Diverted) */
                    {id: 242, pid: -25, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 243, pid: -25, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 244, pid: -25, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 245, pid: -25, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 246, pid: -25, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 247, pid: -25, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 248, pid: -26, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 249, pid: -26, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 250, pid: -26, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 251, pid: -26, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 252, pid: -26, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 253, pid: -26, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 254, pid: -26, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Condensate */


                    /* Greywater / Sewage Child Nodes ~ Kitchen Sink */
                    {id: 255, pid: -27, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 256, pid: -27, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 257, pid: -27, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 258, pid: -27, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 259, pid: -27, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 260, pid: -27, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 261, pid: -28, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 262, pid: -28, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 263, pid: -28, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 264, pid: -28, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 265, pid: -28, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 266, pid: -28, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 267, pid: -28, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 268, pid: -29, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 269, pid: -29, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 270, pid: -29, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 271, pid: -29, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 272, pid: -29, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 273, pid: -29, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 275, pid: -30, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 276, pid: -30, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 277, pid: -30, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 278, pid: -30, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 279, pid: -30, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 280, pid: -30, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 281, pid: -30, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 282, pid: -31, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 283, pid: -31, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 284, pid: -31, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 285, pid: -31, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 286, pid: -31, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 287, pid: -31, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 288, pid: -32, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 289, pid: -32, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 290, pid: -32, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 291, pid: -32, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 292, pid: -32, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 293, pid: -32, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 294, pid: -32, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 295, pid: -33, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 296, pid: -33, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 297, pid: -33, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 298, pid: -33, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 299, pid: -33, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 300, pid: -33, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 301, pid: -34, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 302, pid: -34, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 303, pid: -34, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 304, pid: -34, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 305, pid: -34, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 306, pid: -34, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 307, pid: -34, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 308, pid: -35, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 309, pid: -35, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 310, pid: -35, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 311, pid: -35, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 312, pid: -35, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 313, pid: -35, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 314, pid: -36, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 315, pid: -36, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 316, pid: -36, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 317, pid: -36, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 318, pid: -36, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 319, pid: -36, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 320, pid: -36, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 321, pid: -37, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 322, pid: -37, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 323, pid: -37, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 324, pid: -37, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 325, pid: -37, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 326, pid: -37, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 327, pid: -38, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 328, pid: -38, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 329, pid: -38, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 330, pid: -38, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 331, pid: -38, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 332, pid: -38, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 333, pid: -38, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 334, pid: -39, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 335, pid: -39, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 336, pid: -39, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 337, pid: -39, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 338, pid: -39, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 339, pid: -39, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 340, pid: -40, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 341, pid: -40, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 342, pid: -40, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 343, pid: -40, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 344, pid: -40, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 345, pid: -40, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 346, pid: -40, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 347, pid: -41, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 348, pid: -41, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 349, pid: -41, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 350, pid: -41, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 351, pid: -41, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 352, pid: -41, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 353, pid: -42, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 354, pid: -42, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 355, pid: -42, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 356, pid: -42, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 357, pid: -42, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 358, pid: -42, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 359, pid: -42, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 360, pid: -43, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 361, pid: -43, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 362, pid: -43, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 363, pid: -43, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 364, pid: -43, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 365, pid: -43, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 366, pid: -44, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 367, pid: -44, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 368, pid: -44, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 369, pid: -44, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 370, pid: -44, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 371, pid: -44, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 372, pid: -44, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 373, pid: -45, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 374, pid: -45, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 375, pid: -45, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 376, pid: -45, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 377, pid: -45, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 378, pid: -45, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 379, pid: -46, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 380, pid: -46, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 381, pid: -46, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 382, pid: -46, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 383, pid: -46, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 384, pid: -46, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 385, pid: -46, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 386, pid: -47, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 387, pid: -47, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 388, pid: -47, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 389, pid: -47, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 390, pid: -47, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 391, pid: -47, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 392, pid: -48, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 393, pid: -48, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 394, pid: -48, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 395, pid: -48, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 396, pid: -48, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 397, pid: -48, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 398, pid: -48, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 399, pid: -49, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 400, pid: -49, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 401, pid: -49, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 402, pid: -49, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 403, pid: -49, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 404, pid: -49, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 405, pid: -50, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 406, pid: -50, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 407, pid: -50, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 408, pid: -50, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 409, pid: -50, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 410, pid: -50, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 411, pid: -50, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 412, pid: -51, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 413, pid: -51, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 414, pid: -51, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 415, pid: -51, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 416, pid: -51, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 417, pid: -51, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 418, pid: -52, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 419, pid: -52, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 420, pid: -52, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 421, pid: -52, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 422, pid: -52, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 423, pid: -52, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 424, pid: -52, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Storm Water Runoff */


                    /* Greywater / Sewage Child Nodes */
                    {id: 425, pid: -53, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 426, pid: -53, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 427, pid: -53, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 428, pid: -53, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 429, pid: -53, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 430, pid: -53, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 431, pid: -54, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 432, pid: -54, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 433, pid: -54, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 434, pid: -54, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 435, pid: -54, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 436, pid: -54, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 437, pid: -54, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 438, pid: -55, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 439, pid: -55, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 440, pid: -55, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 441, pid: -55, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 442, pid: -55, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 443, pid: -55, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 445, pid: -56, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 446, pid: -56, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 447, pid: -56, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 448, pid: -56, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 449, pid: -56, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 450, pid: -56, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 451, pid: -56, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 452, pid: -57, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 453, pid: -57, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 454, pid: -57, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 455, pid: -57, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 456, pid: -57, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 457, pid: -57, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 458, pid: -58, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 459, pid: -58, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 460, pid: -58, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 461, pid: -58, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 462, pid: -58, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 463, pid: -58, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 464, pid: -58, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 465, pid: -59, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 466, pid: -59, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 467, pid: -59, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 468, pid: -59, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 469, pid: -59, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 470, pid: -59, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 471, pid: -60, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 472, pid: -60, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 473, pid: -60, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 474, pid: -60, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 475, pid: -60, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 476, pid: -60, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 477, pid: -60, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 478, pid: -61, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 479, pid: -61, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 480, pid: -61, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 481, pid: -61, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 482, pid: -61, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 483, pid: -61, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 484, pid: -62, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 485, pid: -62, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 486, pid: -62, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 487, pid: -62, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 488, pid: -62, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 489, pid: -62, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 490, pid: -62, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 491, pid: -63, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 492, pid: -63, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 493, pid: -63, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 494, pid: -63, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 495, pid: -63, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 496, pid: -63, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 497, pid: -64, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 498, pid: -64, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 499, pid: -64, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 500, pid: -64, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 501, pid: -64, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 502, pid: -64, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 503, pid: -64, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 504, pid: -65, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 505, pid: -65, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 506, pid: -65, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 507, pid: -65, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 508, pid: -65, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 509, pid: -65, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 510, pid: -66, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 511, pid: -66, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 512, pid: -66, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 513, pid: -66, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 514, pid: -66, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 515, pid: -66, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 516, pid: -66, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 517, pid: -67, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 518, pid: -67, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 519, pid: -67, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 520, pid: -67, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 521, pid: -67, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 522, pid: -67, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 523, pid: -68, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 524, pid: -68, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 525, pid: -68, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 526, pid: -68, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 527, pid: -68, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 528, pid: -68, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 529, pid: -68, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 530, pid: -69, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 531, pid: -69, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 532, pid: -69, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 533, pid: -69, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 534, pid: -69, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 535, pid: -69, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 536, pid: -70, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 537, pid: -70, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 538, pid: -70, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 539, pid: -70, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 540, pid: -70, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 541, pid: -70, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 542, pid: -70, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 543, pid: -71, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 544, pid: -71, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 545, pid: -71, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 546, pid: -71, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 547, pid: -71, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 548, pid: -71, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 549, pid: -72, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 550, pid: -72, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 551, pid: -72, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 552, pid: -72, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 553, pid: -72, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 554, pid: -72, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 555, pid: -72, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 556, pid: -73, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 557, pid: -73, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 558, pid: -73, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 559, pid: -73, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 560, pid: -73, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 561, pid: -73, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 562, pid: -74, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 563, pid: -74, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 564, pid: -74, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 565, pid: -74, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 566, pid: -74, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 567, pid: -74, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 568, pid: -74, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 569, pid: -75, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 570, pid: -75, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 571, pid: -75, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 572, pid: -75, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 573, pid: -75, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 574, pid: -75, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 575, pid: -76, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 576, pid: -76, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 577, pid: -76, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 578, pid: -76, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 579, pid: -76, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 580, pid: -76, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 581, pid: -76, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 582, pid: -77, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 583, pid: -77, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 584, pid: -77, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 585, pid: -77, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 586, pid: -77, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 587, pid: -77, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 588, pid: -78, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 589, pid: -78, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 590, pid: -78, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 591, pid: -78, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 592, pid: -78, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 593, pid: -78, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 594, pid: -78, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Surface Water */


                    /* Greywater / Sewage Child Nodes */
                    {id: 595, pid: -79, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 596, pid: -79, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 597, pid: -79, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 598, pid: -79, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 599, pid: -79, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 600, pid: -79, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 601, pid: -80, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 602, pid: -80, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 603, pid: -80, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 604, pid: -80, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 605, pid: -80, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 606, pid: -80, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 607, pid: -80, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 608, pid: -81, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 609, pid: -81, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 610, pid: -81, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 611, pid: -81, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 612, pid: -81, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 613, pid: -81, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 615, pid: -82, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 616, pid: -82, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 617, pid: -82, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 618, pid: -82, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 619, pid: -82, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 620, pid: -82, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 621, pid: -82, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 622, pid: -83, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 623, pid: -83, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 624, pid: -83, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 625, pid: -83, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 626, pid: -83, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 627, pid: -83, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 628, pid: -84, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 629, pid: -84, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 630, pid: -84, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 631, pid: -84, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 632, pid: -84, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 633, pid: -84, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 634, pid: -84, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 635, pid: -85, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 636, pid: -85, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 637, pid: -85, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 638, pid: -85, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 639, pid: -85, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 640, pid: -85, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 641, pid: -86, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 642, pid: -86, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 643, pid: -86, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 644, pid: -86, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 645, pid: -86, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 646, pid: -86, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 647, pid: -86, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 648, pid: -87, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 649, pid: -87, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 650, pid: -87, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 651, pid: -87, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 652, pid: -87, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 653, pid: -87, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 654, pid: -88, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 655, pid: -88, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 656, pid: -88, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 657, pid: -88, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 658, pid: -88, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 659, pid: -88, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 660, pid: -88, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 661, pid: -89, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 662, pid: -89, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 663, pid: -89, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 664, pid: -89, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 665, pid: -89, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 666, pid: -89, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 667, pid: -90, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 668, pid: -90, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 669, pid: -90, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 670, pid: -90, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 671, pid: -90, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 672, pid: -90, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 673, pid: -90, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 674, pid: -91, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 675, pid: -91, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 676, pid: -91, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 677, pid: -91, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 678, pid: -91, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 679, pid: -91, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 680, pid: -92, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 681, pid: -92, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 682, pid: -92, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 683, pid: -92, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 684, pid: -92, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 685, pid: -92, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 686, pid: -92, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 687, pid: -93, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 688, pid: -93, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 689, pid: -93, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 690, pid: -93, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 691, pid: -93, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 692, pid: -93, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 693, pid: -94, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 694, pid: -94, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 695, pid: -94, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 696, pid: -94, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 697, pid: -94, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 698, pid: -94, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 699, pid: -94, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 700, pid: -95, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 701, pid: -95, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 702, pid: -95, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 703, pid: -95, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 704, pid: -95, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 705, pid: -95, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 706, pid: -96, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 707, pid: -96, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 708, pid: -96, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 709, pid: -96, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 710, pid: -96, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 711, pid: -96, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 712, pid: -96, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 713, pid: -97, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 714, pid: -97, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 715, pid: -97, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 716, pid: -97, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 717, pid: -97, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 718, pid: -97, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 719, pid: -98, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 720, pid: -98, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 721, pid: -98, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 722, pid: -98, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 723, pid: -98, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 724, pid: -98, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 725, pid: -98, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 726, pid: -99, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 727, pid: -99, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 728, pid: -99, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 729, pid: -99, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 730, pid: -99, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 731, pid: -99, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 732, pid: -100, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 733, pid: -100, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 734, pid: -100, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 735, pid: -100, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 736, pid: -100, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 737, pid: -100, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 738, pid: -100, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 739, pid: -101, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 740, pid: -101, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 741, pid: -101, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 742, pid: -101, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 743, pid: -101, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 744, pid: -101, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 745, pid: -102, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 746, pid: -102, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 747, pid: -102, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 748, pid: -102, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 749, pid: -102, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 750, pid: -102, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 751, pid: -102, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 752, pid: -103, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 753, pid: -103, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 754, pid: -103, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 755, pid: -103, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 756, pid: -103, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 757, pid: -103, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 758, pid: -104, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 759, pid: -104, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 760, pid: -104, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 761, pid: -104, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 762, pid: -104, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 763, pid: -104, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 764, pid: -104, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Shallow Ground Water */


                    /* Greywater / Sewage Child Nodes */
                    {id: 765, pid: -105, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 766, pid: -105, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 767, pid: -105, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 768, pid: -105, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 769, pid: -105, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 770, pid: -105, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 771, pid: -106, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 772, pid: -106, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 773, pid: -106, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 774, pid: -106, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 775, pid: -106, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 776, pid: -106, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 777, pid: -106, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 778, pid: -107, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 779, pid: -107, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 780, pid: -107, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 781, pid: -107, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 782, pid: -107, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 783, pid: -107, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 785, pid: -108, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 786, pid: -108, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 787, pid: -108, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 788, pid: -108, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 789, pid: -108, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 790, pid: -108, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 791, pid: -108, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 792, pid: -109, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 793, pid: -109, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 794, pid: -109, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 795, pid: -109, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 796, pid: -109, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 797, pid: -109, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 798, pid: -110, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 799, pid: -110, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 800, pid: -110, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 801, pid: -110, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 802, pid: -110, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 803, pid: -110, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 804, pid: -110, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 805, pid: -111, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 806, pid: -111, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 807, pid: -111, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 808, pid: -111, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 809, pid: -111, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 810, pid: -111, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 811, pid: -112, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 812, pid: -112, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 813, pid: -112, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 814, pid: -112, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 815, pid: -112, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 816, pid: -112, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 817, pid: -112, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 818, pid: -113, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 819, pid: -113, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 820, pid: -113, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 821, pid: -113, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 822, pid: -113, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 823, pid: -113, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 824, pid: -114, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 825, pid: -114, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 826, pid: -114, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 827, pid: -114, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 828, pid: -114, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 829, pid: -114, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 830, pid: -114, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 831, pid: -115, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 832, pid: -115, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 833, pid: -115, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 834, pid: -115, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 835, pid: -115, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 836, pid: -115, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 837, pid: -116, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 838, pid: -116, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 839, pid: -116, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 840, pid: -116, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 841, pid: -116, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 842, pid: -116, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 843, pid: -116, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 844, pid: -117, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 845, pid: -117, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 846, pid: -117, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 847, pid: -117, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 848, pid: -117, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 849, pid: -117, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 850, pid: -118, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 851, pid: -118, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 852, pid: -118, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 853, pid: -118, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 854, pid: -118, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 855, pid: -118, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 856, pid: -118, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 857, pid: -119, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 858, pid: -119, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 859, pid: -119, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 860, pid: -119, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 861, pid: -119, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 862, pid: -119, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 863, pid: -120, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 864, pid: -120, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 865, pid: -120, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 866, pid: -120, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 867, pid: -120, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 868, pid: -120, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 869, pid: -120, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 870, pid: -121, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 871, pid: -121, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 872, pid: -121, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 873, pid: -121, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 874, pid: -121, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 875, pid: -121, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 876, pid: -122, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 877, pid: -122, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 878, pid: -122, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 879, pid: -122, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 880, pid: -122, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 881, pid: -122, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 882, pid: -122, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 883, pid: -123, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 884, pid: -123, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 885, pid: -123, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 886, pid: -123, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 887, pid: -123, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 888, pid: -123, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 889, pid: -124, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 890, pid: -124, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 891, pid: -124, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 892, pid: -124, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 893, pid: -124, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 894, pid: -124, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 895, pid: -124, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 896, pid: -125, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 897, pid: -125, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 898, pid: -125, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 899, pid: -125, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 900, pid: -125, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 901, pid: -125, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 902, pid: -126, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 903, pid: -126, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 904, pid: -126, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 905, pid: -126, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 906, pid: -126, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 907, pid: -126, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 908, pid: -126, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 909, pid: -127, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 910, pid: -127, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 911, pid: -127, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 912, pid: -127, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 913, pid: -127, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 914, pid: -127, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 915, pid: -128, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 916, pid: -128, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 917, pid: -128, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 918, pid: -128, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 919, pid: -128, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 920, pid: -128, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 921, pid: -128, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 922, pid: -129, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 923, pid: -129, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 924, pid: -129, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 925, pid: -129, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 926, pid: -129, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 927, pid: -129, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 928, pid: -130, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 929, pid: -130, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 930, pid: -130, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 931, pid: -130, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 932, pid: -130, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 933, pid: -130, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 934, pid: -130, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Ground Water */


                    /* Greywater / Sewage Child Nodes */
                    {id: 935, pid: -131, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 936, pid: -131, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 937, pid: -131, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 938, pid: -131, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 939, pid: -131, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 940, pid: -131, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 941, pid: -132, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 942, pid: -132, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 943, pid: -132, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 944, pid: -132, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 945, pid: -132, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 946, pid: -132, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 947, pid: -132, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 948, pid: -133, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 949, pid: -133, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 950, pid: -133, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 951, pid: -133, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 952, pid: -133, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 953, pid: -133, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 955, pid: -134, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 956, pid: -134, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 957, pid: -134, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 958, pid: -134, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 959, pid: -134, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 960, pid: -134, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 961, pid: -134, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 962, pid: -135, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 963, pid: -135, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 964, pid: -135, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 965, pid: -135, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 966, pid: -135, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 967, pid: -135, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 968, pid: -136, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 969, pid: -136, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 970, pid: -136, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 971, pid: -136, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 972, pid: -136, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 973, pid: -136, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 974, pid: -136, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 975, pid: -137, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 976, pid: -137, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 977, pid: -137, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 978, pid: -137, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 979, pid: -137, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 980, pid: -137, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 981, pid: -138, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 982, pid: -138, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 983, pid: -138, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 984, pid: -138, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 985, pid: -138, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 986, pid: -138, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 987, pid: -138, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 988, pid: -139, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 989, pid: -139, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 990, pid: -139, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 991, pid: -139, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 992, pid: -139, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 993, pid: -139, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 994, pid: -140, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 995, pid: -140, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 996, pid: -140, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 997, pid: -140, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 998, pid: -140, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 999, pid: -140, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1000, pid: -140, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1001, pid: -141, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1002, pid: -141, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1003, pid: -141, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1004, pid: -141, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1005, pid: -141, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1006, pid: -141, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1007, pid: -142, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1008, pid: -142, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1009, pid: -142, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1010, pid: -142, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1011, pid: -142, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1012, pid: -142, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1013, pid: -142, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1014, pid: -143, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1015, pid: -143, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1016, pid: -143, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1017, pid: -143, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1018, pid: -143, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1019, pid: -143, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1020, pid: -144, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1021, pid: -144, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1022, pid: -144, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1023, pid: -144, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1024, pid: -144, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1025, pid: -144, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1026, pid: -144, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1027, pid: -145, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1028, pid: -145, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1029, pid: -145, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1030, pid: -145, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1031, pid: -145, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1032, pid: -145, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1033, pid: -146, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1034, pid: -146, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1035, pid: -146, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1036, pid: -146, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1037, pid: -146, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1038, pid: -146, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1039, pid: -146, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1040, pid: -147, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1041, pid: -147, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1042, pid: -147, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1043, pid: -147, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1044, pid: -147, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1045, pid: -147, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1046, pid: -148, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1047, pid: -148, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1048, pid: -148, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1049, pid: -148, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1050, pid: -148, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1051, pid: -148, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1052, pid: -148, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1053, pid: -149, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1054, pid: -149, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1055, pid: -149, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1056, pid: -149, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1057, pid: -149, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1058, pid: -149, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1059, pid: -150, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1060, pid: -150, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1061, pid: -150, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1062, pid: -150, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1063, pid: -150, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1064, pid: -150, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1065, pid: -150, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes  */
                    {id: 1066, pid: -151, Name: "Subsurface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 1067, pid: -151, Name: "Surface Irrigation", Source: "Greywater ", Links: "", img: ""},
                    {id: 1068, pid: -151, Name: "Injection Well", Source: "Greywater ", Links: "", img: ""},
                    {id: 1069, pid: -151, Name: "Bioswale", Source: "Greywater ", Links: "", img: ""},
                    {id: 1070, pid: -151, Name: "Agriculture (Non-Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 1071, pid: -151, Name: "Agriculture (Food)", Source: "Greywater ", Links: "", img: ""},
                    {id: 1072, pid: -152, Name: "Subsurface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 1073, pid: -152, Name: "Surface Irrigation", Source: "Sewage ", Links: "", img: ""},
                    {id: 1074, pid: -152, Name: "Injection Well", Source: "Sewage ", Links: "", img: ""},
                    {id: 1075, pid: -152, Name: "Bioswale", Source: "Sewage ", Links: "", img: ""},
                    {id: 1076, pid: -152, Name: "Agriculture (Non-Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 1077, pid: -152, Name: "Agriculture (Food)", Source: "Sewage ", Links: "", img: ""},
                    {id: 1078, pid: -152, Name: "Water Treatment Facility", Source: "Sewage ", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1079, pid: -153, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1080, pid: -153, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1081, pid: -153, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1082, pid: -153, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1083, pid: -153, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1084, pid: -153, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1085, pid: -154, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1086, pid: -154, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1087, pid: -154, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1088, pid: -154, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1089, pid: -154, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1090, pid: -154, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1091, pid: -154, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""},

                    /* Greywater / Sewage Child Nodes */
                    {id: 1092, pid: -155, Name: "Subsurface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1093, pid: -155, Name: "Surface Irrigation", Source: "Greywater", Links: "", img: ""},
                    {id: 1094, pid: -155, Name: "Injection Well", Source: "Greywater", Links: "", img: ""},
                    {id: 1095, pid: -155, Name: "Bioswale", Source: "Greywater", Links: "", img: ""},
                    {id: 1096, pid: -155, Name: "Agriculture (Non-Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1097, pid: -155, Name: "Agriculture (Food)", Source: "Greywater", Links: "", img: ""},
                    {id: 1098, pid: -156, Name: "Subsurface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1099, pid: -156, Name: "Surface Irrigation", Source: "Sewage", Links: "", img: ""},
                    {id: 1100, pid: -156, Name: "Injection Well", Source: "Sewage", Links: "", img: ""},
                    {id: 1101, pid: -156, Name: "Bioswale", Source: "Sewage", Links: "", img: ""},
                    {id: 1102, pid: -156, Name: "Agriculture (Non-Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1103, pid: -156, Name: "Agriculture (Food)", Source: "Sewage", Links: "", img: ""},
                    {id: 1104, pid: -156, Name: "Water Treatment Facility", Source: "Sewage", Links: "", img: ""}

                ]

                for (var i = 0; i < nodes.length; i++) {
                    var node = nodes[i];
                    switch (node.Name) {
                        case "Greywater":
                            node.tags = ["Greywater"];
                            break;
                        case "Sewage":
                            node.tags = ["Sewage"];
                            break;
                    }
                }

                /* Variables for the state, county, city allowed and blocked reuse nodes */
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
                for(var i = 7; i < nodes.length; i++) {
                    if(nodes[i].pid === 1) {
                        for(var j = 0; j < condensateNotAllowedNodes.length; j++) {
                            if(nodes[i].Name === condensateNotAllowedNodes[j]) {
                                nodes[i].tags = ['PathwayBlocked']
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
                        },
                        Greywater: {
                            template: "greywater"
                        },
                        Sewage: {
                            template: "sewage"
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

                    var stateCodeLinks = null;
                    var statePermitLinks = null;
                    var stateIncentivesLinks = null;
                    var stateInfoLinks = null;
                    var countyCodeLinks = null;
                    var countyPermitLinks = null;
                    var countyIncentivesLinks = null;
                    var countyInfoLinks = null;
                    var cityCodeLinks = null;
                    var cityPermitLinks = null;
                    var cityIncentivesLinks = null;
                    var cityInfoLinks = null;
                    let stateRuleIndex = null;
                    let countyRuleIndex = null;
                    let cityRuleIndex = null;

                    // State Links
                    for(var i = 0; i < nodes.length; i++) {
                        if(sender.node.id == nodes[i].id) {
                            for(var j = 0; j < stateRules.length; j++) {
                                if(stateRules[j].source.node_name == nodes[i].Source && stateRules[j].destination.node_name == nodes[i].Name) {
                                    stateRuleIndex = j;
                                    if(stateRules[j].codes_obj) {
                                        stateCodeLinks = stateRules[j].codes_obj.linkText;
                                    }
                                    if(stateRules[j].permit_obj) {
                                        statePermitLinks = stateRules[j].permit_obj.linkText;
                                    }
                                    if(stateRules[j].incentives_obj) {
                                        stateIncentivesLinks = stateRules[j].incentives_obj.linkText;
                                    }
                                    if(stateRules[j].more_info_obj) {
                                        stateInfoLinks = stateRules[j].more_info_obj.linkText;
                                    }
                                }
                            }
                        }
                    }
                    // County Links
                    for(var i = 0; i < nodes.length; i++) {
                        if(sender.node.id == nodes[i].id) {
                            for(var j = 0; j < countyRules.length; j++) {
                                if(countyRules[j].source.node_name == nodes[i].Source && countyRules[j].destination.node_name == nodes[i].Name) {
                                    countyRuleIndex = j;
                                    if(countyRules[j].codes_obj) {
                                        countyCodeLinks = countyRules[j].codes_obj.linkText;
                                    }
                                    if(countyRules[j].permit_obj) {
                                        countyPermitLinks = countyRules[j].permit_obj.linkText;
                                    }
                                    if(countyRules[j].incentives_obj) {
                                        countyIncentivesLinks = countyRules[j].incentives_obj.linkText;
                                    }
                                    if(countyRules[j].more_info_obj) {
                                        countyInfoLinks = countyRules[j].more_info_obj.linkText;
                                    }
                                }
                            }
                        }
                    }
                    // City Links
                    for(var i = 0; i < nodes.length; i++) {
                        if(sender.node.id == nodes[i].id) {
                            for(var j = 0; j < cityRules.length; j++) {
                                if(cityRules[j].source.node_name == nodes[i].Source && cityRules[j].destination.node_name == nodes[i].Name) {
                                    cityRuleIndex = j;
                                    if(cityRules[j].codes_obj) {
                                        cityCodeLinks = cityRules[j].codes_obj.linkText;
                                    }
                                    if(cityRules[j].permit_obj) {
                                        cityPermitLinks = cityRules[j].permit_obj.linkText;
                                    }
                                    if(cityRules[j].incentives_obj) {
                                        cityIncentivesLinks = cityRules[j].incentives_obj.linkText;
                                    }
                                    if(cityRules[j].more_info_obj) {
                                        cityInfoLinks = cityRules[j].more_info_obj.linkText;
                                    }
                                }
                            }
                        }
                    }

                    if (args.type == 'details' && args.name == 'Links'){

                        var txt = args.field.querySelector('input');
                        if (txt){

                            var parent = args.field.querySelector('div');
                            var br = document.createElement("br");
                            parent.appendChild(br);

                            var card = document.createElement('a')
                            card.className ="card";
                            parent.appendChild(card)
                            card.style.cssText = "margin:6px 0 0 0;";

                            var h1 = document.createElement('btn');  //card 1 head
                            var linkText = document.createTextNode("City");
                            h1.appendChild(linkText);
                            h1.className = "card btn";
                            h1.style.cssText = "text-align:center;";
                            h1.title = "city";
                            h1.type = "button";
                            h1.id = "heading";
                            card.appendChild(h1);

                            h1.addEventListener('click',function(){
                                if(b1.style.display === "none"){
                                    b1.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;";
                                    b2.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                    b3.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                                else{
                                    b1.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                            })

                            var b1= document.createElement('a'); //card 1 body
                            b1.className = "card body";
                            b1.id =  "body";
                            b1.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                            b1.target = "_blank";
                            card.appendChild(b1)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Code")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (cityCodeLinks == null || cityCodeLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = cityCodeLinks;
                            }
                            a.target = "_blank";
                            b1.appendChild(a);

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Permit")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Permit";
                            if (cityPermitLinks == null || cityPermitLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = cityPermitLinks;
                            }
                            a.target = "_blank";
                            b1.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Incentive")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Incentive";
                            if (cityIncentivesLinks == null || cityIncentivesLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = cityIncentivesLinks;
                            }
                            a.target = "_blank";
                            b1.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("More Info")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "More Info";
                            if (cityInfoLinks == null || cityInfoLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = cityInfoLinks;
                            }
                            a.target = "_blank";
                            b1.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("View")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (cityRuleIndex == null){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                var url = "{{ route('viewSubmission', [":type", ":state", ":itemId", "back" => url()->full()]) }}"
                                url = url.replace(':type', "city");
                                if(cityRules[cityRuleIndex].city.is_approved == true) {
                                    url = url.replace(':state', "approved");
                                }
                                url = url.replace(':itemId', cityRules[cityRuleIndex].id);
                                a.href = url;
                            }
                            a.target = "_blank";
                            b1.appendChild(a);

                            //county
                            var card = document.createElement('a')
                            card.className ="card";
                            parent.appendChild(card)

                            var h2 = document.createElement('btn'); //card 2 head
                            var linkText = document.createTextNode("County");
                            h2.appendChild(linkText);
                            h2.className = "card btn";
                            h2.style.cssText = "text-align:center;";
                            h2.title = "county";
                            h2.id = "heading";
                            card.appendChild(h2);

                            h2.addEventListener('click',function(){
                                if(b2.style.display === "none"){
                                    b2.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;";
                                    b1.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                    b3.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                                else{
                                    b2.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                            })

                            var b2= document.createElement('a'); // card 2 body
                            b2.className = "card body";
                            b2.id = "body";
                            b2.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                            b2.target = "_blank";
                            card.appendChild(b2)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Code")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (countyCodeLinks == null || countyCodeLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = countyCodeLinks;
                            }
                            a.target = "_blank";
                            b2.appendChild(a);

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Permit")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Permit";
                            if (countyPermitLinks == null || countyPermitLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = countyPermitLinks;
                            }
                            a.target = "_blank";
                            b2.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Incentive")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Incentive";
                            if (countyIncentivesLinks == null || countyIncentivesLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = countyIncentivesLinks;
                            }
                            a.target = "_blank";
                            b2.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("More Info")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "More Info";
                            if (countyInfoLinks == null || countyInfoLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = countyInfoLinks;
                            }
                            a.target = "_blank";
                            b2.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("View")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (countyRuleIndex == null){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                var url = "{{ route('viewSubmission', [":type", ":state", ":itemId", "back" => url()->full()]) }}"
                                url = url.replace(':type', "county");
                                if(countyRules[countyRuleIndex].county.is_approved == true) {
                                    url = url.replace(':state', "approved");
                                }
                                url = url.replace(':itemId', countyRules[countyRuleIndex].id);
                                a.href = url;
                            }
                            a.target = "_blank";
                            b2.appendChild(a);

                            //state
                            var card = document.createElement('a')
                            card.className ="card";
                            parent.appendChild(card)
                            card.style.cssText = "margin:0 0 6px 0;";

                            var h3 = document.createElement('btn'); //card 3 head
                            var linkText = document.createTextNode("State");
                            h3.appendChild(linkText);
                            h3.className = "card btn";
                            h3.style.cssText = "text-align:center;";
                            h3.id = "heading";
                            h3.title = "state";
                            card.appendChild(h3);

                            h3.addEventListener('click',function(){
                                if(b3.style.display === "none"){
                                    b3.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;";
                                    b1.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                    b2.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                                else{
                                    b3.style.cssText = "text-align:center;border:none;float:left;display:inline; margin: 10px 0;display:none";
                                }
                            })

                            var b3= document.createElement('a');  //card 3 body
                            b3.className = "card body";
                            b3.id = "body";
                            b3.style.cssText = "text-align:center;border:none;float:left;display:inline;margin: 10px 0; display:none;";
                            b3.target = "_blank";
                            card.appendChild(b3)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Code")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (stateCodeLinks == null || stateCodeLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = stateCodeLinks;
                            }
                            a.target = "_blank";
                            b3.appendChild(a);

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Permit")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Permit";
                            if (statePermitLinks == null || statePermitLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = statePermitLinks;
                            }
                            a.target = "_blank";
                            b3.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("Incentive")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Incentive";
                            if (stateIncentivesLinks == null || stateIncentivesLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = stateIncentivesLinks;
                            }
                            a.target = "_blank";
                            b3.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("More Info")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "More Info";
                            if (stateInfoLinks == null || stateInfoLinks == ""){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                a.href = stateInfoLinks;
                            }
                            a.target = "_blank";
                            b3.appendChild(a)

                            var a = document.createElement('a');
                            var linkText = document.createTextNode("View")
                            a.appendChild(linkText);
                            a.className = "btn btn-primary";
                            a.style.cssText = "margin: 15px 6px 0 6px;";
                            a.title = "Code";
                            if (stateRuleIndex == null){
                                a.className = "btn btn-primary disabled";
                            }
                            else{
                                var url = "{{ route('viewSubmission', [":type", ":state", ":itemId", "back" => url()->full()]) }}"
                                url = url.replace(':type', "state");
                                if(stateRules[stateRuleIndex].state.is_approved == true) {
                                    url = url.replace(':state', "approved");
                                }
                                url = url.replace(':itemId', stateRules[stateRuleIndex].id);
                                a.href = url;
                            }
                            a.target = "_blank";
                            b3.appendChild(a);

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
