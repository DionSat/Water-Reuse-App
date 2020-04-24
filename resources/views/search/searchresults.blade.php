@extends("layouts.master")

@section('body')
    <div class="container">


    @foreach($allSubmissions as $submission)
        @include('common/reuse-item', ['item'=>$submission])
    @endforeach
  
    </div>
@endsection

