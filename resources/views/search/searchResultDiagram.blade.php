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

                    /* Water Facility Child Nodes ( None ) */

                    /*

                    Greywater & Sewage Parent Nodes (Children of Reuse Option Nodes)
                        Note: id's are in negative since they aren't full node options (just parent section holders)
                    */

                    /* Greywater & Sewage Parent Nodes ~ Condensate */
                    {id: -1, pid: 8, Name: "Greywater", Source: "Kitchen Sink ~ Condensate", Links: "", img: ""},
                    {id: -2, pid: 8, Name: "Sewage", Source: "Kitchen Sink ~ Condensate", Links: "", img: ""},
                    {id: -3, pid: 9, Name: "Greywater", Source: "Food Disposer ~ Condensate", Links: "", img: ""},
                    {id: -4, pid: 9, Name: "Sewage", Source: "Food Disposer ~ Condensate", Links: "", img: ""},
                    {id: -5, pid: 10, Name: "Greywater", Source: "Dishwasher ~ Condensate", Links: "", img: ""},
                    {id: -6, pid: 10, Name: "Sewage", Source: "Dishwasher ~ Condensate", Links: "", img: ""},
                    {id: -7, pid: 11, Name: "Greywater", Source: "Lavatory ~ Condensate", Links: "", img: ""},
                    {id: -8, pid: 11, Name: "Sewage", Source: "Lavatory ~ Condensate", Links: "", img: ""},
                    {id: -9, pid: 12, Name: "Greywater", Source: "Tub & Shower ~ Condensate", Links: "", img: ""},
                    {id: -10, pid: 12, Name: "Sewage", Source: "Tub & Shower ~ Condensate", Links: "", img: ""},
                    {id: -11, pid: 13, Name: "Greywater", Source: "Fire Suppression ~ Condensate", Links: "", img: ""},
                    {id: -12, pid: 13, Name: "Sewage", Source: "Fire Suppression ~ Condensate", Links: "", img: ""},
                    {id: -13, pid: 14, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Condensate", Links: "", img: ""},
                    {id: -14, pid: 14, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Condensate", Links: "", img: ""},
                    {id: -15, pid: 15, Name: "Greywater", Source: "Clothes Washer ~ Condensate", Links: "", img: ""},
                    {id: -16, pid: 15, Name: "Sewage", Source: "Clothes Washer ~ Condensate", Links: "", img: ""},
                    {id: -17, pid: 16, Name: "Greywater", Source: "Toilet ~ Condensate", Links: "", img: ""},
                    {id: -18, pid: 16, Name: "Sewage", Source: "Toilet ~ Condensate", Links: "", img: ""},
                    {id: -19, pid: 17, Name: "Greywater", Source: "Toilet (Composting) ~ Condensate", Links: "", img: ""},
                    {id: -20, pid: 17, Name: "Sewage", Source: "Toilet (Composting) ~ Condensate", Links: "", img: ""},
                    {id: -21, pid: 18, Name: "Greywater", Source: "Toilet (Source Separated) ~ Condensate", Links: "", img: ""},
                    {id: -22, pid: 18, Name: "Sewage", Source: "Toilet (Source Separated) ~ Condensate", Links: "", img: ""},
                    {id: -23, pid: 19, Name: "Greywater", Source: "Urinal ~ Condensate", Links: "", img: ""},
                    {id: -24, pid: 19, Name: "Sewage", Source: "Urinal ~ Condensate", Links: "", img: ""},
                    {id: -25, pid: 20, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Condensate", Links: "", img: ""},
                    {id: -26, pid: 20, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Condensate", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Precipitation */
                    {id: -27, pid: 21, Name: "Greywater", Source: "Kitchen Sink ~ Precipitation", Links: "", img: ""},
                    {id: -28, pid: 21, Name: "Sewage", Source: "Kitchen Sink ~ Precipitation", Links: "", img: ""},
                    {id: -29, pid: 22, Name: "Greywater", Source: "Food Disposer ~ Precipitation", Links: "", img: ""},
                    {id: -30, pid: 22, Name: "Sewage", Source: "Food Disposer ~ Precipitation", Links: "", img: ""},
                    {id: -31, pid: 23, Name: "Greywater", Source: "Dishwasher ~ Precipitation", Links: "", img: ""},
                    {id: -32, pid: 23, Name: "Sewage", Source: "Dishwasher ~ Precipitation", Links: "", img: ""},
                    {id: -33, pid: 24, Name: "Greywater", Source: "Lavatory ~ Precipitation", Links: "", img: ""},
                    {id: -34, pid: 24, Name: "Sewage", Source: "Lavatory ~ Precipitation", Links: "", img: ""},
                    {id: -35, pid: 25, Name: "Greywater", Source: "Tub & Shower ~ Precipitation", Links: "", img: ""},
                    {id: -36, pid: 25, Name: "Sewage", Source: "Tub & Shower ~ Precipitation", Links: "", img: ""},
                    {id: -37, pid: 26, Name: "Greywater", Source: "Fire Suppression ~ Precipitation", Links: "", img: ""},
                    {id: -38, pid: 26, Name: "Sewage", Source: "Fire Suppression ~ Precipitation", Links: "", img: ""},
                    {id: -39, pid: 27, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Precipitation", Links: "", img: ""},
                    {id: -40, pid: 27, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Precipitation", Links: "", img: ""},
                    {id: -41, pid: 28, Name: "Greywater", Source: "Clothes Washer ~ Precipitation", Links: "", img: ""},
                    {id: -42, pid: 28, Name: "Sewage", Source: "Clothes Washer ~ Precipitation", Links: "", img: ""},
                    {id: -43, pid: 29, Name: "Greywater", Source: "Toilet ~ Precipitation", Links: "", img: ""},
                    {id: -44, pid: 29, Name: "Sewage", Source: "Toilet ~ Precipitation", Links: "", img: ""},
                    {id: -45, pid: 30, Name: "Greywater", Source: "Toilet (Composting) ~ Precipitation", Links: "", img: ""},
                    {id: -46, pid: 30, Name: "Sewage", Source: "Toilet (Composting) ~ Precipitation", Links: "", img: ""},
                    {id: -47, pid: 31, Name: "Greywater", Source: "Toilet (Source Separated) ~ Precipitation", Links: "", img: ""},
                    {id: -48, pid: 31, Name: "Sewage", Source: "Toilet (Source Separated) ~ Precipitation", Links: "", img: ""},
                    {id: -49, pid: 32, Name: "Greywater", Source: "Urinal ~ Precipitation", Links: "", img: ""},
                    {id: -50, pid: 32, Name: "Sewage", Source: "Urinal ~ Precipitation", Links: "", img: ""},
                    {id: -51, pid: 33, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Precipitation", Links: "", img: ""},
                    {id: -52, pid: 33, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Precipitation", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Stormwater Runoff */
                    {id: -53, pid: 34, Name: "Greywater", Source: "Kitchen Sink ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -54, pid: 34, Name: "Sewage", Source: "Kitchen Sink ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -55, pid: 35, Name: "Greywater", Source: "Food Disposer ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -56, pid: 35, Name: "Sewage", Source: "Food Disposer ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -57, pid: 36, Name: "Greywater", Source: "Dishwasher ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -58, pid: 36, Name: "Sewage", Source: "Dishwasher ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -59, pid: 37, Name: "Greywater", Source: "Lavatory ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -60, pid: 37, Name: "Sewage", Source: "Lavatory ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -61, pid: 38, Name: "Greywater", Source: "Tub & Shower ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -62, pid: 38, Name: "Sewage", Source: "Tub & Shower ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -63, pid: 39, Name: "Greywater", Source: "Fire Suppression ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -64, pid: 39, Name: "Sewage", Source: "Fire Suppression ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -65, pid: 40, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -66, pid: 40, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -67, pid: 41, Name: "Greywater", Source: "Clothes Washer ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -68, pid: 41, Name: "Sewage", Source: "Clothes Washer ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -69, pid: 42, Name: "Greywater", Source: "Toilet ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -70, pid: 42, Name: "Sewage", Source: "Toilet ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -71, pid: 43, Name: "Greywater", Source: "Toilet (Composting) ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -72, pid: 43, Name: "Sewage", Source: "Toilet (Composting) ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -73, pid: 44, Name: "Greywater", Source: "Toilet (Source Separated) ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -74, pid: 44, Name: "Sewage", Source: "Toilet (Source Separated) ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -75, pid: 45, Name: "Greywater", Source: "Urinal ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -76, pid: 45, Name: "Sewage", Source: "Urinal ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -77, pid: 46, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Stormwater Runoff", Links: "", img: ""},
                    {id: -78, pid: 46, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Stormwater Runoff", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Surface Water */
                    {id: -79, pid: 47, Name: "Greywater", Source: "Kitchen Sink ~ Surface Water", Links: "", img: ""},
                    {id: -80, pid: 47, Name: "Sewage", Source: "Kitchen Sink ~ Surface Water", Links: "", img: ""},
                    {id: -81, pid: 48, Name: "Greywater", Source: "Food Disposer ~ Surface Water", Links: "", img: ""},
                    {id: -82, pid: 48, Name: "Sewage", Source: "Food Disposer ~ Surface Water", Links: "", img: ""},
                    {id: -83, pid: 49, Name: "Greywater", Source: "Dishwasher ~ Surface Water", Links: "", img: ""},
                    {id: -84, pid: 49, Name: "Sewage", Source: "Dishwasher ~ Surface Water", Links: "", img: ""},
                    {id: -85, pid: 50, Name: "Greywater", Source: "Lavatory ~ Surface Water", Links: "", img: ""},
                    {id: -86, pid: 50, Name: "Sewage", Source: "Lavatory ~ Surface Water", Links: "", img: ""},
                    {id: -87, pid: 51, Name: "Greywater", Source: "Tub & Shower ~ Surface Water", Links: "", img: ""},
                    {id: -88, pid: 51, Name: "Sewage", Source: "Tub & Shower ~ Surface Water", Links: "", img: ""},
                    {id: -89, pid: 52, Name: "Greywater", Source: "Fire Suppression ~ Surface Water", Links: "", img: ""},
                    {id: -90, pid: 52, Name: "Sewage", Source: "Fire Suppression ~ Surface Water", Links: "", img: ""},
                    {id: -91, pid: 53, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Surface Water", Links: "", img: ""},
                    {id: -92, pid: 53, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Surface Water", Links: "", img: ""},
                    {id: -93, pid: 54, Name: "Greywater", Source: "Clothes Washer ~ Surface Water", Links: "", img: ""},
                    {id: -94, pid: 54, Name: "Sewage", Source: "Clothes Washer ~ Surface Water", Links: "", img: ""},
                    {id: -95, pid: 55, Name: "Greywater", Source: "Toilet ~ Surface Water", Links: "", img: ""},
                    {id: -96, pid: 55, Name: "Sewage", Source: "Toilet ~ Surface Water", Links: "", img: ""},
                    {id: -97, pid: 56, Name: "Greywater", Source: "Toilet (Composting) ~ Surface Water", Links: "", img: ""},
                    {id: -98, pid: 56, Name: "Sewage", Source: "Toilet (Composting) ~ Surface Water", Links: "", img: ""},
                    {id: -99, pid: 57, Name: "Greywater", Source: "Toilet (Source Separated) ~ Surface Water", Links: "", img: ""},
                    {id: -100, pid: 57, Name: "Sewage", Source: "Toilet (Source Separated) ~ Surface Water", Links: "", img: ""},
                    {id: -101, pid: 58, Name: "Greywater", Source: "Urinal ~ Surface Water", Links: "", img: ""},
                    {id: -102, pid: 58, Name: "Sewage", Source: "Urinal ~ Surface Water", Links: "", img: ""},
                    {id: -103, pid: 59, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Surface Water", Links: "", img: ""},
                    {id: -104, pid: 59, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Surface Water", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Shallow Groundwater */
                    {id: -105, pid: 60, Name: "Greywater", Source: "Kitchen Sink ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -106, pid: 60, Name: "Sewage", Source: "Kitchen Sink ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -107, pid: 61, Name: "Greywater", Source: "Food Disposer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -108, pid: 61, Name: "Sewage", Source: "Food Disposer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -109, pid: 62, Name: "Greywater", Source: "Dishwasher ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -110, pid: 62, Name: "Sewage", Source: "Dishwasher ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -111, pid: 63, Name: "Greywater", Source: "Lavatory ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -112, pid: 63, Name: "Sewage", Source: "Lavatory ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -113, pid: 64, Name: "Greywater", Source: "Tub & Shower ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -114, pid: 64, Name: "Sewage", Source: "Tub & Shower ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -115, pid: 65, Name: "Greywater", Source: "Fire Suppression ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -116, pid: 65, Name: "Sewage", Source: "Fire Suppression ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -117, pid: 66, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -118, pid: 66, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -119, pid: 67, Name: "Greywater", Source: "Clothes Washer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -120, pid: 67, Name: "Sewage", Source: "Clothes Washer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -121, pid: 68, Name: "Greywater", Source: "Toilet ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -122, pid: 68, Name: "Sewage", Source: "Toilet ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -123, pid: 69, Name: "Greywater", Source: "Toilet (Composting) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -124, pid: 69, Name: "Sewage", Source: "Toilet (Composting) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -125, pid: 70, Name: "Greywater", Source: "Toilet (Source Separated) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -126, pid: 70, Name: "Sewage", Source: "Toilet (Source Separated) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -127, pid: 71, Name: "Greywater", Source: "Urinal ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -128, pid: 71, Name: "Sewage", Source: "Urinal ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -129, pid: 72, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -130, pid: 72, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Shallow Groundwater", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Ground Water */
                    {id: -131, pid: 73, Name: "Greywater", Source: "Kitchen Sink ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -132, pid: 73, Name: "Sewage", Source: "Kitchen Sink ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -133, pid: 74, Name: "Greywater", Source: "Food Disposer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -134, pid: 74, Name: "Sewage", Source: "Food Disposer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -135, pid: 75, Name: "Greywater", Source: "Dishwasher ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -136, pid: 75, Name: "Sewage", Source: "Dishwasher ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -137, pid: 76, Name: "Greywater", Source: "Lavatory ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -138, pid: 76, Name: "Sewage", Source: "Lavatory ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -139, pid: 77, Name: "Greywater", Source: "Tub & Shower ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -140, pid: 77, Name: "Sewage", Source: "Tub & Shower ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -141, pid: 78, Name: "Greywater", Source: "Fire Suppression ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -142, pid: 78, Name: "Sewage", Source: "Fire Suppression ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -143, pid: 79, Name: "Greywater", Source: "Mechanical Cooling / P-Trap Prime ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -144, pid: 79, Name: "Sewage", Source: "Mechanical Cooling / P-Trap Prime ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -145, pid: 80, Name: "Greywater", Source: "Clothes Washer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -146, pid: 80, Name: "Sewage", Source: "Clothes Washer ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -147, pid: 81, Name: "Greywater", Source: "Toilet ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -148, pid: 81, Name: "Sewage", Source: "Toilet ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -149, pid: 82, Name: "Greywater", Source: "Toilet (Composting) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -150, pid: 82, Name: "Sewage", Source: "Toilet (Composting) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -151, pid: 83, Name: "Greywater", Source: "Toilet (Source Separated) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -152, pid: 83, Name: "Sewage", Source: "Toilet (Source Separated) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -153, pid: 84, Name: "Greywater", Source: "Urinal ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -154, pid: 84, Name: "Sewage", Source: "Urinal ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -155, pid: 85, Name: "Greywater", Source: "Urinal (Waterless / Diverted) ~ Shallow Groundwater", Links: "", img: ""},
                    {id: -156, pid: 85, Name: "Sewage", Source: "Urinal (Waterless / Diverted) ~ Shallow Groundwater", Links: "", img: ""},

                    /* Greywater & Sewage Parent Nodes ~ Water Facility ( None ) */


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
