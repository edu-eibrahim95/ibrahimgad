@extends('layouts.app')
@section('head')
<title> Scenes </title>
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
	#player-div {
		height:400px;background:black;
		text-align: center;
		padding:20px 0;
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
		<div id="player-div" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<iframe @if (isset($moments[0])) @if (json_decode($moments[0]->video)->provider == 'vimeo') src="https://player.vimeo.com/video/{{json_decode($moments[0]->video)->id}}?api=1" @elseif (json_decode($moments[0]->video)->provider == 'youtube') src="https://www.youtube.com/embed/{{json_decode($moments[0]->video)->id}}?enablejsapi=1" @endif @endif id="video"
			width="640" height="360" frameborder="0" allowfullscreen></iframe></div>
		@foreach($moments as $moment)
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 fixed-height video-wid">
				<img class="video-img" src="{{json_decode($moment->video)->image}}" title="{{$moment->title}}">
				<img class="video-play" data-id="$momet->id" @if (json_decode($moment->video)->provider == 'vimeo') data-link="https://player.vimeo.com/video/{{json_decode($moment->video)->id}}?api=1" @elseif (json_decode($moment->video)->provider == 'youtube') data-link="https://www.youtube.com/embed/{{json_decode($moment->video)->id}}?enablejsapi=1" @endif  src="{{asset('images/play.png')}}">
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
<script type="text/javascript" src="{{asset('js/empedplayer/embedplayer.js')}}"></script>
<script type="text/javascript" src="{{asset('js/empedplayer/youtube.js')}}"></script>
<script type="text/javascript" src="{{asset('js/empedplayer/vimeo.js')}}"></script>
<script type="text/javascript" src="{{asset('js/empedplayer/html5.js')}}"></script>
<script type="text/javascript">
	function play(){
  		$('#video').embedplayer('play');
  	}
  	function initEmbed() {
	$(this).on('embedplayer:statechange', function (event) {
		$('#state').text(event.state);
	}).on('embedplayer:error', function (event) {
		var message = event.error||'';
		if (event.title)        { message += " "+event.title; }
		else if (event.message) { message += " "+event.message; }
		$('#error').text(message);
	}).on('embedplayer:durationchange', function (event) {
		if (isFinite(event.duration)) {
			$('#currenttime').show().prop('max', event.duration);
		}
		else {
			$('#currenttime').hide();
		}
		$('#duration').text(event.duration.toFixed(2)+' seconds');
	}).on('embedplayer:timeupdate', function (event) {
		$('#currenttime').val(event.currentTime);
		$('#currenttime-txt').text(event.currentTime.toFixed(2)+' seconds');
	}).on('embedplayer:volumechange', function (event) {
		$('#volume').val(event.volume);
		$('#volume-label').text(
			event.volume <=   0 ? '🔇' :
			event.volume <= 1/3 ? '🔈' :
			event.volume <= 2/3 ? '🔉' :
								  '🔊'
		);
		$('#volume-txt').text(event.volume.toFixed(2));
	}).on('embedplayer:ready', function (event) {
		var link = $(this).embedplayer('link');
		if (link) {
			$('#link').attr('href', link);
			$('#link-wrapper').show();
		}
	}).
	embedplayer("listen").
	embedplayer('volume', function (volume) {
		$('#volume').text(volume.toFixed(2));
	});
}

function loadVideo(tag, url) {
	try {
		var attrs = {
			id: 'video',
			src: url
		};
		switch (tag) {
		case 'iframe':
			attrs.allowfullscreen = 'allowfullscreen';
			attrs.frameborder = '0';
			attrs.width = '640';
			attrs.height = '360';
			break;

		case 'video':
			attrs.width = '640';
			attrs.height = '360';
		case 'audio':
			attrs.controls = 'controls';
			attrs.preload = 'auto';
			break;
		}
		$('#link-wrapper').hide();
		$('<'+tag+'>').attr(attrs).replaceAll('#video').each(initEmbed);
	}
	catch (e) {
		$('#error').text(String(e));
	}
}
function updateVideo (value) {
	// $('#duration, #currenttime, #volume').text('?');
	// $('#state').text('loading...');
	// $('#error').text('');
	loadVideo('iframe', value);
}
	$(document).ready(function() {
	$('.navbar-fixed-top').removeClass('navbar-default');
	$('.navbar-fixed-top').addClass('navbar-inverse');

	// $('.video-play').click(function() {
	// 	var link = $(this).attr('data-link').replace('vimeo.com', 'player.vimeo.com/video').replace('youtube.com/watch?v=', 'youtube.com/embed/');
	// 	if(link == $('#play-modal').find('#player-frame').attr('src')) {
	// 		$('.ytp-play-button').click();
 //  			$('button.play').click();
	// 	}
	// 	else
	// 		$('#play-modal').find('#player-frame').attr('src',  link);
	// 	$('#play-modal').modal();
	// });
	// $('#play-modal').on('hide.bs.modal', function (e) {
  		
 //  	});
  	$('.video-play').click(function() {
  		var embed_link = $(this).attr('data-link');
  		//$('#embed').attr('src', embed_link);
  		updateVideo(embed_link);

		 $('#video').attr('onLoad', "play();");
// $('#embed').embedplayer('seek',30);
// $('#embed').embedplayer('volume',0.5);
// $('#embed').embedplayer('pause');
// $('#embed').embedplayer('stop');
  	});

$('#embed').on('embedplayer:statechange', function (event) {
	console.log('state:', event.state);
}).on('embedplayer:error', function (event) {
	console.error('error:', event.error);
}).on('embedplayer:durationchange', function (event) {
	console.log('duration:', event.duration);
}).on('embedplayer:volumechange', function (event) {
	console.log('volume:', event.volume);
}).on('embedplayer:timeupdate', function (event) {
	console.log('currentTime:', event.currentTime);
}).on('embedplayer:ready', function (event) {
	console.log('link:', $(this).embedplayer('link'));
}).embedplayer('listen'); // enable all events

  });
</script>
@endsection