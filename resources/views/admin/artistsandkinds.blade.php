@extends('layouts.principal')

@section('title','Artists and kinds')

@section('content')
<br><br>
<section class="container">
<div class="row">
	<div style="border-radius: 0;" class="panel panel-default col-sm-6">
		<div class="panel-heading">
			<h5 align="center">Make a Kind</h5>
		</div>
		<div class="panel-body">
		<div class="col-lg-offset-2 col-lg-8">
			<form action="/music/makekind" method="post">
			{{csrf_field()}}
			<div class="form-group">
			<label class="label-control">Name:</label>
			<input placeholder="Type the new Kind's name" type="text" name="newkind" class="form-control">
			</div>
			<button class="btn btn-success btn-block">Save new Kind</button>
			</form>
		</div>
		</div>
		@if(Session::has('msgs'))
		@foreach(Session::get('msgs') as $m)
		<h6 align="center">**{{$m}}**</h6>
		@endforeach
		@endif
		<br>
	</div>
	<div style="border-radius: 0;" class="panel panel-default col-sm-6">
		<div class="panel-heading">
			<h5 align="center">Create an Artist</h5>
		</div>
		<div class="panel-body">
		<div class="col-lg-offset-2 col-lg-8">
			<form action="/music/makeartist" method="post">
			{{csrf_field()}}
			<div class="form-group">
			<label class="label-control">Name:</label>
			<input placeholder="Type the new Aritst" type="text" name="newartist" class="form-control">
			</div>
			<button class="btn btn-success btn-block">Save new Aritst</button>
			</form>
		</div>
		</div>
		@if(Session::has('msgs2'))
		@foreach(Session::get('msgs2') as $m)
		<h6 align="center">**{{$m}}**</h6>
		@endforeach
		@endif
		<br>
	</div>
@if($artistscount>0 and $kindscount>0)
	<div style="border-radius: 0;" class="panel panel-default col-sm-8">
		<div class="panel-heading">
			<h5 align="center">Add an Album</h5>
		</div>
		<div class="panel-body">
		<div class="col-lg-offset-2 col-lg-8">
		@if(Session::has('msgs3'))
		@foreach(Session::get('msgs3') as $m)
		<h6 align="center">**{{$m}}**</h6>
		@endforeach
		@endif
			<form action="/music/makealbum" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
			<label class="label-control">Name:</label>
			<input placeholder="Type the new Album" type="text" name="newalbum" class="form-control">
			</div>
			<div class="form-group">
			<label class="label-control">Album's kind of music:</label>
			<select name="kind" class="form-control">
			@foreach($kinds as $kind)
				<option value="{{$kind->id}}">{{$kind->name}}</option>
			@endforeach
			</select>
			</div>
			<div class="form-group">
			<label class="label-control">Album's artist:</label>
			<select name="artist" class="form-control">
			@foreach($artists as $artist)
				<option value="{{$artist->id}}">{{$artist->name}}</option>
			@endforeach
			</select>
			</div>
			<div class="form-group">
				<label class="btn btn-default btn-block"><strong>Select an image (.jpg) <span class="glyphicon glyphicon-folder-open"></span></strong><input style="display:none; border-radius: 0;" type="file" name="image" accept=".jpg">
				</label>
			</div>
			<button class="btn btn-success btn-block">Save new Album</button>
			</form>
		</div>
		</div>
		<br>
	</div>
@endif
</div>
</section>
@endsection