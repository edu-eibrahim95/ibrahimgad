@extends('layouts.app')
@section('head')
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
@endsection
@section('content')
    <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Ibrahim E.Gad
                </div>
                <h1>Software Developer / Web Developer / System Administrator</h1>
                <div class="links">
                    <a href="https://fb.com/eibrahim95">Facebook</a>
                    <a href="mailto:eibrahim95@gmail.com">Gmail</a>
                    <a href="https://pph.me/eibrahim95">PPh</a>
                    <a href="https://www.upwork.com/o/profiles/users/_~015698b772be113d77/">Upwork</a>
                    <a href="https://github.com/eibrahim95">GitHub</a>
                </div>
            </div>
        </div>
    <!--<iframe style="width:99%;height:500px;" src="https://medium.com/"><p>Your browser does not support iframes.</p></iframe>-->
    {!! $homepage !!}
@endsection