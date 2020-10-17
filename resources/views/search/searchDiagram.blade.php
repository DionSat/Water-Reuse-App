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
                <div class="legend-content">
                    <div>
                        <div style="background-color:#00cdcd;"></div>  First Use Water
                    </div>
                    <div>
                        <div style="background-color:#8c8c8c;"></div>  Greywater
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


                        OrgChart.toolbarUI.expandAllIcon = '<i  class="tb fas fa-layer-group fa-2x fa-fw" title="Expand Diagram"></i>';
                        OrgChart.toolbarUI.fitIcon = '<i class="tb fas fa-expand fa-2x fa-fw" title="Auto Fit Diagram"></i>';
                        OrgChart.toolbarUI.zoomOutIcon = '<i class="tb fas fa-search-minus fa-2x fa-fw" title="Zoom Out"></i>';
                        OrgChart.toolbarUI.zoomInIcon = '<i class="tb fas fa-search-plus fa-2x fa-fw" title="Zoom In"></i>';

                        OrgChart.templates.ana.link = '<path stroke-linejoin="round" stroke="#AFD4FE" stroke-width="10" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>' +
                            '<path class="path" stroke-width="4" fill="none" stroke="#ffffff" stroke-dasharray="10"  d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}"/>';

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
                                img_0: "img"
                            },
                            nodes: [
                                {id: 1, Name: "Condensate", img: "data:image/jpeg;base64," + string_icons[0]},
                                {
                                    id: 2,
                                    pid: 1,
                                    Name: "Kitchen Sink",
                                    img: "data:image/jpeg;base64," + string_icons[1]
                                },
                                {
                                    id: 3,
                                    pid: 1,
                                    Name: "Kitchen Sink + Disposer",
                                    img: "data:image/jpeg;base64," + string_icons[2]
                                },
                                {
                                    id: 4,
                                    pid: 1,
                                    Name: "Dishwasher",
                                    img: "data:image/jpeg;base64," + string_icons[3]
                                },
                                {id: 5, pid: 1, Name: "Lavatory", img: "data:image/jpeg;base64," + string_icons[4]},
                                {
                                    id: 6,
                                    pid: 1,
                                    Name: "Tub + Shower",
                                    img: "data:image/jpeg;base64," + string_icons[5]
                                },
                                {
                                    id: 7,
                                    pid: 1,
                                    Name: "Fire Suppression",
                                    img: "data:image/jpeg;base64," + string_icons[6]
                                },
                                {
                                    id: 8,
                                    pid: 1,
                                    Name: "Clothes Washer",
                                    img: "data:image/jpeg;base64," + string_icons[7]
                                },
                                {id: 9, pid: 1, Name: "Toilet", img: "data:image/jpeg;base64," + string_icons[8]},
                                {
                                    id: 10,
                                    pid: 1,
                                    Name: "Composting Toilet",
                                    img: "data:image/jpeg;base64," + string_icons[9]
                                },
                                {id: 11, pid: 1, Name: "Urinal", img: "data:image/jpeg;base64," + string_icons[10]}
                            ]
                        });

                        /*chart.editUI.on('field', function(sender, args){

                            //      On the seachResults.blade they utilize @ include inside the divs of the locations
                            //      they want to inset the table on which is held in seachResultTable.blade
                            //      If I can make my own version of the table but only have it on a per
                            //      single row basis based on the name, then I can pull in the already created / linked
                            //      buttons they have made. Then using this chart.editUI.on function I can insert in the
                            //      link buttons without having to hardcode anything!ee


                            if (args.type == 'details' && args.name == 'company')
                                var txt = args.field.querySelector('input');
                                var txtVal = txt.value;
                                if (txt){

                                    var permitBtn = document.createElement('a');
                                    var linkText = document.createTextNode("BALKANGraph.com");
                                    a.appendChild(linkText);
                                    a.title = "my title text";
                                    a.href = "https://balkangraph.com/";
                                    a.target = "_blank";


                                    var parent = args.field.querySelector('div');
                                    var br = document.createElement("br");
                                    parent.appendChild(br);
                                    parent.appendChild(a);

                                    txt.remove();

                                }
                            }
                        });*/

                        function preview(){

                            OrgChart.pdfPrevUI.show(chart, {
                                format: 'A4'
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

        i.tb {
            border: 2px solid #6c757d;
            line-height: inherit;
        }

        .legend-content{
            position: absolute;
            bottom: 0;
            left: 0;
            margin: 0 0 50px 20px;
        }

        .legend-content > div > div {
            display: inline-block;
            width: 30px;
            height:8px;
            margin-bottom: 2px;
        }

        .path {
            animation: dash 5s linear infinite;

        }

        @keyframes dash {
            from {
                stroke-dashoffset: 100;
                opacity: 1;
            }
            to {
                stroke-dashoffset: 0;
                opacity: 0;
            }
        }


    </style>
@endpush
