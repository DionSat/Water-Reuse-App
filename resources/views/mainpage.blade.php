@extends("layouts.master")

@section('body')
    <div class="container main-content mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-card text-center">
                    <h1 class="main-title text-muted-red roboto"> Water Reuse Directory</h1>
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


</style>


@endpush