@extends('layouts.master')
@section('body')
    <div class="container">
        <h3 class="my-3 text-center">
            Create a Water Reuse Permit App Account
        </h3>
        <hr>
        <form method="POST" action="{{ route('register') }}" class="mt-5">
            @csrf
                <div class="form-group">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="form-group col-md-6">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label for="email"
                               class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="form-group col-md-6">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password"
                               class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                               class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0 mt-5">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Register
                        </button>
                    </div>
                </div>


            <div class="text-center mt-5">
                <h3 class="mt-3 mb-0"> Optional Fields</h3>
                <div class="text-light"> This information isn't required, but would be very helpful to us. </div>
                <hr>
            </div>

            <div class="form-group row">
                        <label for="primaryAddress"
                               class="col-md-4 col-form-label text-md-right">{{ __('Street Address') }}</label>
                        <div class="col-md-6">
                            <input id="primaryAddress" type="text" class="form-control"
                                   name="streetAddress"
                                   autocomplete="street-address">
                            @error('primaryAddress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="secondAddress"
                               class="col-md-4 col-form-label text-md-right">{{ __('Secondary Address (Apartment #, Room #, etc..)') }}</label>
                        <div class="col-md-6">
                            <input id="secondAddress" type="text" class="form-control"
                                   name="streetAddress2">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="city"
                               class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                        <div class="col-md-2">
                            <input id="City" type="text"
                                   class="form-control @error('city') is-invalid @enderror" name="city"
                                   value="{{ old('name') }}" autocomplete="city" autofocus>

                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label for="state"
                               class=" col-sm-2 col-form-label text-md-right">{{ __('State') }}</label>
                        <div class="col-sm-2">

                            <select class="form-control" name="state" id="state">
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
                    </div>

                    <div class="form-group row ">
                        <label for="zipCode"
                               class="col-md-4 col-form-label text-md-right">{{ __('Zip Code') }}</label>
                        <div class="col-md-6">
                            <input id="zipCode" type="number" class="form-control" name="zipCode"
                                   autocomplete="zip-code">
                            @error('zipCode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="job"
                               class="col-md-4 col-form-label text-md-right">{{ __('Job Title') }}</label>
                        <div class="col-md-6">
                            <input id="jobTitle" type="text" class="form-control" name="jobTitle"
                                   autocomplete="job-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="company"
                               class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>
                        <div class="col-md-6">
                            <input id="company" type="text" class="form-control" name="company">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reason"
                               class="col-md-4 col-form-label text-md-right"> Why are you using this website? </label>
                        <div class="col-md-6">
                            <input id="reason" type="text" class="form-control" name="reason"
                                   autocomplete="reason">
                        </div>
                    </div>


                    <div class="form-group row ">
                        <label for="countryCode"
                               class="col-md-4 col-form-label text-md-right">{{ __('Country Code') }}</label>
                        <div class="col-md-2"><input id="countryCode" type="text" class="form-control"
                                                     name="countryCode"></div>
                        <label for="phone"
                               class="col-sm-2 col-form-label text-md-right">{{ __('Phone number') }} (Format: xxxxxxxxxx) </label>
                        <div class="col-md-2">
                            <input id="phone" type="tel" class="form-control" name="phoneNumber" pattern="(([0-9]{3})([0-9]{3})([0-9]{4}))">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="btn-group btn-group-toggle col-form-label col-sm-6 offset-md-4"
                             data-toggle="buttons">
                            <label class="btn btn-outline-success">
                                <input type="radio" name="contactOption" id="notifOn" autocomplete="off"
                                       value="1"> Contact me (email newsletter, etc..)
                            </label>
                            <label class="btn btn-outline-success">
                                <input type="radio" name="contactOption" id="notifOff" autocomplete="off"
                                       value="0" checked> Do not contact me
                            </label>
                        </div>
                        @error('contactOption')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


        </form>
    </div>

@endsection


@push("css")
    <style>
        h3,label{
            color: white;
        }
    </style>
@endpush
