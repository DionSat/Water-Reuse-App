@extends('layouts.master')

@section('body')
    <div class="container">
        <h1>Information</h1>
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Base User</div>

                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris maximus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu. Vivamus euismod lacinia sapien sed ullamcorper.
                        Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        Aliquam consectetur tortor massa, ut commodo velit lacinia eu. Donec consectetur dolor et orci porta,
                        non feugiat libero finibus. Nunc ullamcorper orci quis euismod aliquam. Ut vehicula orci eu tempor tristique.
                        Donec ut dapibus dui. Nunc sed tincidunt tortor.
                        Pellentesque id ex tortor.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Mid User</div>

                    <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris maximus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu. Vivamus euismod lacinia sapien sed ullamcorper.
                        Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        Aliquam consectetur tortor massa, ut commodo velit lacinia eu. Donec consectetur dolor et orci porta,
                        non feugiat libero finibus. Nunc ullamcorper orci quis euismod aliquam. Ut vehicula orci eu tempor tristique.
                        Donec ut dapibus dui. Nunc sed tincidunt tortor.
                        Pellentesque id ex tortor.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Super User</div>

                    <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
                        Pellentesque sed justo dui.
                        Vivamus pretium venenatis diam, quis sollicitudin turpis facilisis sit amet.
                        Suspendisse laoreet diam quis laoreet euismod. Mauris in velit vitae
                        ligula porta tempus vitae non nunc. Mauris maximus aliquam mi,
                        sed egestas libero feugiat vel. Phasellus iaculis posuere velit,
                        accumsan varius sem scelerisque eu. Vivamus euismod lacinia sapien sed ullamcorper.
                        Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        Aliquam consectetur tortor massa, ut commodo velit lacinia eu. Donec consectetur dolor et orci porta,
                        non feugiat libero finibus. Nunc ullamcorper orci quis euismod aliquam. Ut vehicula orci eu tempor tristique.
                        Donec ut dapibus dui. Nunc sed tincidunt tortor.
                        Pellentesque id ex tortor.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("css")
    <style>
        .py-4 {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            text-align: center;
        }
        h1{
            color: white;
        }
        p {
            margin-top: 3em;
        }
    </style>
@endpush
