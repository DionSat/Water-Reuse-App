@extends("layouts.master")

@section('body')
    <div class="container main-content mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <h1 class="main-title text-muted-red roboto"> Water Reuse Application</h1>
                    <h4 class="main-subtext mplus ml-1"> Helping make re-using water easier since 2020. </h4>
                </div>

            </div>
        </div>
    </div>
@endsection

@push("css")
<style>
    html, body {
        height: 125%;
    }
    body {
        background: url("img/adrien-olichon-unsplash.jpg");
        background-size: cover;
    }
    .main-content .card {
        padding: 35px;
        opacity: 0.87;
        border-radius: 25px;
    }

    .main-title {
        -webkit-text-stroke: 2px black;
        font-weight: 800;
        font-size: 5.5rem;
        color: white;
    }
</style>


@endpush