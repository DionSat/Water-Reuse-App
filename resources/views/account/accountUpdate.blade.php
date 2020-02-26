@extends('layouts.master')

@section('body')
    <div class="container">
        @if(session('nothing'))
            <div class="alert alert-warning" role="alert">
                {{ session('nothing') }}
            </div>
        @endif
        <form action={{ route('updateAccount') }} method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputName">Name</label><input type="text" class="form-control" name="inputName"
                                                                  value="{{ Auth::user()->name }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label
                            for="inputEmail">Email</label><input type="email" class="form-control" name="inputEmail"
                                                                 value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label
                            for="inputPhone">Phone Number</label><input type="tel" class="form-control"
                                                                        name="inputPhone"
                                                                        value="{{Auth::user()->phoneNumber}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCompany">Company</label>
                        <input type="text" class="form-control" name="inputCompany" value="{{Auth::user()->company}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputJob">Job Title</label>
                        <input type="text" class="form-control" name="inputJob" value="{{Auth::user()->jobTitle}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Street Address</label>
                        <input type="text" class="form-control" name="inputAddress"
                               value="{{Auth::user()->streetAddress}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Address 2 (Apt #, Suite #, Room #, etc..)</label>
                        <input type="text" class="form-control" name="inputAddress2" value="{{Auth::user()->address2}}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" name="inputCity" value="{{Auth::user()->city}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select name="inputState" class="form-control" value="{{Auth::user()->state}}">
                            <option value></option>
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
                        <input type="number" class="form-control" name="inputZip" value="{{Auth::user()->zipCode}}">
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-md-6">
                        <label for="RecodeUse">Reason for Recode Usage</label>
                        <input type="text" class="form-control" name="RecodeUse" placeholder="Why do you use Recode?">
                    </div>
                </div>
                <div class="form-row col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="contactCheck" name="contact" value="True"
                               checked>
                        <label class="form-check-label" for="contactCheck">We can contact you</label>
                    </div>
                </div>

                <div class="form row p-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
