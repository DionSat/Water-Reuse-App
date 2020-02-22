@if (session('alert'))
    <div class="alert alert-{{ session('alert') }}">
        @if (session('alertMessage'))
            {!! session('alertMessage') !!}
        @endif
    </div>
@endif