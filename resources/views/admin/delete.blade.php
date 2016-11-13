@extends('layouts.principal')

@section('title','Delete Artist | Kind')

@section('content')
<br><br>
<section class="container">
<div class="row">
	<div style="border-radius: 0;" class="panel panel-default col-sm-6">
		<div class="panel-heading">
			<h5 align="center">Dlete a Kind</h5>
		</div>
		<div class="panel-body">
		<div class="col-lg-offset-2 col-lg-8">
			<form action="/deletekind" method="post">
			{{csrf_field()}}
			<div class="form-group">
			<label class="label-control">Kind:</label>
			<select name="idkind" class="form-control">
				@foreach($thekinds as $kind)
				<option value="{{$kind->id}}">{{$kind->name}}</option>
				@endforeach
			</select>
			</div>
			<button class="btn btn-danger btn-block">Delete Kind</button>
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
			<h5 align="center">Delete an Artist</h5>
		</div>
		<div class="panel-body">
		<div class="col-lg-offset-2 col-lg-8">
			<form action="/deleteartist" method="post">
			{{csrf_field()}}
			<div class="form-group">
			<label class="label-control">Artist:</label>
			<select name="idartist" class="form-control">
				@foreach($theartists as $artist)
				<option value="{{$artist->id}}">{{$artist->name}}</option>
				@endforeach
			</select>
			</div>
			<button class="btn btn-danger btn-block">Delete Artist</button>
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
</div>
</section>
@endsection