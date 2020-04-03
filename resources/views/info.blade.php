@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        <h1 id="h">Information</h1>
        @guest
        <div class="row justify-content-center" style="margin: 3em">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Base User</div>

                    <div class="card-body">
                        <p id="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel bibendum ipsum.
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
        <button type="button" class="btn btn-dark"  onclick="changeFonts()">Change Font</button>
        <p id="back">Background: 0</p>
        <p id="font">Font: 0</p>
    </div>

    <script type='text/javascript'>
            let nBackChangedCount = 0;
            let nFontChangedCount = 0;
            function changeBackground () {
                if(nBackChangedCount == 0)
                {
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "linear-gradient(4deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%)";
                    }
                    nBackChangedCount = 1;
                    document.getElementById("back").innerHTML = "Backround: " + nBackChangedCount;
                }
                else if (nBackChangedCount == 1){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "linear-gradient(0deg, rgba(12,0,216,1) 0%, rgba(0,212,255,1) 35%, rgba(255,255,255,1) 100%)";
                    }
                    document.getElementById("h").style.color = "black";
                    nBackChangedCount = 2;
                    document.getElementById("back").innerHTML = "Backround: " + nBackChangedCount;
                }
                else if (nBackChangedCount == 2){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "rgb(135, 206, 250)";
                    }
                    document.getElementById("h").style.color = "white";
                    nBackChangedCount = 3;
                    document.getElementById("back").innerHTML = "Backround: " + nBackChangedCount;
                }
                else if (nBackChangedCount == 3){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "#3DCCCC";
                    }
                    nBackChangedCount = 5;
                    document.getElementById("back").innerHTML = "Backround: 4";
                }
                else if (nBackChangedCount == 4){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.background = "rgb(0 , 0 , 0)";
                    }
                    nBackChangedCount = 0;
                    document.getElementById("back").innerHTML = "Backround: " + nBackChangedCount;
                }

                //--------------------pictures
                else if (nBackChangedCount == 5){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.backgroundImage = "url('img/adrien-olichon-unsplash.jpg')";
                    }
                    nBackChangedCount = 6;
                    document.getElementById("back").innerHTML = "Backround: 5";
                }
                else if (nBackChangedCount == 6){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.backgroundImage = "url('img/akira-hojo-unsplash.jpg')";
                    }
                    document.getElementById("h").style.color = "black";
                    nBackChangedCount = 7;
                    document.getElementById("back").innerHTML = "Backround: 6";
                }
                else if (nBackChangedCount == 7){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.backgroundImage = "url('img/jong-marshes-unsplash.jpg')";
                    }
                    document.getElementById("h").style.color = "white";
                    nBackChangedCount = 8;
                    document.getElementById("back").innerHTML = "Backround: 7";
                }
                else if (nBackChangedCount == 8){
                    var elements = document.getElementsByClassName('py-4'); // get all elements
	                for(var i = 0; i < elements.length; i++){
		                elements[i].style.backgroundImage = "url('img/manu-schwendener-unsplash.jpg')";
                    }
                    nBackChangedCount = 4;
                    document.getElementById("back").innerHTML = "Backround: 8";
                }
            }

            function changeFonts () {
                if(nFontChangedCount == 0)
                {
                    document.getElementById("p").style.fontFamily = "'Raleway'";
                    document.getElementById("h").style.fontFamily = "'Playfair Display', serif";
                    nFontChangedCount = 1;
                    document.getElementById("font").innerHTML = "Font: " + nFontChangedCount;
                }
                else if(nFontChangedCount == 1)
                {
                    document.getElementById("p").style.fontFamily = 'Poppins, sans-serif';
                    document.getElementById("h").style.fontFamily = 'Mukta, sans-serif';
                    nFontChangedCount = 2;
                    document.getElementById("font").innerHTML = "Font: " + nFontChangedCount;
                }
                else if(nFontChangedCount == 2)
                {
                    document.getElementById("p").style.fontFamily = 'Roboto, sans-serif';
                    document.getElementById("h").style.fontFamily = 'Abril Fatface, cursive';
                    nFontChangedCount = 3;
                    document.getElementById("font").innerHTML = "Font: " + nFontChangedCount;
                }
                else if(nFontChangedCount == 3)
                {
                    document.getElementById("p").style.fontFamily = 'Poppins, sans-serif';
                    document.getElementById("h").style.fontFamily = "Sen";
                    nFontChangedCount = 4;
                    document.getElementById("font").innerHTML = "Font: " + nFontChangedCount;
                }
                else if(nFontChangedCount == 4)
                {
                    document.getElementById("p").style.fontFamily = "Lato";
                    document.getElementById("h").style.fontFamily = "Lobster";
                    nFontChangedCount = 0;
                    document.getElementById("font").innerHTML = "Font: " + nFontChangedCount;
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
        #back, #font {
            color: white;
        }
    </style>
@endpush
