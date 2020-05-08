@extends("layouts.master")

@section('body')
    <div class="container">
    <div class="header">Choose A Water Source</div>
        <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="condensateButton" onclick="createCondensateGraph()">Condensate</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="harvestedWaterButton" onclick="createHarvestedWaterGraph()">Harvested Water</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="surfaceWaterButton" onclick="createSurfaceWaterGraph()">Surface Water</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="stormWaterButton" onclick="createStormWaterGraph()">Stormwater Runoff</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="groundWaterButton" onclick="createGroundWaterGraph()">Shallow Ground Water</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" id="aquiferButton" onclick="createAquiferGraph()">Aquifer</button>
            </div>
        </div>
        <div id="graph">
        </div>
    </div>
@endsection
@push("css")

<style>
    @import url(https://fonts.googleapis.com/css?family=Arvo:700italic);
    @import url(https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css);
    .text-wrap {
        white-space: normal;
    }
    .waterSource{
        background-color: #000;
    }
    #A:hover {
        fill: #000 !important;
    }
    #source0{
        background-color: #000;
    }
    .cssClass > rect{
        fill:#FF0000 !important;
        stroke:#FFFF00 !important;
        stroke-width:4px !important;
    }
    .row {
        margin: 1em 0;
    }
    .header{
        margin: 1em 0;
    }
</style>
@endpush
@push("js")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.5.0/mermaidAPI.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.5.0/mermaid.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        //------------Initialize mermaid
        var config = {
            startOnLoad: true,
            flowchart:{
                useMaxWidth:true,
                htmlLabels:true,
                curve:'cardinal',
            },
            securityLevel:'loose',
        };

        mermaid.initialize(config);

        //-----------Mock up function to show mermaid capabilites and possible graph layout.
        function createCondensateGraph() {
            $count = 0;
            $fixtureCount = 0;
            $wasSet = false;
            var clickToAppend = "";
            $fixtures = new Array("Kitchen Sink", "Kitchen Sink + Disposal", "Dishwasher", "Lavatory", "Tub Shower", "Fire Suppression", "Mechanical Cooling + P-Trap Prime", "Clothes Washer", "Toilet", "Composting Toilet", "Urinel", "Water Reuse Urinal or Urine Diverter");
            var graphDefinition = 'graph LR;';

            for(j = 0; j < 12; ++j)
            {
                graphDefinition += 'source0(Condensate):::waterSource --> code' + $count + '(+):::codes0;';
                clickToAppend += 'click code' + $count + ' "http://www.github.com" "This is a link";';
                $buffer = $count;
                $count++;
                graphDefinition += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes1;';
                clickToAppend += 'click code' + $count + ' "http://www.github.com" "This is a link";';
                $buffer = $count;
                $count++;
                graphDefinition += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes2;';
                clickToAppend += 'click code' + $count + ' "http://www.github.com" "This is a link";';
                $buffer = $count;
                $count++;
                graphDefinition += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes3;';
                clickToAppend += 'click code' + $count + ' "http://www.github.com" "This is a link";';
                if(!$wasSet)
                {
                    graphDefinition += 'code' + $count + ' --> fixuture' + $fixtureCount + '('+ $fixtures[$fixtureCount] + '):::fixture;';
                }
                else{
                    graphDefinition += 'code' + $count + ' --> fixuture' + $fixtureCount + ';';
                }
                $count++;
                $fixtureCount++;
            }
            $fixtureCount = 0;
            //graphDefinition += 'linkStyle default visibility:hidden;\nclass source0 cssClass;\n classDef waterSource:hover fill:#0ff;\nclassDef codes fill:#8A2BE2;';
            graphDefinition += clickToAppend;
            graphDefinition += '\nclass source0 cssClass;\n classDef waterSource:hover fill:#0ff;\nclassDef codes0 fill:#8A2BE2;\nclassDef codes1 fill:#8A2BFF;\nclassDef codes2 fill:#8A2BAF;\nclassDef codes3 fill:#8A2B00;';

            //-----------------renders the graph
            $(function() {
                var cb = function(svgGraph) {
                    console.log(svgGraph)
                }
                mermaid.mermaidAPI.render('theGraph', graphDefinition, function(svgCode) {
                    document.getElementById("graph").innerHTML = svgCode;
                });
            });
        };




    </script>

@endpush
