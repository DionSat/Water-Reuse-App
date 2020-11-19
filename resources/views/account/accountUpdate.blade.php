@extends('layouts.master')

@section('body')
    <div class="container">
        @if(session('nothing'))
            <div class="alert alert-warning" role="alert">
                {{ session('nothing') }}
            </div>
        @endif
        <div class="card" style="border: none; text-align: center;color: white; background-color: transparent;">
            <h3>Account Update</h3>
            <br>
        </div>
        <form action={{ route('updateAccount') }} method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputName">Name</label><input type="text" class="form-control" name="inputName"
                                                                  value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label
                            for="inputEmail">Email</label><input type="email" class="form-control" name="inputEmail"
                                                                 value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="countryCode">Country Code</label>
                        <input type="text" class="form-control" name="countryCode" value="{{$user->countryCode}}">
                    </div>
                    <div class="form-group col-md-2">
                        <nobr><label for="inputPhone">Phone Number</label></nobr>
                        <input type="tel" class="form-control" name="inputPhone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" value="{{$user->phoneNumber}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCompany">Company</label>
                        <input type="text" class="form-control" name="inputCompany" value="{{$user->company}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputJob">Job Title</label>
                        <input type="text" class="form-control" name="inputJob" value="{{$user->jobTitle}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Street Address</label>
                        <input type="text" class="form-control" name="inputAddress"
                               value="{{$user->streetAddress}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Address 2 (Apt #, Suite #, Room #, etc..)</label>
                        <input type="text" class="form-control" name="inputAddress2" value="{{$user->address2}}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" name="inputCity" value="{{$user->city}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select name="inputState" class="form-control">
                          <option value="{{$user->state}}" selected>{{$user->state}}</option>
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
                        <input type="text" class="form-control" name="inputZip" value="{{$user->zipCode}}" pattern="\d{5}-?(\d{4})?">
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-md-6">
                        <label for="RecodeUse">Reason for Recode Usage</label>
                        <input type="text" class="form-control" name="RecodeUse" placeholder="Why do you use Recode?">
                    </div>
                    <div class="form-group col-md-6">
                        <p>Permission to contact </p>

                        @if($user->can_contact === true)

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="contact" value="true" id="yes-contact" checked>
                          <label class="form-check-label" for="yes-contact">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="contact" value="false" id="no-contact">
                          <label class="form-check-label" for="no-contact">No</label>
                        </div>

                      @else
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="contact" value="true" id="else-yes-contact">
                          <label class="form-check-label" for="else-yes-contact">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="contact" value="false" id="else-no-contact" checked>
                          <label class="form-check-label" for="else-no-contact">No</label>
                        </div>
                        <label>
                        @endif
                    </div>
                </div>

                <div class="form row p-3">
                    <button type="submit" class="btn btn-primary" style="margin-right: 30px">Save</button>
                    <button type="button" class="btn btn-primary" onclick="window.location='{{ route("account") }}'" >Back</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
        #contactButton {
            padding-left: 6px;
        }

        #contactLabel {
            font-size: 20px;
            padding-left: 20px;
        }
        label{
            color: white;
        }
        p{
            color: white;
        }
    </style>
@endpush
