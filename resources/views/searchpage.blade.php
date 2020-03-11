@extends("layouts.master")
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Search for Location </h3></div>
                    <?php /* 
                    
                                 <div class="card-body">
                        <h3>You are:
                            @if(Auth::check())
                                Logged In!
                            @else
                                Not Logged In!
                            @endif
                        </h3>
                        <form  method="POST" class="form-inline mt-3">
                            {{--This is a required thing for forms in Laravel, to stop CSRF attacks --}}
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="search">Address</label>
                                <input type="text" class="form-control" id="search" placeholder="Address...">
                            </div>
                            <button class="btn btn-primary"> Search </button>
                        </form>
                        <br>
                    </div>
                </div>
                    */
                    ?>
               <!DOCTYPE html>
               <html>
               
               <head>
                   <meta content="width=device-width, initial-scale=1.0" name="viewport">
                   <link rel="stylesheet" type="text/css" href="search.css">
               </head>
               
               <body>
                   <div class="form">
                       <form action="example.php" autocomplete="off">
                           <div class="autocomplete" style="width:100%;">
                               <input id="myState" name="State" placeholder="State" type="text">
                           </div>
                       </form><br>
                       <form action="example.php" autocomplete="off">
                           <div class="autocomplete" style="width:100%;">
                               <input id="myCounty" name="County" placeholder="County" type="text">
                           </div>
                       </form><br>
                       <form action="example.php" autocomplete="off">
                           <div class="autocomplete" style="width:100%;">
                               <input id="myCity" name="City" placeholder="City" type="text">
                           </div>
                       </form><br>
                       <button class="button">Search</button>
                   </div>
                   <script>
                       function autocomplete(inp, arr) {
                           var currentFocus;
                           inp.addEventListener("input", function (e) {
                               var a, b, i, val = this.value;
                               closeAllLists();
                               if (!val) {
                                   return false;
                               }
                               currentFocus = -1;
                               a = document.createElement("DIV");
                               a.setAttribute("id", this.id + "autocomplete-list");
                               a.setAttribute("class", "autocomplete-items");
                               this.parentNode.appendChild(a);
                               for (i = 0; i < arr.length; i++) {
                                   if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                       b = document.createElement("DIV");
                                       b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "<\/strong>";
                                       b.innerHTML += arr[i].substr(val.length);
                                       b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                                       b.addEventListener("click", function (e) {
                                           inp.value = this.getElementsByTagName("input")[0].value;
                                           closeAllLists();
                                       });
                                       a.appendChild(b);
                                   }
                               }
                           });
                           inp.addEventListener("keydown", function (e) {
                               var x = document.getElementById(this.id + "autocomplete-list");
                               if (x) x = x.getElementsByTagName("div");
                               if (e.keyCode == 40) {
                                   currentFocus++;
                                   addActive(x);
                               } else if (e.keyCode == 38) {
                                   currentFocus--;
                                   addActive(x);
                               } else if (e.keyCode == 13) {
                                   e.preventDefault();
                                   if (currentFocus > -1) {
                                       if (x) x[currentFocus].click();
                                   }
                               }
                           });
               
                           function addActive(x) {
                               if (!x) return false;
                               removeActive(x);
                               if (currentFocus >= x.length) currentFocus = 0;
                               if (currentFocus < 0) currentFocus = (x.length - 1);
                               x[currentFocus].classList.add("autocomplete-active");
                           }
               
                           function removeActive(x) {
                               for (var i = 0; i < x.length; i++) {
                                   x[i].classList.remove("autocomplete-active");
                               }
                           }
               
                           function closeAllLists(elmnt) {
                               var x = document.getElementsByClassName("autocomplete-items");
                               for (var i = 0; i < x.length; i++) {
                                   if (elmnt != x[i] && elmnt != inp) {
                                       x[i].parentNode.removeChild(x[i]);
                                   }
                               }
                           }
                           document.addEventListener("click", function (e) {
                               closeAllLists(e.target);
                           });
                       }
                       var states = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"];
                       var counties = ["Baker County", "Benton County", "Clackamas County", "Clatsop County", "Columbia County", "Coos County", "Crook County", "Curry County", "Deschutes County", "Douglas County", "Gilliam County", "Grant County", "Harney County", "Hood River County", "Jackson County", "Jefferson County", "Josephine County", "Klamath County", "Lake County", "Lane County", "Lincoln County", "Linn County", "Malheur County", "Marion County", "Morrow County", "Multnomah County", "Polk County", "Sherman County", "Tillamook County", "Umatilla County", "Union County", "Wallowa County", "Wasco County", "Washington County", "Wheeler County", "Yamhill County"];
                       var cities = ["Adair Village", "Adams", "Adrian", "Albany", "Aloha", "Altamont", "Amity", "Antelope", "Arlington", "Ashland", "Astoria", "Athena", "Aumsville", "Aurora", "Baker City", "Bandon", "Banks", "Barlow", "Barview", "Bay City", "Beaver", "Beaverton", "Bend", "Biggs Junction", "Boardman", "Bonanza", "Brookings", "Brooks", "Brownsville", "Bunker Hill", "Burns", "Butte Falls", "Butteville", "Canby", "Cannon Beach", "Canyon City", "Canyonville", "Cape Meares", "Carlton", "Cascade Locks", "Cave Junction", "Cayuse", "Cedar Hills", "Cedar Mill", "Central Point", "Chenoweth", "Chiloquin", "City of The Dalles", "Clackamas", "Clatskanie", "Cloverdale", "Coburg", "Columbia City", "Condon", "Coos Bay", "Coquille", "Cornelius", "Corvallis", "Cottage Grove", "Cove", "Creswell", "Culver", "Dallas", "Dayton", "Dayville", "Depoe Bay", "Deschutes River Woods", "Detroit", "Donald", "Drain", "Dufur", "Dundee", "Dunes City", "Durham", "Eagle Point", "Echo", "Elgin", "Elkton", "Enterprise", "Eola", "Estacada", "Eugene", "Fairview", "Falls City", "Florence", "Forest Grove", "Fossil", "Four Corners", "Garden Home-Whitford", "Garibaldi", "Gaston", "Gates", "Gearhart", "Gervais", "Gladstone", "Glendale", "Glide", "Gold Beach", "Gold Hill", "Gopher Flats", "Grand Ronde", "Granite", "Grants Pass", "Grass Valley", "Green", "Greenhorn", "Gresham", "Haines", "Halfway", "Halsey", "Happy Valley", "Harbeck-Fruitdale", "Harbor", "Harrisburg", "Hayesville", "Hebo", "Helix", "Heppner", "Hermiston", "Hillsboro", "Hines", "Hood River", "Hubbard", "Huntington", "Idanha", "Imbler", "Independence", "Ione", "Irrigon", "Island City", "Jacksonville", "Jefferson", "Jennings Lodge", "John Day", "Johnson City", "Jordan Valley", "Joseph", "Junction City", "Keizer", "King City", "Kirkpatrick", "Klamath Falls", "Labish Village", "Lafayette", "La Grande", "Lake Oswego", "Lakeside", "Lakeview", "La Pine", "Lebanon", "Lexington", "Lincoln Beach", "Lincoln City", "Lonerock", "Long Creek", "Lostine", "Lowell", "Lyons", "McMinnville", "Madras", "Malin", "Manzanita", "Marion", "Maupin", "Maywood Park", "Medford", "Mehama", "Merrill", "Metolius", "Metzger", "Mill City", "Millersburg", "Milton-Freewater", "Milwaukie", "Mission", "Mitchell", "Molalla", "Monmouth", "Monroe", "Monument", "Moro", "Mosier", "Mount Angel", "Mount Hood Village", "Mount Vernon", "Myrtle Creek", "Myrtle Point", "Nehalem", "Neskowin", "Netarts", "Newberg", "Newport", "North Bend", "North Plains", "North Powder", "Nyssa", "Oak Grove", "Oak Hills", "Oakland", "Oakridge", "Oatfield", "Oceanside", "Odell", "Ontario", "Oregon City", "Pacific City", "Paisley", "Parkdale", "Pendleton", "Philomath", "Phoenix", "Pilot Rock", "Pine Grove", "Pine Hollow", "Portland", "Port Orford", "Powers", "Prairie City", "Prescott", "Prineville", "Rainier", "Raleigh Hills", "Redmond", "Redwood", "Reedsport", "Richland", "Rickreall", "Riddle", "Rivergrove", "Riverside", "Rockaway Beach", "Rockcreek", "Rogue River", "Roseburg", "Roseburg North", "Rose Lodge", "Rowena", "Rufus", "St. Helens", "St. Paul", "Salem", "Sandy", "Scappoose", "Scio", "Scotts Mills", "Seaside", "Seneca", "Shady Cove", "Shaniko", "Sheridan", "Sherwood", "Siletz", "Silverton", "Sisters", "Sodaville", "South Lebanon", "Spray", "Springfield", "Stanfield", "Stayton", "Sublimity", "Summerville", "Sumpter", "Sunnyside", "Sutherlin", "Sweet Home", "Talent", "Tangent", "Terrebonne", "Three Rivers", "Tigard", "Tillamook", "Toledo", "Tri-City", "Troutdale", "Tualatin", "Turner", "Tutuilla", "Tygh Valley", "Ukiah", "Umatilla", "Union", "Unity", "Vale", "Veneta", "Vernonia", "Waldport", "Wallowa", "Wamic", "Warm Springs", "Warrenton", "Wasco", "Waterloo", "Westfir", "West Haven-Sylvan", "West Linn", "Weston", "West Slope", "Wheeler", "White City", "Willamina", "Wilsonville", "Winchester Bay", "Winston", "Woodburn", "Wood Village", "Yachats", "Yamhill", "Yoncalla"];
                       autocomplete(document.getElementById("myState"), states);
                       autocomplete(document.getElementById("myCounty"), counties);
                       autocomplete(document.getElementById("myCity"), cities);
                   </script>
               </body>
               </html>     
            </div>
        </div>
    </div>
@endsection


@push('css')
<style>


* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;
}

.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
  background-color: #e9e9e9;
}

.autocomplete-active {
  background-color: DodgerBlue !important;
  color: #ffffff;
}


.button {
  background-color: silver;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;


  display: flex;
  justify-content: center;
}


.form {
  margin: auto;
  width: fill;
  padding: 10px;
  border: black;
  border-radius: 5px;
}

</style>
@endpush