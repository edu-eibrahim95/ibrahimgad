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
<!--         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                    $('a').click(function(){
                        var href = this.href;
                        href = (href.contains('medium.com')) ? href : "https://www.medium.com"+href;
                        href = href.replace('/','|');
                        window.location.href=href;
                    });
                });
        </script> -->
@endsection
@section('content')
    <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    <p style="margin:0">Ibrahim E.Gad</p>
                    <p style="font-size:30%">Software Developer / Web Developer / System Administrator</p>
                </div>
                <div class="links">
                    <a target="_blank" href="https://fb.com/eibrahim95">Facebook</a>
                    <a target="_blank" href="mailto:eibrahim95@gmail.com">Gmail</a>
                    <a target="_blank" href="http://pph.me/eibrahim95">PPh</a>
                    <a target="_blank" href="https://www.upwork.com/o/profiles/users/_~015698b772be113d77/">Upwork</a>
                    <a target="_blank" href="https://github.com/eibrahim95">GitHub</a>
                </div>
            </div>
        </div>
    <!--<iframe style="width:99%;height:500px;" src="https://medium.com/"><p>Your browser does not support iframes.</p></iframe>-->
    {!! $homepage !!}
@endsection
@section('footer')
<script>
    function openlink(link){
        //alert(link);
        link = (link.indexOf('/') != 0) ? link : "https://www.medium.com"+link;
        link = (link.indexOf('https://') != -1 || link.indexOf('http://') != -1 || link.indexOf('mailto:') != -1) ? link : "https://"+link;
        link = "http://ibrahimgad.com/medium?url="+link;
        //alert(link);
        window.location.href=link;
        return false;
    }
        var ass = document.getElementsByTagName('a');
        for (i=0; i<ass.length; i++){
            ass[i].setAttribute('onclick', 'openlink(this.getAttribute("href"));return false;');
        }
</script>
@endsection