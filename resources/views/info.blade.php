@extends('layouts.master')

@section('body')
    <div class="container" id="container">
        @guest
        <nav>
                <div class="nav nav-tabs" id="nav-tab-base" role="tablist">
                    <a class="nav-item nav-link active" id="nav-searchGuest-tab" data-toggle="tab" href="#nav-searchGuest" role="tab" aria-controls="nav-searchGuest" aria-selected="true">Search for a Regulation</a>
                    <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Become a Contributor</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-searchGuest" role="tabpanel" aria-labelledby="nav-searchGuest-tab">
                <h2>How to Search for a Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('search') }}" target="_blank"> Search </a>page</p>
                <img src="img/search_start.gif">
                <p>2. Select either 'Commercial' or 'Residential'</p>
                <img src="img/searchExampleGIF2.gif">
                <p>Choose between either searching by Address or Searching by County, City, State</p>
                <img src="img/undermaintenance.png">
                <h4> Search by County, City, State</h4>
                <p>First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu. After selecting the region you wish to search for, click on the 'Search' button.</p>
                <img src="img/searchExampleGIF3.gif">
                <h4> Search Result</h4>
                <p><b>Tabular Result:</b> The results page will show a tabular results for the incentives, codes, and permits of the City, County State. </p>
                <img src="img/searchExampleGIF4.gif">
                <p>To narrow down the results even further you can select a source and destination in the dropdown menues.</p>
                <img src="img/searchExampleGIF5.gif">
                <p><b>Graphical Result:</b> To view the graphical result: click on the top right button View Diagram. </p>
                <img src="img/view_diagramExample.png">
                <h5>To Be Continued...</h5>
                <h4>Disclaimer</h4>
                <p>If the state, county or city does not have any water reuse information, or if the state, county or city is not present in the search dropdown menus, this does not mean there are no regulations. It just means they have not been added to this site. Please search your local government web pages to find the water reuse information you need. After finding that information, it would be helpful to us if you <a href="{{ route('register') }}">register</a> to become a contributor, and add this regulation to our site.</p>
                <a href="#nav-tab-base">Back to Top</a>
            </div>
            <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                <h2>Register to Add Water Reuse Regulations</h2>
                <p>1. Navigate to the <a href="{{ route('register') }}" target="_blank">'Register' </a>page</p>
                <p>2. Enter in your name, a valid email address and a password.</p>
                <img src="img/registerExample.png">
                <p>3. At this point, you can either click the 'Register' button, or you can add more information about yourself before you register. This information is very helpful to us, but it is not necessary.</p>
                <img src="img/registerExample1.png">
                <p>3. After submitting your registration, you can add new water reuse regulations! Come back to the information page, as there will be new instructions on how to add a new regulation made available to you.</p>
                <a href="#nav-tab-base">Back to Top</a>
            </div>
        </div>
        @endguest
        @if (Auth::check() && Auth::user()->is_admin)
            <nav>
                <div class="nav nav-tabs" id="nav-tab-admin" role="tablist">
                    <a class="nav-item nav-link active" id="nav-search-tab" data-toggle="tab" href="#nav-search" role="tab" aria-controls="nav-search" aria-selected="true">Search for a Regulation</a>
                    <a class="nav-item nav-link" id="nav-addReg-tab" data-toggle="tab" href="#nav-addReg" role="tab" aria-controls="nav-addReg" aria-selected="false">Add a New Regulation</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Administrator Information</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-search" role="tabpanel" aria-labelledby="nav-search-tab">
                <h2>How to Search for a Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('search') }}" target="_blank"> Search </a>page</p>
                <img src="img/search_start.gif">
                <p>2. Select either 'Commercial' or 'Residential'</p>
                <img src="img/searchExampleGIF2.gif">
                <p>Choose between either searching by Address or Searching by County, City, State</p>
                <img src="img/undermaintenance.png">
                <h4> Search by County, City, State</h4>
                <p>First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu. After selecting the region you wish to search for, click on the 'Search' button.</p>
                <img src="img/searchExampleGIF3.gif">
                <h4> Search Result</h4>
                <p><b>Tabular Result:</b> The results page will show a tabular results for the incentives, codes, and permits of the City, County State. </p>
                <img src="img/searchExampleGIF4.gif">
                <p>To narrow down the results even further you can select a source and destination in the dropdown menues.</p>
                <img src="img/searchExampleGIF5.gif">
                <p><b>Graphical Result:</b> To view the graphical result: click on the top right button View Diagram. </p>
                <img src="img/view_diagramExample.png">
                <h5>To Be Continued...</h5>
                <h4>Disclaimer</h4>
                <p>If the state, county or city does not have any water reuse information, or if the state, county or city is not present in the search dropdown menus, this does not mean there are no regulations. It just means they have not been added to this site. Please search your local government web pages to find the water reuse information you need. After finding that information, it would be helpful to us if you <a href="{{ route('register') }}">register</a> to become a contributor, and add this regulation to our site.</p>
                <a href="#nav-tab-base">Back to Top</a>
            </div>
            <div class="tab-pane fade" id="nav-addReg" role="tabpanel" aria-labelledby="nav-addReg-tab">
                <h2>Add a New Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('userSubmission') }}" target="_blank">'Submit New Regulation' </a>page</p>
                <p>2. At the very least, enter the State you wish to submit a regulation for. You can also select a County and City, but that is not a requirement.</p>
                <img src="img/regSubmitExample.png">
                <p>3. You may also enter a new county or city by clicking the 'Add A New State, County or City' button, and entering the new county and / or city name.</p>
                <img src="img/regSubmitExample1.png">
                <p>3. Select a source and a destination, and select the water reuse allowance (is allowed, not allowed, maybe allowed).</p>
                <img class="smallRec" src="img/regSubmitExample2.png">
                <p>4. Add optional links to the water reuse regulation, and / or an optional comment about the regulation.</p>
                <img class="smallRec" src="img/regSubmitExample3.png">
                <p>5. Either click "Submit" if you only have one source and destination, or click the "Add another regulation" button, and repeat steps 3 - 4.</p>
                <img class="smallRec" src="img/regSubmitExample4.png">
                <p>6. After submiting your new regulation, you should see a success message. If you receive an error, please contact the administrator to solve the issue.</p>
                <img  src="img/regSubmitExample5.png">
                <br>
                <a href="#nav-tab-admin">Back to Top</a>
            </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="container" id="adminContainer">
                            <ul>
                                <li>
                                    <a href="#userManip">User Actions</a>
                                    <ul>
                                        <li>
                                            <a href="#addAdmin">Add / Remove Administrator Privileges</a>
                                        </li>
                                        <li>
                                            <a href="#emailUsers">Send Emails to Users</a>
                                        </li>
                                        <li>
                                            <a href="#emailAdmin">Schedule an Administrative Summary Email</a>
                                        </li>
                                        <li>
                                            <a href="#banUser">Ban and Unban a User</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#regulation">Approve or Deny a New Regulation</a>
                                </li>
                                <li>
                                    <a href="#deleteReg">Delete / Edit a Regulation</a>
                                </li>
                                <li>
                                    <a href="#deleteArea">Delete / Edit a State, County or City</a>
                                </li>
                            </ul>
                            <hr id="userManip">
                            <h2>User Actions</h2>
                                <h4 id="addAdmin">Add / Remove Administrator Privileges</h4>
                                    <p>1. Navigate to the <a href="{{ route('admin') }}" target="_blank">'Administrator Dashboard' </a>page.</p>
                                    <p>2. From here, click on the 'view' button under 'All Users'.</p>
                                    <img src="img/banExample.png">
                                    <p>3. Now you can either scroll through the list / pages of users, you could search the current page of users with the 'Search Current Page' option or you can narrow down the search by searching the entire database of users with the 'Search Database' option</p>
                                    <img class="smallRec" src="img/banExample1.png">
                                    <p>4. Once you have found the user you wish to ban, click the 'Toggle Admin' button.</p>
                                    <img class="smallRec" src="img/toggleAdminExample.png">
                                    <p>5. You should now see either a green check mark or a red 'x', the former meaning the user has administrator privileges, and the later meaning they do not.</p>
                                    <img class="smallRec" src="img/toggleAdminExample1.png">
                                    <br>
                                    <a href="#nav-tab-admin">Back to Top</a>
                                <hr id="emailUsers">
                                <h4 style="margin-top: 1em;">Email Users</h4>
                                    <p>1. Navigate to the <a href="{{ route('admin') }}" target="_blank">'Administrator Dashboard' </a>page.</p>
                                    <p>2. From here, click on the 'view' button under 'All User Emails'.</p>
                                    <img src="img/userEmailExample.png"></img>
                                    <p>3. You will now see that there are two options. You can either email consenting users (preferred), or you can email all users. Generally, you only want to email non-consenting users if it is an absolute emergency.</p>
                                    <img src="img/userEmailExample1.png"></img>
                                    <p>4. Once you have chosen which user base to email, your default email software will open up on your computer prefilled with a list of user emails. If you do not have email capable software installed, we suggest to install one to use this functionality.</p>
                                    <br>
                                    <a href="#nav-tab-admin">Back to Top</a>
                                <hr id="emailAdmin">
                                <h4 style="margin-top: 1em;">Schedule an Administrative Summary Email</h4>
                                    <p>This will send an email with a summary of all pending administrator duties, such as approving a regulation.</p>
                                    <p>1. Navigate to the <a href="{{ route('admin') }}" target="_blank">'Administrator Dashboard' </a>page.</p>
                                    <p>2. From here, click on the 'view' button under 'Scheduled Emails'.</p>
                                    <img src="img/emailAdminExample.png"></img>
                                    <p>3. You may now select which administrator to email under the 'Admin User' dropdown. Your username will be selected by default. You can also select how often you would want your email sent in the 'How often (in days)' edit box.</p>
                                    <img class="smallRec" src="img/emailAdminExample1.png"></img>
                                    <p>4. Once you click the 'Schedule' button, an email containing administrative information will be sent at 10am every number of days specified by you.</p>
                                    </br>
                                    <a href="#nav-tab-admin">Back to Top</a>
                                <hr id="banUser">
                                <h4 style="margin-top: 1em;">Ban and Unban a User</h4>
                                    <p>1. Navigate to the <a href="{{ route('admin') }}" target="_blank">'Administrator Dashboard' </a>page.</p>
                                    <p>2. From here, click on the 'view' button under 'All Users'.</p>
                                    <img src="img/banExample.png"></img>
                                    <p>3. Now you can either scroll through the list / pages of users, you could search the current page of users with the 'Search Current Page' option or you can narrow down the search by searching the entire database of users with the 'Search Database' option</p>
                                    <img class="smallRec" src="img/banExample1.png"></img>
                                    <p>4. Once you have found the user you wish to ban, click the 'ban user' button.</p>
                                    <img class="smallRec" src="img/banExample2.png"></img>
                                    <p>5. You should now receive a message showing that the user was succesfully banned, and they will not appear in the list of users.</p>
                                    <img class="smallRec" src="img/banExample3.png"></img>
                                    <p>7. You can then 'unban' a user under the 'Banned Users' view of the Administrator Dashboard.</p>
                                    <img src="img/banExample4.png"></img>
                                    <img class="smallRec" src="img/banExample5.png"></img>
                                    </br>
                                    <a href="#nav-tab-admin">Back to Top</a>
                            <hr id="regulation">
                            <h2>Approve or Deny a New Regulation</h2>
                                <p>1. Navigate to the <a href="{{ route('adminUserSubmissionView') }}" target="_blank">'Submissions' </a>page.</p>
                                <p>2. From here you should see three options showing the count of pending State, County and City regulation submissions. Choose the area level you wish to approve for. For this example, we will be approving a State level submission, but these steps apply to County and City as well.</p>
                                <img src="img/regulationExample.png"></img>
                                <p>3. You should now see a list of regulations awaiting approval. To review the submission, click the 'view' button, to decline the submission click the 'Decline' button and to approve the submission, click the 'Approve' button.</p>
                                <img class="smallRec" src="img/regulationExample1.png"></img>
                                <h4>Disclamer</h4>
                                <p>The system is set up in a way that if you approve a new or non-existing area, this area will be created.</p>
                                </br>
                                </br>
                                <a href="#nav-tab-admin">Back to Top</a>
                            <hr id="deleteReg">
                            <h2>Delete / Edit a Regulation</h2>
                                <p>1. Navigate to the <a href="{{ route('search') }}" target="_blank"> Search </a>page</p>
                                <p>2. Select either 'Commercial' or 'Residential'</p>
                                <img src="img/searchExample.png"></img>
                                <p>3. First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu.</p>
                                <img src="img/searchExample1.png"></img>
                                <p>4. After selecting the region you wish to search for, click on the 'Search' button.</p>
                                <img src="img/searchExample2.png"></img>
                                <p>5. At this point, you can either scroll through the search results, or narrow them down by selecting a source and destination in the dropdown menues.</p>
                                <img src="img/searchExample3.png"></img>
                                <p>6. Once you have found the regulation you wish to delete, click the 'view' button</p>
                                <p>7. From this page, you can either delete or edit a regulation by clicking the associated buttons.</p>
                                <img src="img/deleteRegExample.png"></img>
                                </br>
                                <a href="#nav-tab-admin">Back to Top</a>
                            <hr id="deleteArea">
                            <h2>Delete a State, County or City</h2>
                                <p>1. Navigate to the <a href="{{ route('admin') }}" target="_blank">'Administrator Dashboard' </a>page.</p>
                                <p>2. Click on the 'Database' button to switch to the database view.</p>
                                <img src="img/deleteExample.png"></img>
                                <p>3. You should now see display boxes for Cities, Counties and States. If you wish to add a new area, click '+Add', but if you wish to edit or delete an area, click 'Manage'</p>
                                <img src="img/deleteAreaExample.png"></img>
                                <p>4. From the 'Manage' screen, you will see button options to either 'Delete', if you wish to remove an area, or 'Modify', if you just need to edit the area.</p>
                                <img src="img/deleteAreaExample1.png"></img>
                                </br>
                                <a href="#nav-tab-admin">Back to Top</a>
                        </div>
                </div>
            </div>
        @elseif(Auth::check())
        <nav>
                <div class="nav nav-tabs" id="nav-tab-mid" role="tablist">
                    <a class="nav-item nav-link active" id="nav-searchContrib-tab" data-toggle="tab" href="#nav-searchContrib" role="tab" aria-controls="nav-searchContrib" aria-selected="true">Search for a Regulation</a>
                    <a class="nav-item nav-link" id="nav-addRegContrib-tab" data-toggle="tab" href="#nav-addRegContrib" role="tab" aria-controls="nav-addRegContrib" aria-selected="false">Add a New Regulation</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-searchContrib" role="tabpanel" aria-labelledby="nav-search-tab">
                <h2>How to Search for a Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('search') }}" target="_blank"> Search </a>page</p>
                <img src="img/search_start.gif">
                <p>2. Select either 'Commercial' or 'Residential'</p>
                <img src="img/searchExampleGIF2.gif">
                <p>Choose between either searching by Address or Searching by County, City, State</p>
                <img src="img/undermaintenance.png">
                <h4> Search by County, City, State</h4>
                <p>First select a state in the dropdown menu, then you can either search only by state, or by county or city by selecting them in the dropdown menu. After selecting the region you wish to search for, click on the 'Search' button.</p>
                <img src="img/searchExampleGIF3.gif">
                <h4> Search Result</h4>
                <p><b>Tabular Result:</b> The results page will show a tabular results for the incentives, codes, and permits of the City, County State. </p>
                <img src="img/searchExampleGIF4.gif">
                <p>To narrow down the results even further you can select a source and destination in the dropdown menues.</p>
                <img src="img/searchExampleGIF5.gif">
                <p><b>Graphical Result:</b> To view the graphical result: click on the top right button View Diagram. </p>
                <img src="img/view_diagramExample.png">
                <h5>To Be Continued...</h5>
                <h4>Disclaimer</h4>
                <p>If the state, county or city does not have any water reuse information, or if the state, county or city is not present in the search dropdown menus, this does not mean there are no regulations. It just means they have not been added to this site. Please search your local government web pages to find the water reuse information you need. After finding that information, it would be helpful to us if you <a href="{{ route('register') }}">register</a> to become a contributor, and add this regulation to our site.</p>
                <a href="#nav-tab-base">Back to Top</a>
            </div>
            <div class="tab-pane fade" id="nav-addRegContrib" role="tabpanel" aria-labelledby="nav-addRegContrib-tab">
                <h2>Add a New Regulation</h2>
                <p>1. Navigate to the <a href="{{ route('userSubmission') }}" target="_blank">'Submit New Regulation' </a>page</p>
                <p>2. At the very least, enter the State you wish to submit a regulation for. You can also select a County and City, but that is not a requirement.</p>
                <img src="img/regSubmitExample.png">
                <p>3. You may also enter a new county or city by clicking the 'Add A New State, County or City' button, and entering the new county and / or city name.</p>
                <img src="img/regSubmitExample1.png">
                <p>3. Select a source and a destination, and select the water reuse allowance (is allowed, not allowed, maybe allowed).</p>
                <img class="smallRec" src="img/regSubmitExample2.png">
                <p>4. Add optional links to the water reuse regulation, and / or an optional comment about the regulation.</p>
                <img class="smallRec" src="img/regSubmitExample3.png">
                <p>5. Either click "Submit" if you only have one source and destination, or click the "Add another regulation" button, and repeat steps 3 - 4.</p>
                <img class="smallRec" src="img/regSubmitExample4.png">
                <p>6. After submiting your new regulation, you should see a success message. If you receive an error, please contact the administrator to solve the issue.</p>
                <img  src="img/regSubmitExample5.png">
                <br>
                <a href="#nav-tab-mid">Back to Top</a>
            </div>
            </div>
        @endif

    </div>


@endsection

@push("css")
    <style>
        .py-4 {
            text-align: center;
        }
        ul{
            text-align: left;
        }
        img{
            width: 647px;
            height: 400px;
            border: 1px solid black !important;
        }
        #nav-addReg, #nav-search, #nav-admin, #nav-searchGuest, #nav-register, #nav-addRegContrib, #nav-searchContrib, #nav-contact, #adminContainer{
            margin: 1.5em 0;
        }
        #nav-addReg > *, #nav-search > *, #nav-admin > *, #nav-searchGuest > *, #nav-register > *, #nav-addRegContrib > *, #nav-searchContrib > *, #adminContainer > *{
            margin: 1.5em 0;
        }
        .smallRec{
            height: 200px;
        }
        #nav-contact{
            margin: 2em 0;
        }
        hr{
            background-color: black;
            border: none;
        }
        @media only screen and (max-width: 774px)
        {
            img{
                width: 323.5px;
                height: 200px;
                border: 1px solid black !important;
            }
            .smallRec{
                height: 100px;
            }
        }
    </style>
@endpush
