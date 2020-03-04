@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        <h1>Information</h1>
        @guest
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
        @else
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
                        ligula porta tempus vitae non nunc. Mauris max
                        imus aliquam mi,
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
        @endguest

        <button type="button" class="btn btn-light" onclick="changeBackground()">Change Background</button>
        <button type="button" class="btn btn-dark"  onclick="changeFont()">Change Font</button>
    </div>

    <script type='text/javascript'>
            let nBackChangedCount = 0;
            let nFontChangedCount = 0;
            function changeBackground () {
                if(nBackChangedCount == 0)
                {
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%)";
                    }
                    nBackChangedCount = 1;
                }
                else if (nBackChangedCount == 1){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "rgb(0 , 0 , 0)";
                    }
                    nBackChangedCount = 0;
                }

            }

            function changeFonts () {
                if(nFontChangedCount == 0)
                {

                }
            }
    </script>
@endsection

@push("css")
    <style>
        .py-4 {
            background: rgb(2,0,36);
            text-align: center;
        }
        h1{
            color: white;
            font-family: 'Lobster';
        }
        p {
            margin-top: 3em;
            font-family: 'Lato';
        }
    </style>
@endpush

@push('script-head')
        <script>

        </script>
@endpush
