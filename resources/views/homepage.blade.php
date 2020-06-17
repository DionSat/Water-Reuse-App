@extends("layouts.master")

@section('body')
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="jumbotron bg-white text-center">
                    <h1 class="display-4 main-title">Water Reuse Permit App</h1>
                    <p class="lead"> A database of crowdsourced and verified re-use regulations. </p>
                    <hr class="my-4">
                    <p>In a time where access to usable water is becoming more scarce, enabling people to re-use water properly is a important step to take.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h5 class="card-title"> Accessible Reuse Rules </h5>
                        </div>
                        <hr>
                        <div class="card-text">
                            <ul class="fa-ul">
                                <li><span class="fa-li"><i class="fas fa-tint"></i></span>Vetted information with links to regulations.</li>
                                <li><span class="fa-li"><i class="fas fa-map-marked-alt"></i></span>Locations/rules all across the US.</li>
                                <li><span class="fa-li"><i class="fas fa-street-view"></i></span>Crowdsourced by you. Re-use regulations can be submitted by anyone.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-3 mt-md-0 h-100">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h5 class="card-title"> Find Information + Contribute </h5>
                        </div>
                        <hr>
                        <div class="card-text text-center">
                            <h5 class="lead mt-4">Search for water reuse regulations by City, County or State.</h5>
                            <a class="btn btn-primary btn-block" href="{{route("search")}}">
                                Lookup Reuse Regulations
                            </a>
                            <hr class="mt-5">
                            <h5 class="lead mt-4">Contibute your knowledge by adding to our database.</h5>
                            @if(Auth::check())
                                <a class="btn btn-primary btn-block mb-4" href="{{route("userSubmission")}}">
                                    Submit a Regulation
                                </a>
                            @else
                                <a class="btn btn-primary btn-block mb-4" href="{{route("register")}}">
                                    Register To Contribute
                                </a>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 mt-md-0 h-100">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h5 class="card-title">  A Recode Project  </h5>
                        </div>
                        <hr>
                        <div class="card-text text-center">
                            <img src="img/recode-logo.jpg" class="img-fluid">
                            <h5 class="lead mt-5">A project backed by the Recode non-profit organization.</h5>
                            <a class="btn btn-success btn-block mt-4" href="https://www.recodenow.org/">
                                Visit Recode
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    {{-- This code below is for embedding a Live JS map - if we want to do so later --}}

    {{--<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"--}}
            {{--integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="--}}
            {{--crossorigin=""></script>--}}
    {{--<script>--}}
        {{--var map = L.map('mapid').setView([51.505, -0.09], 13);--}}

        {{--L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {--}}
            {{--attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'--}}
        {{--}).addTo(map);--}}

        {{--L.marker([51.5, -0.09]).addTo(map)--}}
            {{--.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')--}}
            {{--.openPopup();--}}
    {{--</script>--}}
@endpush

@push("css")
    {{--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"--}}
          {{--integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="--}}
          {{--crossorigin=""/>--}}
    <style>
        html, body {
            height: 100%;
        }

        #app {
            background: url("img/mainBackground.png");
            background-size: cover;
            height: 100%;
            overflow: scroll;
        }

        .fa-ul>li {
            position: relative;
            margin-top: 25px;
            padding: 12px;
        }

        .fa-li i {
            font-size: 30px;
        }
    </style>
@endpush
