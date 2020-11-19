@extends('layouts.master')
@section('body')
  <div class="container">
    <h3 class="my-3 text-center">
      Create a Water Reuse Permit App Account
    </h3>
    <hr>
    <form method="POST" action="{{ route('register') }}" class="mt-5 form">
      @csrf
      <div class="form-row justify-content-center">
        <div class="form-group col-lg-5">
          <label for="name">{{ __('Name') }}*</label>

          <input id="name" type="text"
                 class="form-control @error('name') is-invalid @enderror" name="name"
                 value="{{ old('name') }}" required autocomplete="name" autofocus>

          @error('name')
          <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}*</strong>
                                </span>
          @enderror
        </div>
        <div class="form-group col-lg-5">
          <label for="email">{{ __('E-Mail Address') }}*</label>
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
      <div class="form-row justify-content-center">
        <div class="form-group col-lg-5">
          <label for="password">{{ __('Password') }}*</label>
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

        <div class="form-group col-lg-5">
          <label for="password-confirm">{{ __('Confirm Password') }}*</label>
          <input id="password-confirm" type="password" class="form-control"
                 name="password_confirmation" required autocomplete="new-password">
        </div>
      </div>


      <div class="text-center mt-3">
        <h3 class="mt-3 mb-0 mr-3 d-inline-block"> Optional Fields</h3>
        <p class="text-light d-inline-block"> This information isn't required, but would be very helpful to us.</p>
        <hr>
      </div>

      <div class="form-row justify-content-center">
        <div class="form-group col-lg-5">
          <label for="job">{{ __('Job Title') }}</label>
          <input id="jobTitle" type="text" class="form-control" name="jobTitle"
                 autocomplete="job-title">
        </div>

        <div class="form-group col-lg-5">
          <label for="company">{{ __('Company') }}</label>
          <input id="company" type="text" class="form-control" name="company">
        </div>
      </div>

      <div class="form-row justify-content-center">
        <div class="form-group col-lg-5">
          <label for="primaryAddress">{{ __('Street Address') }}</label>
          <input id="primaryAddress" type="text" class="form-control"
                 name="streetAddress"
                 autocomplete="street-address">
          @error('primaryAddress')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
        </div>

        <div class="form-group col-lg-5">
          <label for="secondAddress">{{ __('Secondary Address (Apartment #, Room #, etc..)') }}</label>
          <input id="secondAddress" type="text" class="form-control"
                 name="streetAddress2">
        </div>
      </div>

      <div class="form-row justify-content-center">
        <div class="form-group col-lg-3">
          <label for="city">{{ __('City') }}</label>
          <input id="City" type="text"
                 class="form-control @error('city') is-invalid @enderror" name="city"
                 value="{{ old('name') }}" autocomplete="city" autofocus>

          @error('city')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
        </div>
        <div class="form-group col-lg-1">
          <label for="state">{{ __('State') }}</label>
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

        <div class="form-group col-lg-2">
          <label for="zipCode">{{ __('Zip Code') }}</label>
          <input id="zipCode" type="text" class="form-control" name="zipCode"
                 autocomplete="zip-code" pattern="\d{5}-?(\d{4})?">
          @error('zipCode')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
        </div>

        <div class="form-group col-lg-2">
          <label for="countryCode">{{ __('Country Code') }}</label>
          <input id="countryCode" type="text" class="form-control" name="countryCode">
        </div>
        <div class="form-group col-lg-2">
          <label for="phone">{{ __('Phone number') }}</label>
          <input id="phone" type="tel" class="form-control" name="phoneNumber">
          @error('phone')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
        </div>
      </div>


      <div class="form-row justify-content-center">
        <div class="form-group col-lg-5">
          <label for="reason"> Why are you using this website? </label>
          <input id="reason" type="text" class="form-control" name="reason"
                 autocomplete="reason">
        </div>
        <div class="form-group col-lg-5">
          <p class="text-white">Permission to contact</p>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="contact" value="true" id="yes-contact" checked>
            <label class="form-check-label" for="yes-contact">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="contact" value="false" id="no-contact">
            <label class="form-check-label" for="no-contact">No</label>
          </div>
          @error('contactOption')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
        </div>
      </div>


      <div class="form-row justify-content-center">
        <button type="submit" class=" col-md-3 btn btn-primary btn-lg btn-block">Register</button>
      </div>
    </form>
  </div>

@endsection


@push("css")
  <style>
    h3, label {
      color: white;
    }
  </style>
@endpush
