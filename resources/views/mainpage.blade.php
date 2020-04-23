@extends("layouts.master")

@section('body')
    <div class="container-fluid main-content mt-5">

        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="jumbotron bg-white text-center">
                    <h1 class="display-4 main-title">Water Reuse Directory</h1>
                    <p class="lead"> A database of crowdsourced and verified re-use regulations. </p>
                    <hr class="my-4">
                    <p>In a time where access to usable water is becoming more scarce, enabling people to re-using water properly is a important step to take.</p>
                    {{--<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>--}}
                </div>
                <div class="heading-card text-center">
                    <h1 class="main-title text-muted-red roboto"> Water Reuse Directory</h1>
                    <h4 class="main-subtext mplus ml-1"> Helping make re-using water easier since 2020. </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="mapid"></div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script>
        var map = L.map('mapid').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            .openPopup();
    </script>
@endpush

@push("css")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
<style>
    html, body {
        height: 100%;
    }
    body {
        background: url("img/bird-s-eye-view-of-ocean-during-daytime-2707756.jpg");
        background-size: cover;
    }
    .main-content .card {
        padding: 35px;
        opacity: 0.87;
        border-radius: 25px;
    }

    .heading-card{
        background: rgba(255, 255, 255, 0.85);
        padding: 20px;
        border-radius: 10px;
    }

    .main-title {
        opacity: 1;
        font-weight: 800;
        font-size: 5.5rem;
        /*color: #2e909e;*/
        color: #22707b;
    }

    #mapid{
        height: 300px;
        width: 500px;
    }

</style>


@endpush