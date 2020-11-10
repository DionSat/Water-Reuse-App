<div class="card mb-3">
    <div class="card-body">
        <div class="legend-content">
            <div>
                <div style="background-color:#039be5;"></div>  Pathway Allowed
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
            icons[7].src = "{{ asset('img/dispose_waterTreamentFacility.jpg') }}";
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
            icons[17] = new Image();
            icons[17].src = "{{ URL::asset('img/dispose_subsurface-Irrigation.jpg') }}";
            icons[18] = new Image();
            icons[18].src = "{{ URL::asset('img/dispose_surface-Irrigation.jpg') }}";
            icons[19] = new Image();
            icons[19].src = "{{ URL::asset('img/dispose_injectionWell.jpg') }}";
            icons[20] = new Image();
            icons[20].src = "{{ URL::asset('img/dispose_bioswale.jpg') }}";
            icons[21] = new Image();
            icons[21].src = "{{ URL::asset('img/dispose_agriculture(noFood).jpg') }}";
            icons[22] = new Image();
            icons[22].src = "{{ URL::asset('img/dispose_agriculture(food).jpg') }}";
            icons[23] = new Image();
            icons[23].src = "{{ URL::asset('img/dispose_waterTreamentFacility.jpg') }}";

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

                /* Greywater / Sewage / Water Sources Custom Nodes */
                OrgChart.templates.greywater = Object.assign({}, OrgChart.templates.ana);
                OrgChart.templates.greywater.node = '<rect x="0" y="0" height="125" width="255" rx="40px" fill="#9a9a9a"></rect>';
                OrgChart.templates.sewage = Object.assign({}, OrgChart.templates.ana);
                OrgChart.templates.sewage.node = '<rect x="0" y="0" height="125" width="255" rx="40px" fill="#373737"></rect>';
                OrgChart.templates.watersourcesRoot = Object.assign({}, OrgChart.templates.ana);
                OrgChart.templates.watersourcesRoot.node = '<rect x="0" y="0" height="125" width="255" rx="40px" fill="#039be5"></rect>';

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
                    {id: 7, pid: 1, Name: "Kitchen Sink", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 8, pid: 1, Name: "Food Disposer", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 9, pid: 1, Name: "Dishwasher", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 10, pid: 1, Name: "Lavatory", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 11, pid: 1, Name: "Tub & Shower", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 12, pid: 1, Name: "Fire Suppression", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 13, pid: 1, Name: "Mechanical Cooling / P-Trap Prime", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 14, pid: 1, Name: "Clothes Washer", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 15, pid: 1, Name: "Toilet", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 16, pid: 1, Name: "Toilet (Composting)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 17, pid: 1, Name: "Toilet (Source Separated)", Source: "Condensate", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
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
                    {id: 30, pid: 2, Name: "Toilet (Source Separated)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 31, pid: 2, Name: "Urinal", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 32, pid: 2, Name: "Urinal (Waterless / Diverted)", Source: "Precipitation", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Stormwater Runoff Child Nodes */
                    {id: 33, pid: 3, Name: "Kitchen Sink", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 34, pid: 3, Name: "Food Disposer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 35, pid: 3, Name: "Dishwasher", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 36, pid: 3, Name: "Lavatory", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 37, pid: 3, Name: "Tub & Shower", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 38, pid: 3, Name: "Fire Suppression", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 39, pid: 3, Name: "Mechanical Cooling / P-Trap Prime", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 40, pid: 3, Name: "Clothes Washer", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 41, pid: 3, Name: "Toilet", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 42, pid: 3, Name: "Toilet (Composting)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 43, pid: 3, Name: "Toilet (Source Separated)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 44, pid: 3, Name: "Urinal", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 45, pid: 3, Name: "Urinal (Waterless / Diverted)", Source: "Stormwater Runoff", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Surface Water Child Nodes */
                    {id: 46, pid: 4, Name: "Kitchen Sink", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 47, pid: 4, Name: "Food Disposer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 48, pid: 4, Name: "Dishwasher", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 49, pid: 4, Name: "Lavatory", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 50, pid: 4, Name: "Tub & Shower", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 51, pid: 4, Name: "Fire Suppression", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 52, pid: 4, Name: "Mechanical Cooling / P-Trap Prime", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 53, pid: 4, Name: "Clothes Washer", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 54, pid: 4, Name: "Toilet", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 55, pid: 4, Name: "Toilet (Composting)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 56, pid: 4, Name: "Toilet (Source Separated)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 57, pid: 4, Name: "Urinal", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 58, pid: 4, Name: "Urinal (Waterless / Diverted)", Source: "Surface Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Shallow Groundwater Child Nodes */
                    {id: 59, pid: 5, Name: "Kitchen Sink", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 60, pid: 5, Name: "Food Disposer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 61, pid: 5, Name: "Dishwasher", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 62, pid: 5, Name: "Lavatory", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 63, pid: 5, Name: "Tub & Shower", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 64, pid: 5, Name: "Fire Suppression", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 65, pid: 5, Name: "Mechanical Cooling / P-Trap Prime", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 66, pid: 5, Name: "Clothes Washer", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 67, pid: 5, Name: "Toilet", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 68, pid: 5, Name: "Toilet (Composting)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 69, pid: 5, Name: "Toilet (Source Separated)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 70, pid: 5, Name: "Urinal", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 71, pid: 5, Name: "Urinal (Waterless / Diverted)", Source: "Shallow Groundwater", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},

                    /* Ground Water Child Nodes */
                    {id: 72, pid: 6, Name: "Kitchen Sink", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 73, pid: 6, Name: "Food Disposer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[8]},
                    {id: 74, pid: 6, Name: "Dishwasher", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[9]},
                    {id: 75, pid: 6, Name: "Lavatory", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[10]},
                    {id: 76, pid: 6, Name: "Tub & Shower", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[11]},
                    {id: 77, pid: 6, Name: "Fire Suppression", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[12]},
                    {id: 78, pid: 6, Name: "Mechanical Cooling / P-Trap Prime", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[13]},
                    {id: 79, pid: 6, Name: "Clothes Washer", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[14]},
                    {id: 80, pid: 6, Name: "Toilet", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 81, pid: 6, Name: "Toilet (Composting)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 82, pid: 6, Name: "Toilet (Source Separated)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[15]},
                    {id: 83, pid: 6, Name: "Urinal", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},
                    {id: 84, pid: 6, Name: "Urinal (Waterless / Diverted)", Source: "Ground Water", Links: "", img: "data:image/jpeg;base64," + string_icons[16]},


        /* _____________________________________________*/


                  /* DISPOSAL Child Nodes */


        /* _____________________________________________*/

                /*
                CONDENSATE Reuse Disposal
                */

                    /* Kitchen Sink */
                    {id: 86, pid: 7, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 87, pid: 7, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 88, pid: 7, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 89, pid: 7, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 90, pid: 7, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 91, pid: 7, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 98, pid: 7, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 99, pid: 8, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 100, pid: 8, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 101, pid: 8, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 102, pid: 8, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 103, pid: 8, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 104, pid: 8, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 105, pid: 8, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 106, pid: 9, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 107, pid: 9, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 108, pid: 9, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 109, pid: 9, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 110, pid: 9, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 111, pid: 9, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 112, pid: 9, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 113, pid: 10, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 114, pid: 10, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 115, pid: 10, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 116, pid: 10, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 117, pid: 10, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 118, pid: 10, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 119, pid: 10, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 120, pid: 11, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 121, pid: 11, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 122, pid: 11, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 123, pid: 11, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 124, pid: 11, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 125, pid: 11, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 126, pid: 11, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 127, pid: 12, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 128, pid: 12, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 129, pid: 12, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 130, pid: 12, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 131, pid: 12, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 132, pid: 12, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 133, pid: 12, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 134, pid: 13, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 135, pid: 13, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 136, pid: 13, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 137, pid: 13, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 138, pid: 13, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 139, pid: 13, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 140, pid: 13, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 141, pid: 14, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 142, pid: 14, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 143, pid: 14, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 144, pid: 14, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 145, pid: 14, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 146, pid: 14, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 147, pid: 14, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 148, pid: 15, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 149, pid: 15, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 150, pid: 15, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 151, pid: 15, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 152, pid: 15, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 153, pid: 15, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 154, pid: 15, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 155, pid: 16, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 156, pid: 16, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 157, pid: 16, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 158, pid: 16, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 159, pid: 16, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 160, pid: 16, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 161, pid: 16, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 162, pid: 17, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 163, pid: 17, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 164, pid: 17, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 165, pid: 17, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 166, pid: 17, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 167, pid: 17, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 168, pid: 17, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 169, pid: 18, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 170, pid: 18, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 171, pid: 18, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 172, pid: 18, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 173, pid: 18, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 174, pid: 18, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 175, pid: 18, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 176, pid: 19, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 177, pid: 19, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 178, pid: 19, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 179, pid: 19, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 180, pid: 19, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 181, pid: 19, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 182, pid: 19, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                /*
                PRECIPITATION Reuse Disposal
               */

                    /* Kitchen Sink */
                    {id: 183, pid: 20, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 184, pid: 20, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 185, pid: 20, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 186, pid: 20, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 187, pid: 20, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 188, pid: 20, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 189, pid: 20, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 190, pid: 21, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 191, pid: 21, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 192, pid: 21, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 193, pid: 21, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 194, pid: 21, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 195, pid: 21, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 196, pid: 21, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 197, pid: 22, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 198, pid: 22, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 199, pid: 22, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 200, pid: 22, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 201, pid: 22, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 202, pid: 22, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 203, pid: 22, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 204, pid: 23, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 205, pid: 23, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 206, pid: 23, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 209, pid: 23, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 210, pid: 23, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 211, pid: 23, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 212, pid: 23, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 213, pid: 24, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 214, pid: 24, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 215, pid: 24, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 216, pid: 24, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 217, pid: 24, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 218, pid: 24, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 219, pid: 24, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 220, pid: 25, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 221, pid: 25, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 222, pid: 25, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 223, pid: 25, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 224, pid: 25, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 225, pid: 25, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 226, pid: 25, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 227, pid: 26, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 228, pid: 26, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 229, pid: 26, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 230, pid: 26, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 231, pid: 26, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 232, pid: 26, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 233, pid: 26, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 234, pid: 27, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 235, pid: 27, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 236, pid: 27, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 237, pid: 27, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 238, pid: 27, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 239, pid: 27, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 240, pid: 27, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 241, pid: 28, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 242, pid: 28, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 243, pid: 28, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 244, pid: 28, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 245, pid: 28, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 246, pid: 28, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 247, pid: 28, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 248, pid: 29, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 249, pid: 29, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 250, pid: 29, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 251, pid: 29, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 252, pid: 29, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 253, pid: 29, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 254, pid: 29, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 255, pid: 30, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 256, pid: 30, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 257, pid: 30, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 258, pid: 30, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 259, pid: 30, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 260, pid: 30, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 261, pid: 30, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 262, pid: 31, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 263, pid: 31, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 264, pid: 31, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 265, pid: 31, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 266, pid: 31, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 267, pid: 31, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 268, pid: 31, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 269, pid: 32, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 270, pid: 32, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 271, pid: 32, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 272, pid: 32, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 273, pid: 32, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 274, pid: 32, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 275, pid: 32, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                /*
                STORMWATER RUNOFF Reuse Disposal
                */

                    /* Kitchen Sink */
                    {id: 276, pid: 33, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 277, pid: 33, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 278, pid: 33, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 279, pid: 33, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 280, pid: 33, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 281, pid: 33, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 282, pid: 33, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 283, pid: 34, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 284, pid: 34, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 285, pid: 34, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 286, pid: 34, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 287, pid: 34, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 288, pid: 34, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 289, pid: 34, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 290, pid: 35, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 291, pid: 35, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 292, pid: 35, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 293, pid: 35, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 294, pid: 35, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 295, pid: 35, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 296, pid: 35, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 297, pid: 36, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 298, pid: 36, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 299, pid: 36, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 300, pid: 36, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 301, pid: 36, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 302, pid: 36, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 303, pid: 36, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 304, pid: 37, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 305, pid: 37, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 306, pid: 37, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 307, pid: 37, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 308, pid: 37, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 309, pid: 37, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 310, pid: 37, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 311, pid: 38, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 312, pid: 38, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 313, pid: 38, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 314, pid: 38, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 315, pid: 38, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 316, pid: 38, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 317, pid: 38, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 318, pid: 39, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 319, pid: 39, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 320, pid: 39, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 321, pid: 39, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 322, pid: 39, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 323, pid: 39, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 324, pid: 39, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 325, pid: 40, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 326, pid: 40, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 327, pid: 40, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 328, pid: 40, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 329, pid: 40, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 330, pid: 40, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 331, pid: 40, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 332, pid: 41, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 333, pid: 41, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 334, pid: 41, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 335, pid: 41, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 336, pid: 41, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 337, pid: 41, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 338, pid: 41, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 339, pid: 42, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 340, pid: 42, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 341, pid: 42, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 342, pid: 42, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 343, pid: 42, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 344, pid: 42, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 345, pid: 42, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 346, pid: 43, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 347, pid: 43, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 348, pid: 43, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 349, pid: 43, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 350, pid: 43, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 351, pid: 43, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 352, pid: 43, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 353, pid: 44, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 354, pid: 44, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 355, pid: 44, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 356, pid: 44, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 357, pid: 44, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 358, pid: 44, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 359, pid: 44, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 360, pid: 45, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 361, pid: 45, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 362, pid: 45, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 363, pid: 45, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 364, pid: 45, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 365, pid: 45, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 366, pid: 45, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                /*
               SURFACE WATER Reuse Disposal
               */

                    /* Kitchen Sink */
                    {id: 367, pid: 46, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 368, pid: 46, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 369, pid: 46, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 370, pid: 46, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 371, pid: 46, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 372, pid: 46, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 373, pid: 46, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 374, pid: 47, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 375, pid: 47, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 376, pid: 47, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 377, pid: 47, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 378, pid: 47, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 379, pid: 47, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 380, pid: 47, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 381, pid: 48, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 382, pid: 48, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 383, pid: 48, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 384, pid: 48, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 385, pid: 48, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 386, pid: 48, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 387, pid: 48, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 388, pid: 49, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 389, pid: 49, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 390, pid: 49, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 391, pid: 49, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 392, pid: 49, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 393, pid: 49, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 394, pid: 49, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 395, pid: 50, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 396, pid: 50, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 397, pid: 50, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 398, pid: 50, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 399, pid: 50, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 400, pid: 50, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 401, pid: 50, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 402, pid: 51, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 403, pid: 51, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 404, pid: 51, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 405, pid: 51, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 406, pid: 51, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 407, pid: 51, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 408, pid: 51, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 409, pid: 52, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 410, pid: 52, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 411, pid: 52, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 412, pid: 52, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 413, pid: 52, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 414, pid: 52, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 415, pid: 52, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 416, pid: 53, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 417, pid: 53, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 418, pid: 53, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 419, pid: 53, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 420, pid: 53, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 421, pid: 53, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 422, pid: 53, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 423, pid: 54, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 424, pid: 54, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 425, pid: 54, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 426, pid: 54, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 427, pid: 54, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 428, pid: 54, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 429, pid: 54, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 430, pid: 55, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 431, pid: 55, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 432, pid: 55, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 433, pid: 55, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 434, pid: 55, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 435, pid: 55, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 436, pid: 55, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 437, pid: 56, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 438, pid: 56, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 439, pid: 56, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 440, pid: 56, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 441, pid: 56, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 442, pid: 56, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 443, pid: 56, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 444, pid: 57, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 445, pid: 57, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 446, pid: 57, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 447, pid: 57, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 448, pid: 57, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 449, pid: 57, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 450, pid: 57, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 451, pid: 58, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 452, pid: 58, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 453, pid: 58, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 454, pid: 58, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 455, pid: 58, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 456, pid: 58, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 457, pid: 58, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                /*
                SHALLOW GROUNDWATER Reuse Disposal
                */

                    /* Kitchen Sink */
                    {id: 458, pid: 59, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 459, pid: 59, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 460, pid: 59, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 461, pid: 59, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 462, pid: 59, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 463, pid: 59, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 464, pid: 59, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 465, pid: 60, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 466, pid: 60, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 467, pid: 60, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 468, pid: 60, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 469, pid: 60, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 470, pid: 60, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 471, pid: 60, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 472, pid: 61, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 473, pid: 61, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 474, pid: 61, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 475, pid: 61, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 476, pid: 61, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 477, pid: 61, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 478, pid: 61, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 479, pid: 62, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 480, pid: 62, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 481, pid: 62, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 482, pid: 62, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 483, pid: 62, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 484, pid: 62, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 485, pid: 62, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 486, pid: 63, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 487, pid: 63, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 488, pid: 63, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 489, pid: 63, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 490, pid: 63, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 491, pid: 63, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 492, pid: 63, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 493, pid: 64, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 494, pid: 64, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 495, pid: 64, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 496, pid: 64, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 497, pid: 64, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 498, pid: 64, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 499, pid: 64, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 500, pid: 65, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 501, pid: 65, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 502, pid: 65, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 503, pid: 65, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 504, pid: 65, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 505, pid: 65, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 506, pid: 65, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 507, pid: 66, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 508, pid: 66, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 509, pid: 66, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 510, pid: 66, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 511, pid: 66, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 512, pid: 66, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 513, pid: 66, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 514, pid: 67, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 515, pid: 67, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 516, pid: 67, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 517, pid: 67, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 518, pid: 67, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 519, pid: 67, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 520, pid: 67, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 521, pid: 68, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 522, pid: 68, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 523, pid: 68, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 524, pid: 68, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 525, pid: 68, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 526, pid: 68, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 527, pid: 68, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 528, pid: 69, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 529, pid: 69, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 530, pid: 69, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 531, pid: 69, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 532, pid: 69, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 533, pid: 69, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 534, pid: 69, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 535, pid: 70, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 536, pid: 70, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 537, pid: 70, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 538, pid: 70, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 539, pid: 70, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 540, pid: 70, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 541, pid: 70, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 542, pid: 71, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 543, pid: 71, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 544, pid: 71, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 545, pid: 71, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 546, pid: 71, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 547, pid: 71, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 548, pid: 71, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                /*
               GROUNDWATER Reuse Disposal
               */

                    /* Kitchen Sink */
                    {id: 549, pid: 72, Name: "Subsurface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 550, pid: 72, Name: "Surface Irrigation", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 551, pid: 72, Name: "Injection Well", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 552, pid: 72, Name: "Bioswale", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 553, pid: 72, Name: "Agriculture (Non-Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 554, pid: 72, Name: "Agriculture (Food)", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 555, pid: 72, Name: "Water Treatment Facility", Source: "Kitchen Sink", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Food Disposer */
                    {id: 556, pid: 73, Name: "Subsurface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 557, pid: 73, Name: "Surface Irrigation", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 558, pid: 73, Name: "Injection Well", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 559, pid: 73, Name: "Bioswale", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 560, pid: 73, Name: "Agriculture (Non-Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 561, pid: 73, Name: "Agriculture (Food)", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 562, pid: 73, Name: "Water Treatment Facility", Source: "Food Disposer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Dishwasher */
                    {id: 563, pid: 74, Name: "Subsurface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 564, pid: 74, Name: "Surface Irrigation", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 565, pid: 74, Name: "Injection Well", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 566, pid: 74, Name: "Bioswale", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 567, pid: 74, Name: "Agriculture (Non-Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 568, pid: 74, Name: "Agriculture (Food)", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 569, pid: 74, Name: "Water Treatment Facility", Source: "Dishwasher", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Lavatory */
                    {id: 570, pid: 75, Name: "Subsurface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 571, pid: 75, Name: "Surface Irrigation", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 572, pid: 75, Name: "Injection Well", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 573, pid: 75, Name: "Bioswale", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 574, pid: 75, Name: "Agriculture (Non-Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 575, pid: 75, Name: "Agriculture (Food)", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 576, pid: 75, Name: "Water Treatment Facility", Source: "Lavatory", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Tub & Shower */
                    {id: 577, pid: 76, Name: "Subsurface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 578, pid: 76, Name: "Surface Irrigation", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 579, pid: 76, Name: "Injection Well", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 580, pid: 76, Name: "Bioswale", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 581, pid: 76, Name: "Agriculture (Non-Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 582, pid: 76, Name: "Agriculture (Food)", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 583, pid: 76, Name: "Water Treatment Facility", Source: "Tub & Shower", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Fire Suppression */
                    {id: 584, pid: 77, Name: "Subsurface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 585, pid: 77, Name: "Surface Irrigation", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 586, pid: 77, Name: "Injection Well", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 587, pid: 77, Name: "Bioswale", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 588, pid: 77, Name: "Agriculture (Non-Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 589, pid: 77, Name: "Agriculture (Food)", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 590, pid: 77, Name: "Water Treatment Facility", Source: "Fire Suppression", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Mechanical Cooling / P-Trap Prime */
                    {id: 591, pid: 78, Name: "Subsurface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 592, pid: 78, Name: "Surface Irrigation", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 593, pid: 78, Name: "Injection Well", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 594, pid: 78, Name: "Bioswale", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 595, pid: 78, Name: "Agriculture (Non-Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 596, pid: 78, Name: "Agriculture (Food)", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 597, pid: 78, Name: "Water Treatment Facility", Source: "Mechanical Cooling / P-Trap Prime", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Clothes Washer */
                    {id: 598, pid: 79, Name: "Subsurface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 599, pid: 79, Name: "Surface Irrigation", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 600, pid: 79, Name: "Injection Well", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 601, pid: 79, Name: "Bioswale", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 602, pid: 79, Name: "Agriculture (Non-Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 603, pid: 79, Name: "Agriculture (Food)", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 604, pid: 79, Name: "Water Treatment Facility", Source: "Clothes Washer", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet */
                    {id: 605, pid: 80, Name: "Subsurface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 606, pid: 80, Name: "Surface Irrigation", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 607, pid: 80, Name: "Injection Well", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 608, pid: 80, Name: "Bioswale", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 609, pid: 80, Name: "Agriculture (Non-Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 610, pid: 80, Name: "Agriculture (Food)", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 611, pid: 80, Name: "Water Treatment Facility", Source: "Toilet", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Composting) */
                    {id: 612, pid: 81, Name: "Subsurface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 613, pid: 81, Name: "Surface Irrigation", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 614, pid: 81, Name: "Injection Well", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 615, pid: 81, Name: "Bioswale", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 616, pid: 81, Name: "Agriculture (Non-Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 617, pid: 81, Name: "Agriculture (Food)", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 618, pid: 81, Name: "Water Treatment Facility", Source: "Toilet (Composting)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Toilet (Source Separated) */
                    {id: 619, pid: 82, Name: "Subsurface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 620, pid: 82, Name: "Surface Irrigation", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 621, pid: 82, Name: "Injection Well", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 622, pid: 82, Name: "Bioswale", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 623, pid: 82, Name: "Agriculture (Non-Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 624, pid: 82, Name: "Agriculture (Food)", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 625, pid: 82, Name: "Water Treatment Facility", Source: "Toilet (Source Separated)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal */
                    {id: 626, pid: 83, Name: "Subsurface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 627, pid: 83, Name: "Surface Irrigation", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 628, pid: 83, Name: "Injection Well", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 629, pid: 83, Name: "Bioswale", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 630, pid: 83, Name: "Agriculture (Non-Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 631, pid: 83, Name: "Agriculture (Food)", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 632, pid: 83, Name: "Water Treatment Facility", Source: "Urinal", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

                    /* Urinal (Waterless / Diverted) */
                    {id: 633, pid: 84, Name: "Subsurface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[17]},
                    {id: 634, pid: 84, Name: "Surface Irrigation", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[18]},
                    {id: 635, pid: 84, Name: "Injection Well", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[19]},
                    {id: 636, pid: 84, Name: "Bioswale", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[20]},
                    {id: 637, pid: 84, Name: "Agriculture (Non-Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[21]},
                    {id: 638, pid: 84, Name: "Agriculture (Food)", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[22]},
                    {id: 639, pid: 84, Name: "Water Treatment Facility", Source: "Urinal (Waterless / Diverted)", Links: "", img: "data:image/jpeg;base64," + string_icons[23]},

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
                        case "Water Sources":
                          node.tags = ["WaterSources"];
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
                        },
                        WaterSources: {
                            template:"watersourcesRoot"
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
                            if (cityCodeLinks == null){
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
                            if (cityPermitLinks == null){
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
                            if (cityIncentivesLinks == null){
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
                            if (cityInfoLinks == null){
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
                            if (countyCodeLinks == null){
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
                            if (countyPermitLinks == null){
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
                            if (countyIncentivesLinks == null){
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
                            if (countyInfoLinks == null){
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
                            if (stateCodeLinks == null){
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
                            if (statePermitLinks == null){
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
                            if (stateIncentivesLinks == null){
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
                            if (stateInfoLinks == null){
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
