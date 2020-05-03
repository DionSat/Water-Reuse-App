@extends("layouts.master")

@section('body')
    <div class="container">
        <div id="mer">

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
    #source0{
        background-color: #000;
    }
/*
    body {
        background: #222;
        color: #fff;
        font-family: 'Arvo', serif;
        font-weight: 700;
        font-style: italic;
    }
    .actor {
        stroke-width: 2;
        stroke: #fff;
        fill: #222;
        font-family: 'Arvo', serif;
        font-weight: 700;
        font-style: italic;
    }
    text.actor {
        fill: #fff;
        stroke: none;
    }
    .actor-line {
        stroke: #fff;
    }
    .source {
        stroke-width: 1;
        marker-end: "url(#arrowhead)";
        stroke: #fff;
    }
    .source1 {
        stroke-width: 1;
        stroke-dasharray: "2 2";
        stroke: #fff;
    }
    #arrowhead {
        fill: #fff;
    }
    .messageText {
        fill: #222;
        stroke: #fff;
    } */
</style>
@endpush
@push("js")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.4.0/mermaid.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
    $(document).ready(function(){
        $waterSources = new Array("Condensate", "Harvested Water", "Surface Water", "Stormwater Runoff", "Shallow Groundwater", "Aquifer");
        $count = 0;
        $buffer = 0;
        $sourceCount = 0;
        $fixtureCount = 0;
        $wasSet = false;
        $fixtures = new Array("Kitchen Sink", "Kitchen Sink + Disposal", "Dishwasher", "Lavatory", "Tub Shower", "Fire Suppression", "Mechanical Cooling + P-Trap Prime", "Clothes Washer", "Toilet", "Composting Toilet", "Urinel", "Water Reuse Urinal or Urine Diverter");

        // $source = '<div class="mermaid"> graph LR;';
        for(i = 0; i < $waterSources.length; ++i)
        {
            $source = '<div class="mermaid"> graph LR;';
            for(j = 0; j < 12; ++j)
            {
                $source += 'source' + $sourceCount + '('+ $waterSources[i] + '):::waterSource --> code' + $count + '["#128279;"]:::codes;';
                $buffer = $count;
                $count++;
                $source += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes;';
                $buffer = $count;
                $count++;
                $source += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes;';
                $buffer = $count;
                $count++;
                $source += 'code' + $buffer + ' --> code' + $count + '["#128279;"]:::codes;';
                if(!$wasSet)
                {
                    $source += 'code' + $count + ' --> fixuture' + $fixtureCount + '('+ $fixtures[$fixtureCount] + '):::fixture;';
                }
                else{
                    $source += 'code' + $count + ' --> fixuture' + $fixtureCount + ';';
                }
                $count++;
                $fixtureCount++;
            }
            $sourceCount++;
            $fixtureCount = 0;
            $source += 'class source0 cssClass;\n classDef waterSource:hover fill:#0ff;\nclassDef codes fill:#8A2BE2;';
            $("#mer").append($source);
        }

    })
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
    </script>

@endpush
