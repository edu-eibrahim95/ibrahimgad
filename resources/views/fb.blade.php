@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 ">
            <div class="panel panel-default">
            
                <div class="panel-heading">{{ Auth::user()->name }}</div>
  
            </div>
        </div>
      
             
                <div id="fb" class="col-md-8 panel tab-pane fade in ">
                    <div class="panel-body">
                        @if (Auth::user()->facebook_id == NULL)
                            <meta name="_token" content="{{ csrf_token() }}">
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                            <p>Not Connected to Facebook<span id="btn-login" class="pull-right"><button class="btn btn-primary" >Connect Now</button></span></p>

                            @if (App::environment() != 'local')
                                <script src="{{ secure_asset('js/facebook_connect.js') }}"></script>
                            @else
                                <script src="{{ asset('js/facebook_connect.js') }}"></script>
                            @endif
                        @else
                            <p>Connected to Facebook<a target="_blank" href="/facebook/disconnect"><span id="btn-login" class="pull-right"><button class="btn btn-primary" >Disconnect</button></span></a></p>
                            @foreach($graphNode as $edge)
                                <p>{{ $edge['message'] }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
               

                
        </div>
    </div>
</div>
@endsection