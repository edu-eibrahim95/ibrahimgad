@extends('layouts.app')
@section('head')
<style>
	body {
		background: #666;
	}
	.video-wid .video-img {
		width:100%;
		height:100%;
	}
	.video-wid .video-play {
		/*display: none;*/
		border-radius: 40px;
		position: absolute;
		top:48px;
		left:calc(50% - 32px);
		cursor: pointer;
	}
	.video-wid .video-play:hover {
		background: black;
	}
	.video-wid .video-img:hover + .video-play{
		cursor: pointer;
		background: black;
	}
	.video-wid {
		margin: 5px 0;
	}
	.modal-content {
		background: black;
		text-align: center;
		padding:50px;
	}
	@media (min-width: 1200px) {
		.fixed-height{
			height:160px !important;
		}
		#video-player #player-frame{
			width: 650px;
			height: 400px;
		}
	}
</style>
@endsection
@section('content')
<div class="container">
	<div class="row">
		@foreach($moments as $moment)
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 fixed-height video-wid">
				<img class="video-img" src="{{json_decode($moment->video)->image}}" title="{{$moment->title}}">
				<img class="video-play" data-id="$momet->id" data-link="{{json_decode($moment->video)->url}}" src="{{asset('images/play.png')}}">
			</div>
		@endforeach
	</div>
	{{ $moments->links() }}
</div>

<div id="play-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div id="video-player">
      	<iframe id="player-frame" src="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

      	{{-- <iframe src="https://player.vimeo.com/video/248801073" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<p><a href="https://vimeo.com/248801073">Peter Parker asking Gwen Stacy to go out with him.</a> from <a href="https://vimeo.com/user77856464">Ibrahim E.Gad</a> on <a href="https://vimeo.com">Vimeo</a>.</p> --}}
      </div>
    </div>
  </div>
</div>

@endsection
@section('footer')
<script type="text/javascript">
	$('.navbar-fixed-top').removeClass('navbar-default');
	$('.navbar-fixed-top').addClass('navbar-inverse');

	$('.video-play').click(function() {
		var link = $(this).attr('data-link').replace('vimeo.com', 'player.vimeo.com/video').replace('youtube.com/watch?v=', 'youtube.com/embed/');
		if(link == $('#play-modal').find('#player-frame').attr('src')) {
			$('.ytp-play-button').click();
  			$('button.play').click();
		}
		else
			$('#play-modal').find('#player-frame').attr('src',  link);
		$('#play-modal').modal();
	});
	$('#play-modal').on('hide.bs.modal', function (e) {
  		
  	});
</script>
@endsection