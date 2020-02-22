@extends('layouts.master')

@section('body')
    <div class="container">
        <form action = {{ route('updateAccount') }} method="POST">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputName">Name</label><input type="text" class="form-control" id="inputName"
                                                              value=" {{ Auth::user()->name }} ">
                </div>
                <div class="form-group col-md-4">
                    <label
                        for="inputEmail">Email</label><input type="email" class="form-control" id="inputEmail"
                                                             value="{{ Auth::user()->email }}">
                </div>
                <div class="form-group col-md-4">
                    <label
                        for="inputPhone">Phone Number</label><input type="tel" class="form-control" id="inputPhone"
                                                                    placeholder="(123)-456-7890">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPasswordOld1">Old Password</label><input type="password" class="form-control"
                                                                              id="inputPasswordOld1"
                                                                              placeholder="Password">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPasswordOld2">Verify Password</label>
                    <input type="password" class="form-control" id="inputPasswordOld2"
                           placeholder="Re-enter Password">
                </div>
                <div class="form-group col-md-4">
                    <label
                        for="inputPasswordNew">New Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="New Password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCompany">Company</label>
                    <input type="text" class="form-control" id="inputCompany" placeholder="Company Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputJob">Job Title</label>
                    <input type="text" class="form-control" id="inputJob" placeholder="Job">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputAddress2">Address 2</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option value="AL">AL</option>
                        <option value="AK">AK</option>
                        <option value="AR">AR</option>
                        <option value="AZ">AZ</option>
                        <option value="CA">CA</option>
                        <option value="CO">CO</option>
                        <option value="CT">CT</option>
                        <option value="DC">DC</option>
                        <option value="DE">DE</option>
                        <option value="FL">FL</option>
                        <option value="GA">GA</option>
                        <option value="HI">HI</option>
                        <option value="IA">IA</option>
                        <option value="ID">ID</option>
                        <option value="IL">IL</option>
                        <option value="IN">IN</option>
                        <option value="KS">KS</option>
                        <option value="KY">KY</option>
                        <option value="LA">LA</option>
                        <option value="MA">MA</option>
                        <option value="MD">MD</option>
                        <option value="ME">ME</option>
                        <option value="MI">MI</option>
                        <option value="MN">MN</option>
                        <option value="MO">MO</option>
                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="NC">NC</option>
                        <option value="NE">NE</option>
                        <option value="NH">NH</option>
                        <option value="NJ">NJ</option>
                        <option value="NM">NM</option>
                        <option value="NV">NV</option>
                        <option value="NY">NY</option>
                        <option value="ND">ND</option>
                        <option value="OH">OH</option>
                        <option value="OK">OK</option>
                        <option value="OR">OR</option>
                        <option value="PA">PA</option>
                        <option value="RI">RI</option>
                        <option value="SC">SC</option>
                        <option value="SD">SD</option>
                        <option value="TN">TN</option>
                        <option value="TX">TX</option>
                        <option value="UT">UT</option>
                        <option value="VT">VT</option>
                        <option value="VA">VA</option>
                        <option value="WA">WA</option>
                        <option value="WI">WI</option>
                        <option value="WV">WV</option>
                        <option value="WY">WY</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="number" class="form-control" id="inputZip">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
