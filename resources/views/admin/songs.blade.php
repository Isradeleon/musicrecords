@extends('layouts.principal')

@section('title','Uploaded songs')

@section('content')
<br><br>
<section class="container">
<div class="row">
<div class="col-sm-offset-1 col-sm-10">
<h3 align="center">Uploaded songs!</h3>
@if($count>0)
	<div class="table-responsive">
	<form method="post" enctype="multipart/form-data" action="/songs">
	{{csrf_field()}}
	<table class="table">
		<thead align="center">
			<tr>
				<th>Song name</th>
				<th>Artist</th>
				<th>Album</th>
				<th>Kind</th>
				<th>File</th>
			</tr>
		</thead>
		<tbody>
			@foreach($songs as $song)
			<tr>
				<td>{{$song->name}}</td>
				<td>{{$song->album->artist->name}}</td>
				<td>{{$song->album->name}}</td>
				<td>{{$song->album->kind->name}}</td>
				@if($song->sourceup)
				<td><span class="glyphicon glyphicon-ok"></span></td>
				@else
				<td><label class="btn btn-default btn-block file">Load song (mp3)<input style="display: none;" type="file" 
				name="song[{{$song->id}}]" accept=".mp3"></label>
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
		<button class="btn btn-success btn-lg btn-block">Upload files</button>
	</form>
	</div>
@else
<hr>
<div class="thumbnail"><h5 align="center">Ups! there're not any uploaded songs!</h5>
<h6 align="center"><strong>Upload an excel first!</strong></h6></div>
@endif
	@if(isset($msgs))
	<br>
	<div class="thumbnail">
	@foreach($msgs as $msg)
		<h6 align="center">**{{$msg}}**</h6>
	@endforeach
	</div>
	@endif
</div>	
</div>
</section>
@endsection

@section('morescripts')
<script src="/js/songs.js"></script>
@endsection