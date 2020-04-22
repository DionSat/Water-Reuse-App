Click here to reset password <br>
<a href="{{$link = url('passwords/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()}}">{{$link}}</a>